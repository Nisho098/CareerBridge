<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FreelancingController extends Controller
{
    public function index()
    {
       
        $freelancingJobs = Job::where('job_type', 'part-time')
            ->where('status', 'approved')
            ->get();
    
        $averageSalary = Job::where('job_type', 'part-time')
            ->where('status', 'approved')
            ->avg('salary') ?? 0; 
    
        return view('frontend.StudentProfiles.Freelancing', compact('freelancingJobs', 'averageSalary'));
    }
    
    

    public function showFreelancingJobs()
    {
       
        $freelancingJobs = Job::where('job_type', 'freelancing')->where('status', 'approved')->get();

        return view('frontend.StudentProfiles.dashboard', compact('freelancingJobs'));
    }
}
