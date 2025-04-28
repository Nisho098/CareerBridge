<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use App\Models\Application;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Mail\JobMatched;  
use App\Mail\JobReferralMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Carbon;
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
        $query = $request->get('query'); 
    
       
        $jobs = Job::with('recruiter') 
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%$query%")
                      ->orWhere('industry', 'like', "%$query%")
                      ->orWhereHas('recruiter', function ($recruiterQuery) use ($query) {
                          $recruiterQuery->where('address', 'like', "%$query%");
                      });
                });
            })
            ->where('status', 'approved')  
            ->paginate(10); 
    
        return view('frontend.StudentProfiles.search', compact('jobs'));
    }
    
    
    
 

    public function matchJob(User $user, Job $job)
{
    
    $studentProfile = $user->studentProfile;
    if (!$studentProfile) {
        Log::info("User {$user->id} has no student profile, skipping email.");
        return;
    }

    $studentSkills = array_map('trim', array_map('strtolower', explode(',', $studentProfile->skills)));
    $jobTitleWords = array_map('strtolower', explode(' ', $job->title));

    
    $matchingSkills = array_intersect($studentSkills, $jobTitleWords);

  
    Log::info("User {$user->id} Skills: " . implode(', ', $studentSkills));
    Log::info("Job {$job->id} Title Words: " . implode(', ', $jobTitleWords));
    Log::info("Matching Skills: " . implode(', ', $matchingSkills));

    
    if (!empty($matchingSkills)) {
        Mail::to($user->email)->send(new JobMatched($job, $user));
        Log::info("Job Matched Email Sent to User {$user->id} for Job {$job->id}");
    } else {
        Log::info("No title match for User {$user->id} and Job {$job->id}, skipping email.");
    }
}


public function compareSalaries(Request $request)
{
    
    $freelancingSalaries = Job::with('recruiter') 
        ->where('job_type', 'part-time') 
        ->where('status', 'approved') 
        ->whereNotNull('salary')
        ->where('salary', '>', 0) 
        ->orderBy('salary', 'desc') 
        ->get()
        ->map(function ($job) {
            $avgSalary = $job->salary;
            $salaryLabel = '';

           
            if ($job->salary_type == 'hourly') {
                $avgSalary = round($job->salary * 160, 2); 
                $salaryLabel = ' (Monthly Equivalent)';
            }

            return [
                'title' => $job->title,
                'industry' => $job->industry ?? 'N/A',
                'salary_type' => ucfirst($job->salary_type),
                'benefits' => $job->benefits ?? 'No benefits provided',
                'company_name' => $job->recruiter->name ?? 'Unknown', 
                'avg_salary' => $avgSalary,
                'salary_label' => $salaryLabel, 
                'project_duration' => $job->project_duration ?? 'Not Set', 
                'payment_terms' => $job->payment_terms ?? 'Not Set', 
            ];
        });

    return view('frontend.StudentProfiles.salary-comparison', compact('freelancingSalaries'));
}

public function showReferJobPage(Request $request)
{
    $jobs = Job::all(); 
    $candidateEmail = $request->input('candidate_email'); 

    return view('frontend.RecruiterProfiles.referJob', compact('jobs', 'candidateEmail'));
}

public function referCandidate(Request $request)
{
    Log::info('Refer Candidate method triggered', $request->all());

  
    $request->validate([
        'job_id' => 'required|exists:jobs,id',
        'original_job_id' => 'required|exists:jobs,id',
        'student_id' => 'required|exists:users,id'  
    ]);

    $job = Job::find($request->job_id);
    $student = User::find($request->student_id);

    if (!$job || !$student) {
        Log::error('Invalid job or student: ', ['job' => $request->job_id, 'student' => $request->student_id]);
        return back()->with('error', 'Invalid job or student.');
    }

    Log::info("Sending job referral email to: {$student->email}");

   
    Notification::create([
        'student_id' => $student->id,
        'message' => "You have been referred to a new job: {$job->title}.",
        'created_at' => now(),
        'updated_at' => now(),
    ]);

   
    Mail::to($student->email)->send(new JobReferralMail($job));

    return back()->with('success', 'Candidate referred successfully!');
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
