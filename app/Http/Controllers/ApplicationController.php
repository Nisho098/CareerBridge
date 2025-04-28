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
  

    
    
    public function apply($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to apply for a job.');
        }
    
       
        $job = Job::where('id', $id)->where('status', 'approved')->first();
    
        if (!$job) {
            return redirect()->back()->with('error', 'The job is not available or has not been approved.');
        }
    
        return view('frontend.RecruiterProfiles.apply', compact('job'));  
    }
    

    
    
    
    

    
    

    public function create($job_id)
    {
        $job = Job::findOrFail($job_id); 
        return view('frontend.RecruiterProfiles.apply', compact('job')); 
    }

    public function store(Request $request, $job_id)
    {
        try {
            Log::info('Application request received', [
                'job_id' => $job_id,
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
            ]);

            
            $validated = $request->validate([
                'cover_letter' => 'required|file|mimes:pdf,doc,docx|max:10240', 
            ]);

            $user = Auth::user();
            $studentProfile = $user->studentProfile; 

         
            if (!$studentProfile) {
                return redirect()->back()->with('error', 'Student profile not found. Please complete your profile.');
            }

            
            if (!$studentProfile->resume_url) {
                return redirect()->back()->with('error', 'Please complete your profile before applying.');
            }

         
            $job = Job::find($job_id);
            if (!$job) {
                return redirect()->back()->with('error', 'Job not found.');
            }

           
            $existingApplication = Application::where('student_id', $studentProfile->id)
                                              ->where('job_id', $job_id)
                                              ->first();

            if ($existingApplication) {
                return redirect()->back()->with('error', 'You have already applied for this job.');
            }

           
            if ($request->hasFile('cover_letter')) {
                $file = $request->file('cover_letter');

                if ($file->isValid()) {
                   
                    $coverLetterPath = $file->store('cover_letters', 'public');
                    Log::info('Cover Letter stored successfully', ['path' => $coverLetterPath]);
                } else {
                    return redirect()->back()->with('error', 'There was an issue with your cover letter file.');
                }
            } else {
                return redirect()->back()->with('error', 'Cover letter file is required.');
            }

        
            $application = new Application();
            $application->student_id = $studentProfile->id;
            $application->job_id = $job_id;
            $application->cover_letter = $coverLetterPath;
            $application->application_status = 'submitted'; 
            $application->save();

            Log::info('Application stored in database', ['application_id' => $application->id]);

            return redirect()->route('StudentProfile.showStudentApplications')
            ->with('success', 'Application submitted successfully.');
        
        } catch (\Exception $e) {
            Log::error('Error saving application: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


  
public function updateStatus(Request $request, $id)
{
    $application = Application::find($id);
    
    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

  
    $validStatuses = ['submitted', 'in_review', 'rejected', 'accepted'];
    if (!in_array($request->status, $validStatuses)) {
        return redirect()->back()->with('error', 'Invalid status.');
    }

    $application->application_status = $request->status;
    $application->save();

    return redirect()->back()->with('success', 'Application status updated.');
}


    
}
