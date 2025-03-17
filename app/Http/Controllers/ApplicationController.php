<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Application;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function showApplications($jobId = null)
    {
        $recruiterProfile = auth()->user()->recruiterProfile;
    
        if (!$recruiterProfile) {
            return redirect()->back()->with('error', 'Recruiter profile does not exist.');
        }
    
        // Make sure to fetch only applications for the jobs posted by the logged-in recruiter
        $applicationsQuery = Application::whereHas('job', function ($query) use ($recruiterProfile) {
            $query->where('recruiter_id', $recruiterProfile->id);
        });
    
        // If a specific job ID is provided, filter by that job
        if ($jobId) {
            $applicationsQuery->where('job_id', $jobId);
        }
    
        // Ensure fresh data (avoids caching issues)
        $applications = $applicationsQuery->with(['student', 'job'])->get();
    
        // Debugging to ensure correct recruiter filtering
        foreach ($applications as $application) {
            if ($application->job) {
                Log::info("Application ID: {$application->id} | Job ID: {$application->job_id} | Recruiter ID for Job: {$application->job->recruiter_id} | Logged-in Recruiter ID: {$recruiterProfile->id}");
            } else {
                Log::warning("Application ID: {$application->id} has no associated job!");
            }
        }
    
        return view('frontend.RecruiterProfiles.jobApplication', compact('applications'));
    }
    
    public function apply($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to apply for a job.');
        }
    
        // Ensure the job exists and is approved (if applicable)
        $job = Job::where('id', $id)->where('status', 'approved')->first();
    
        if (!$job) {
            return redirect()->back()->with('error', 'The job is not available or has not been approved.');
        }
    
        return view('apply.create', compact('job'));
    }
    
    
    
    

    
    

    public function create($job_id)
    {
        $job = Job::findOrFail($job_id); // Fetch the job by its ID
        return view('frontend.RecruiterProfiles.apply', compact('job')); // Pass the job to the view
    }

    public function store(Request $request, $job_id)
    {
        try {
            Log::info('Application request received', [
                'job_id' => $job_id,
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
            ]);

            // Validate the cover letter file
            $validated = $request->validate([
                'cover_letter' => 'required|file|mimes:pdf,doc,docx|max:10240', // File validation
            ]);

            $user = Auth::user();
            $studentProfile = $user->studentProfile; // Get the student's profile

            // Check if the student's profile exists
            if (!$studentProfile) {
                return redirect()->back()->with('error', 'Student profile not found. Please complete your profile.');
            }

            // Check if the student has a resume in their profile
            if (!$studentProfile->resume_url) {
                return redirect()->back()->with('error', 'Please upload your resume in your profile before applying.');
            }

            // Check if the job exists
            $job = Job::find($job_id);
            if (!$job) {
                return redirect()->back()->with('error', 'Job not found.');
            }

            // Check if the student has already applied for this job
            $existingApplication = Application::where('student_id', $studentProfile->id)
                                              ->where('job_id', $job_id)
                                              ->first();

            if ($existingApplication) {
                return redirect()->back()->with('error', 'You have already applied for this job.');
            }

            // Handle file upload for the cover letter
            if ($request->hasFile('cover_letter')) {
                $file = $request->file('cover_letter');

                if ($file->isValid()) {
                    // Store the file in the 'public/cover_letters' directory
                    $coverLetterPath = $file->store('cover_letters', 'public');
                    Log::info('Cover Letter stored successfully', ['path' => $coverLetterPath]);
                } else {
                    return redirect()->back()->with('error', 'There was an issue with your cover letter file.');
                }
            } else {
                return redirect()->back()->with('error', 'Cover letter file is required.');
            }

            // Save the application to the database
            $application = new Application();
            $application->student_id = $studentProfile->id;
            $application->job_id = $job_id;
            $application->cover_letter = $coverLetterPath;
            $application->application_status = 'submitted'; // Default status
            $application->save();

            Log::info('Application stored in database', ['application_id' => $application->id]);

            return redirect()->route('StudentProfile.showStudentApplications')
            ->with('success', 'Application submitted successfully.');
        
        } catch (\Exception $e) {
            Log::error('Error saving application: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


   // Add this at the top
public function updateStatus(Request $request, $id)
{
    $application = Application::find($id);
    
    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    // Ensure status is valid
    $validStatuses = ['submitted', 'in_review', 'rejected', 'accepted'];
    if (!in_array($request->status, $validStatuses)) {
        return redirect()->back()->with('error', 'Invalid status.');
    }

    $application->application_status = $request->status;
    $application->save();

    return redirect()->back()->with('success', 'Application status updated.');
}


    
}
