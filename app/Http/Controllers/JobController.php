<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use App\Mail\JobMatched;  
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Log;


class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->get('query'); // Get the search query
    
        // Filter jobs based on query (search by title, company, or location)
        $jobs = Job::when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('title', 'like', "%$query%")
                    ->orWhere('industry', 'like', "%$query%")
                    ->orWhere('location', 'like', "%$query%");
            })
            ->paginate(10); // Paginate results for better performance
    
     
    
        
        return view('frontend.StudentProfiles.search', compact('jobs'));
    }
    
 

    public function matchJob(User $user, Job $job)
{
    // Get student profile and skills
    $studentProfile = $user->studentProfile;
    if (!$studentProfile) {
        Log::info("User {$user->id} has no student profile, skipping email.");
        return;
    }

    $studentSkills = array_map('trim', array_map('strtolower', explode(',', $studentProfile->skills)));
    $jobTitleWords = array_map('strtolower', explode(' ', $job->title));

    // Find matching words between student skills and job title
    $matchingSkills = array_intersect($studentSkills, $jobTitleWords);

    // ✅ Debugging: Log skills comparison
    Log::info("User {$user->id} Skills: " . implode(', ', $studentSkills));
    Log::info("Job {$job->id} Title Words: " . implode(', ', $jobTitleWords));
    Log::info("Matching Skills: " . implode(', ', $matchingSkills));

    // Send email **ONLY IF at least one skill matches job title**
    if (!empty($matchingSkills)) {
        Mail::to($user->email)->send(new JobMatched($job, $user));
        Log::info("Job Matched Email Sent to User {$user->id} for Job {$job->id}");
    } else {
        Log::info("No title match for User {$user->id} and Job {$job->id}, skipping email.");
    }
}

public function compareSalaries(Request $request)
{
    // Fetch freelancing (part-time) jobs with required fields
    $freelancingSalaries = Job::with('recruiter') // Get recruiter details
        ->where('job_type', 'part-time') // Only freelancing jobs
        ->where('status', 'approved') // Only approved jobs
        ->whereNotNull('salary')
        ->where('salary', '>', 0) // Exclude unrealistic salaries
        ->orderBy('salary', 'desc') // Sort by salary (high to low) by default
        ->get()
        ->map(function ($job) {
            $avgSalary = $job->salary;
            $salaryLabel = '';

            // Convert hourly salaries to monthly equivalent
            if ($job->salary_type == 'hourly') {
                $avgSalary = round($job->salary * 160, 2); // 160 hours/month
                $salaryLabel = ' (Monthly Equivalent)';
            }

            return [
                'title' => $job->title,
                'industry' => $job->industry ?? 'N/A',
                'salary_type' => ucfirst($job->salary_type),
                'benefits' => $job->benefits ?? 'No benefits provided',
                'company_name' => $job->recruiter->name ?? 'Unknown', // Recruiter name
                'avg_salary' => $avgSalary,
                'salary_label' => $salaryLabel, // Add a label for converted salaries
                'project_duration' => $job->project_duration ?? 'Not Set', // Include project duration
                'payment_terms' => $job->payment_terms ?? 'Not Set', // Include payment terms
            ];
        });

    return view('frontend.StudentProfiles.salary-comparison', compact('freelancingSalaries'));
}



 




    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $job = Job::findOrFail($id); // Fetch the job by ID
        return view('frontend.RecruiterProfiles.jobdetail', compact('job')); // Pass the job to the view
    }

    public function show($id)
{
    $job = Job::findOrFail($id); // Fetch job by ID

    return view('frontend.RecruiterProfiles.jobdetail', compact('job')); // Pass job to view
}

    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
