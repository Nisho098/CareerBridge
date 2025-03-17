<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Http;
use App\Models\Recruiterprofile;
use App\Models\Notification;


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
    public function showProfile($id)
    {
        $recruiterProfile = RecruiterProfile::where('user_id', $id)->first();
    
        if (!$recruiterProfile) {
            return redirect()->back()->with('error', 'Recruiter profile not found.');
        }
    
        return view('frontend.RecruiterProfiles.profile', compact('recruiterProfile'));
    }
    

    function getCoordinatesFromOSM($address)
{
    $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($address) . "&format=json&limit=1";
    $response = Http::get($url);
    $data = $response->json();

    if (!empty($data)) {
        return [
            'latitude' => $data[0]['lat'],
            'longitude' => $data[0]['lon']
        ];
    }

    return null;
}
    


    
    


    
public function update(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'company_website' => 'nullable|url|max:255',
        'contact_number' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'street' => 'nullable|string|max:255',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'personaldetails' => 'nullable|string|max:500',
        'details' => 'nullable|string|max:1000',
        'aboutcompany' => 'nullable|string|max:1000',
    ]);

    $user = auth()->user();
    $profile = RecruiterProfile::firstOrNew(['user_id' => $user->id]);

    if ($request->hasFile('company_document')) {
        $documentPath = $request->file('company_document')->store('company_documents', 'public');
        $profile->company_document = $documentPath;
    }

    $profile->name = $validated['name'];
    $profile->company_website = $validated['company_website'] ?? null;
    $profile->contact_number = $validated['contact_number'] ?? null;
    $profile->address = $validated['address'] ?? null;
    $profile->street = $validated['street'] ?? null;
    $profile->latitude = $request->filled('latitude') ? $validated['latitude'] : null;
    $profile->longitude = $request->filled('longitude') ? $validated['longitude'] : null;
    
    $profile->personaldetails = $validated['personaldetails'] ?? null;
    $profile->details = $validated['details'] ?? null;
    $profile->aboutcompany = $validated['aboutcompany'] ?? null;

    $profile->save();

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

    // Update the application status
    $application->update(['application_status' => 'rejected']);

    // Create a notification for the student
    $student = User::findOrFail($application->student_id);
    Notification::create([
        'student_id' => $student->id, // use student_id here
        'message' => "Your application for {$application->job->title} has been rejected.",
        'type' => 'rejected'
    ]);

    return redirect()->back()->with('success', 'Application rejected successfully.');
}

public function scheduleInterview($applicationId)
{
    $application = Application::findOrFail($applicationId);

    // Update the application status to "accepted"
    $application->update(['application_status' => 'accepted']);

    // Create a notification for the student
    $student = User::findOrFail($application->student_id);
    Notification::create([
        'student_id' => $student->id, // use student_id here
        'message' => "Congratulations! Your application for {$application->job->title} has been accepted.",
        'type' => 'accepted'
    ]);

    return redirect()->back()->with('success', 'Application is now accepted.');
}












}
