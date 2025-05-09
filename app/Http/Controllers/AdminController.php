<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        return view('frontend.AdminPage.dashboard');

    }

    public function manageUsers()
    {
        $users = User::all(); 
        return view('frontend.AdminPage.users', compact('users'));
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
    

    public function showPendingJobs()
{$jobs = Job::with('recruiter')->where('status', 'pending')->get();

    
    return view('frontend.AdminPage.approved', compact('jobs'));
}

public function approveJob($id)
{
    $job = Job::findOrFail($id);
    $job->status = 'approved';
    $job->save();

    
    $jobTitleWords = array_map('strtolower', explode(' ', $job->title));

   
    $students = User::where('role', 'student')
        ->whereHas('studentProfile', function ($query) use ($jobTitleWords) {
            $query->where(function ($q) use ($jobTitleWords) {
                foreach ($jobTitleWords as $word) {
                    $q->orWhereRaw("LOWER(skills) LIKE ?", ["%{$word}%"]);
                }
            });
        })
        ->get();

  
    Log::info("Matching students for Job ID {$job->id}: " . $students->pluck('id')->join(', '));

   
    foreach ($students as $student) {
        app(JobController::class)->matchJob($student, $job);
    }

    return redirect()->back()->with('success', 'Job approved and matching students notified!');
}






public function deleteJob($id)
{
    $job = Job::findOrFail($id);
    $job->delete();

    return redirect()->back()->with('success', 'Job deleted successfully.');
}

public function jobs()
{
    $jobs = Job::all();
    return view('frontend.AdminPage.Jobs', compact('jobs')); 
}
public function destroyjob($id)
{
    $job = Job::findOrFail($id);
    $job->delete();

    return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
}

}
