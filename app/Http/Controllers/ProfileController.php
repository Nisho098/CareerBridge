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
    
        
        $studentProfile = StudentProfile::firstOrCreate(
            ['user_id' => $user->id], 
            ['profile_picture' => null, 'name' => $user->name] 
        );
    
        $jobs = Job::all(); 
    
        return view('frontend.StudentProfiles.landing', compact('user', 'jobs', 'studentProfile'));
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $studentProfile = StudentProfile::firstOrCreate(['user_id' => $user->id]);

       
        if ($studentProfile->profile_picture) {
            Storage::delete('public/profile_pictures/' . $studentProfile->profile_picture);
        }

      
        $imageName = time() . '.' . $request->profile_picture->getClientOriginalExtension();
        $request->profile_picture->storeAs('public/profile_pictures', $imageName);

        
        $studentProfile->update(['profile_picture' => $imageName]);

        return back()->with('success', 'Profile picture uploaded successfully!');
    }
}
