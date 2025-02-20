<?php

// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function dindex()
    {
        $user = Auth::user();
    
        // Ensure StudentProfile exists or create a new one
        $studentProfile = StudentProfile::firstOrCreate(
            ['user_id' => $user->id], 
            ['profile_picture' => null, 'name' => $user->name] // Set the name from the user
        );
    
        $jobs = Job::all(); // Fetch all job listings
    
        return view('frontend.StudentProfiles.landing', compact('user', 'jobs', 'studentProfile'));
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $studentProfile = StudentProfile::firstOrCreate(['user_id' => $user->id]);

        // Delete old profile picture if exists
        if ($studentProfile->profile_picture) {
            Storage::delete('public/profile_pictures/' . $studentProfile->profile_picture);
        }

        // Store the new profile picture
        $imageName = time() . '.' . $request->profile_picture->getClientOriginalExtension();
        $request->profile_picture->storeAs('public/profile_pictures', $imageName);

        // Update the student's profile picture in the database
        $studentProfile->update(['profile_picture' => $imageName]);

        return back()->with('success', 'Profile picture uploaded successfully!');
    }
}
