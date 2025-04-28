<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Recruiterprofile;
use Illuminate\Http\Request;
use App\Models\Job;

class PostInternshipController extends Controller
{
    public function index()
    {
        $recruiterProfile = Recruiterprofile::where('user_id', auth()->user()->id)->first();
    
        if (!$recruiterProfile) {
            return redirect()->back()->with('error', 'Recruiter profile does not exist.');
        }
    
        $jobs = Job::where('recruiter_id', $recruiterProfile->id)->get();
    
        return view('frontend.RecruiterProfiles.internshiptable', compact('jobs'));
    }
    
    public function tablecreate()
    {
        $recruiterProfile = Recruiterprofile::where('user_id', auth()->user()->id)->first();
        if (!$recruiterProfile) {
            return redirect()->back()->with('error', 'Recruiter profile does not exist.');
        }
        $jobs = Job::where('recruiter_id', $recruiterProfile->id)->get();
        return view('frontend.RecruiterProfiles.internshiptable', compact('jobs'));
    }

    public function create()
    {
        return view('frontend.RecruiterProfiles.postinternship');
    }

    public function store(Request $request)
{
   
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'salary' => 'nullable|numeric|min:0',
        'salary_type' => 'required|in:hourly,monthly,project-based',
        'benefits' => 'nullable|string',
        
        'job_type' => 'required|string|in:full-time,part-time,internship',
        'industry' => 'nullable|string|max:255', 
        'requirements' => 'required|nullable|string', 
        'application_deadline' => 'nullable|date|after_or_equal:today', 
        'project_duration' => 'nullable|string|max:255', 
        'payment_terms' => 'nullable|string|max:255', 
    ], [
       
        'title.required' => 'The job title is required.',
        'description.required' => 'Please enter a job description.',
        'job_type.required' => 'Please select a job type.',
        'job_type.in' => 'Invalid job type selected.',
        'application_deadline.date' => 'The application deadline must be a valid date.',
        'application_deadline.after_or_equal' => 'The deadline cannot be in the past.',
    ]);

    
    $recruiterProfile = Recruiterprofile::where('user_id', auth()->user()->id)->first();

    if (!$recruiterProfile) {
        return redirect()->back()->with('error', 'Recruiter profile does not exist. Please complete your profile first.');
    }

   
    if (!empty($validatedData['benefits'])) {
        $validatedData['benefits'] = explode(',', $validatedData['benefits']);
    } else {
        $validatedData['benefits'] = []; 
    }

  
    $job = new Job;
    $job->title = $validatedData['title'];
    $job->description = $validatedData['description'];
   
    $job->job_type = $validatedData['job_type'];
    $job->industry = $validatedData['industry'];
    $job->requirements = $validatedData['requirements'];
    $job->application_deadline = $validatedData['application_deadline'];
    $job->salary = $validatedData['salary'];
    $job->salary_type = $validatedData['salary_type'];
    $job->benefits = $validatedData['benefits'];
    $job->status = 'pending'; 
    $job->recruiter_id = $recruiterProfile->id;

    
    if ($validatedData['job_type'] === 'part-time') {
        $job->project_duration = $validatedData['project_duration'];
        $job->payment_terms = $validatedData['payment_terms'];
    } else {
        
        $job->project_duration = null;
        $job->payment_terms = null;
    }

    
    $job->save();

    return redirect()->route('postinternships.tablecreate')->with('success', 'Internship posted successfully!');
}


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        return view("frontend.RecruiterProfiles.internshipedit", ['job' => $job]);
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "requirements"=>"required|string",
            "job_type" => "required|string",
            "industry" => "required|string|max:255",
            "application_deadline" => "required|date",
        ]);

        $job->update([
            'title' => $request->title,
            'description' => $request->description,
           'requirements'=>$request->requirements,
            'job_type' => $request->job_type,
            'industry' => $request->industry,
            'application_deadline' => $request->application_deadline,
        ]);

        return redirect()->route('postinternships.tablecreate')->with('success', 'Internship updated successfully!');
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return redirect()->back()->with('success', 'Job deleted successfully.');
    }
}
