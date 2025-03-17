<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FreelancingController extends Controller
{
    public function index()
    {
        // Get freelancing (part-time) jobs
        $freelancingJobs = Job::where('job_type', 'part-time')
            ->where('status', 'approved')
            ->get();
    
        // Calculate average salary for freelancing jobs (handle null case)
        $averageSalary = Job::where('job_type', 'part-time')
            ->where('status', 'approved')
            ->avg('salary') ?? 0; // If no jobs found, default to 0
    
        return view('frontend.StudentProfiles.Freelancing', compact('freelancingJobs', 'averageSalary'));
    }
    
    

    public function showFreelancingJobs()
    {
        // Fetch jobs with 'freelancing' job type
        $freelancingJobs = Job::where('job_type', 'freelancing')->where('status', 'approved')->get();

        return view('frontend.StudentProfiles.dashboard', compact('freelancingJobs'));
    }
}
