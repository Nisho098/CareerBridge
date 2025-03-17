<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

use App\Models\StudentProfile;
use Illuminate\Support\Facades\Storage;
use App\Models\Application;

class StudentProfileController extends Controller
{
    public function dashboard()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role == 'student') {
                $jobs = Job::all();
                return view('frontend.StudentProfiles.dashboard', compact('user', 'jobs'));
            }

            return redirect()->route('recruiterdashboard');
        }

        return redirect()->route('login')->with('error', 'Please log in to access the dashboard.');
    }

    public function create()
    {
        $user = Auth::user();
        $studentProfile = $user->studentProfile; // Using the same variable name as in the view
        return view('frontend.StudentProfiles.Profile', compact('user', 'studentProfile'));
    }
    

    public function edit()
    {
        $user = Auth::user();
        return view("frontend.StudentProfiles.editProfile", ['user' => $user]);
    }

    public function show($id)
{
    // Find the student profile by user ID
    $studentProfile = StudentProfile::where('user_id', $id)->first();

   

    return view('frontend.StudentProfiles.profile', compact('studentProfile'));
}

    
    

    public function update(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'nullable|string|max:1000',
            'university_name' => 'nullable|string|max:255',
            'skills' => 'nullable|string|max:500',
            'contact' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
            'resume_url' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Check if the user has an existing profile, or create a new one
        $profile = $user->studentProfile ?? new StudentProfile();
        $profile->user_id = $user->id;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $imagePath = $profilePicture->storeAs('public/profile_pictures', time() . '.' . $profilePicture->getClientOriginalExtension());

            // Delete the old profile picture if exists
            if ($profile->profile_picture) {
                Storage::delete('public/profile_pictures/' . $profile->profile_picture);
            }

            $profile->profile_picture = basename($imagePath);
        }

        // Update profile fields
        $profile->name = $validated['name'];
        $profile->about = $validated['about'] ?? '';
        $profile->university_name = $validated['university_name'] ?? '';
        $profile->skills = $validated['skills'] ?? '';
        $profile->contact = $validated['contact'] ?? '';
        $profile->location = $validated['location'] ?? '';

    // Handle file upload for resume
if ($request->hasFile('resume_url')) {
   
    $customName = 'Resume.pdf';

    $resumePath = $request->file('resume_url')->storeAs('resumes', $customName, 'public');

    $profile->resume_url = $resumePath;
}

        // Save the profile
        $profile->save();

        // Redirect with a success message
        return redirect()->route('studentProfile.create')->with('success', 'Profile updated successfully!');
    }

    public function showStudentApplications()
    {
        $user = auth()->user();
        $studentProfile = $user->studentProfile;

        // Fetch applications for the logged-in student
        $applications = Application::where('student_id', $studentProfile->id)->get();

        return view('frontend.StudentProfiles.application', compact('applications'));
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
