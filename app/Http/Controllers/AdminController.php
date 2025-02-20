<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Job;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('frontend.AdminPage.dashboard');

    }

    public function manageUsers()
    {
        $users = User::all(); // Fetch all users
        return view('frontend.AdminPage.users', compact('users'));
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
    

    public function showPendingJobs()
{
    $jobs = Job::where('status', 'pending')->get(); // Fetch only jobs awaiting approval
    return view('frontend.AdminPage.approved', compact('jobs'));
}

public function approveJob($id)
{
    $job = Job::findOrFail($id);
    $job->status = 'approved'; // Change status
    $job->save();

    return redirect()->back()->with('success', 'Job approved successfully!');
}

public function deleteJob($id)
{
    $job = Job::findOrFail($id);
    $job->delete();

    return redirect()->back()->with('success', 'Job deleted successfully.');
}




}
