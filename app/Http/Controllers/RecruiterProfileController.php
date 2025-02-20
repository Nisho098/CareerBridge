<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\Recruiterprofile;


class RecruiterProfileController extends Controller
{
    public function index()
{
    // Fetch jobs only associated with the logged-in recruiter
    $jobs = Job::where('recruiter_id', auth()->user()->recruiterProfile->id)->get();
    return view('frontend.RecruiterProfiles.internshiptable', compact('jobs'));
}

public function dashboard()
{
    if (Auth::check()) {
        $user = Auth::user();

        // Ensure recruiterProfile exists before accessing its ID
        if ($user->recruiterProfile) {
            $jobs = Job::where('recruiter_id', $user->recruiterProfile->id)->get();
        } else {
            $jobs = collect(); // Empty collection if no recruiter profile
        }

        if ($user->role == 'recruiter') {
            return view('frontend.RecruiterProfiles.dashboard', compact('user', 'jobs'));
        }

        return redirect()->route('dashboard');
    }

    return redirect()->route('login')->with('error', 'Please log in to access the dashboard.');
}



public function create()
{
    $user = Auth::user();
    $recruiterProfile = $user->recruiterProfile; 

    return view('frontend.RecruiterProfiles.Profile', compact('recruiterProfile'));
}


   
    public function edit()
    {
        $user = Auth::user();
        
        // Retrieve recruiter's profile or create a new one
        $recruiter = $user->recruiterProfile ?? new Recruiterprofile();
    
        return view("frontend.RecruiterProfiles.editProfile", compact('recruiter'));
    }
    public function showProfile()
{
    $user = auth()->user();
    $studentProfile = $user->studentProfile;

    

    return view('frontend.StudentProfiles.profile', compact('studentProfile'));
}

    
    


    
    public function update(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_website' => 'nullable|url|max:255',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'personaldetails' => 'nullable|string|max:500',
            'details' => 'nullable|string|max:1000',
            'aboutcompany' => 'nullable|string|max:1000', // Company document (e.g., business license)
        ]);
    
        // Get the authenticated user
        $user = auth()->user();
    
        // Retrieve the recruiter's existing profile OR create a new one
        $profile = RecruiterProfile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            $profile = new RecruiterProfile();
            $profile->user_id = $user->id;
        }
    
        // Handle company document upload
        if ($request->hasFile('company_document')) {
            $documentPath = $request->file('company_document')->store('company_documents', 'public');
            $profile->company_document = $documentPath;
        }
    
        // Update profile fields
        $profile->name = $validated['name'];
        $profile->company_website = $validated['company_website'] ?? '';
        $profile->contact_number = $validated['contact_number'] ?? '';
        $profile->address = $validated['address'] ?? '';
        $profile->personaldetails = $validated['personaldetails'] ?? '';
        $profile->details = $validated['details'] ?? '';
        $profile->aboutcompany = $validated['aboutcompany'] ?? '';
    
        // Save the profile (update existing or create new if necessary)
        $profile->save();
    
        // Redirect with success message
        return redirect()->route('recruiterProfile.create')->with('success', 'Recruiter profile updated successfully!');
    }
    

    

// Show applications for a specific job
public function showApplications($jobId = null)
{
    if ($jobId) {
        // Fetch the job and its applications, with the associated job details
        $job = Job::findOrFail($jobId);
        $applications = Application::with('job')->where('job_id', $jobId)->get();
    } else {
        // Fetch all applications if no specific job is selected
        $applications = Application::with('job')->get();
        $job = null; // Define $job to prevent "Undefined variable" error
    }

    return view('frontend.RecruiterProfiles.jobApplication', compact('job', 'applications'));
}


public function rejectApplication($applicationId)
{
    $application = Application::findOrFail($applicationId);
    $application->update(['application_status' => 'rejected']);

    return redirect()->back()->with('success', 'Application rejected successfully.');
}
public function scheduleInterview($applicationId)
{
    $application = Application::findOrFail($applicationId);
    $application->update(['application_status' => 'under review']);

    // Optionally, set interview date or other details
    // $application->update(['interview_date' => now()]);

    return redirect()->back()->with('success', 'Interview scheduled successfully.');
}









}
