<?php

namespace App\Http\Controllers;
use Illuminate\support\facades\Auth;
use App\Models\Recruiterprofile;

use Illuminate\Http\Request;
use App\Models\Job;


class PostInternshipController extends Controller
{
    public function index()
    {
        // Get the recruiter profile for the authenticated user
        $recruiterProfile = Recruiterprofile::where('user_id', auth()->user()->id)->first();
    
        if (!$recruiterProfile) {
            return redirect()->back()->with('error', 'Recruiter profile does not exist.');
        }
    
        // Get only the jobs associated with the logged-in recruiter
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
    



/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
    return view('frontend.RecruiterProfiles.postinternship');
}







/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
// In your store method
public function store(Request $request)
{
    // Validate the incoming data
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|nullable|string|max:255',
        'job_type' => 'required|string|in:full-time,part-time,internship',
        'industry' => 'required|nullable|string|max:255',
        'requirements' => 'required|nullable|string',
        'application_deadline' => 'required|nullable|date|after_or_equal:today',
       
    ]);

    // Get the recruiter profile associated with the authenticated user
    $recruiterProfile = Recruiterprofile::where('user_id', auth()->user()->id)->first();

    if (!$recruiterProfile) {
        return redirect()->back()->with('error', 'Recruiter profile does not exist. Please complete your profile first.');
    }

    // Create a new Job entry
    $job = new Job;

    // Set job details
    
    $job->title = $request->title;
    $job->description = $request->description;
    $job->location = $request->location;
    $job->job_type = $request->job_type;
    $job->industry = $request->industry;
    $job->requirements = $request->requirements;
    $job->application_deadline = $request->application_deadline;
    $job->status = 'pending'; 
    
    // Set the correct recruiter_id based on the recruiter profile
    $job->recruiter_id = $recruiterProfile->id; 

    // Save the job
    $job->save();

    // Redirect with success message
    return redirect()->route('postinternships.tablecreate')->with('success', 'Internship posted successfully!');
}








/**
 * Display the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function show($id)
{
   
}

/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function edit($id)
{
    // Find the job
    $job = Job::findOrFail($id);

    // Check if the logged-in user is the one who posted the job
    // if ($job->recruiter_id !== auth()->user()->id) {
    //     return redirect()->route('postinternships.tablecreate')->with('error', 'You are not authorized to edit this job.');
    // }

    // Proceed to edit the job
    return view("frontend.RecruiterProfiles.internshipedit", ['job' => $job]);
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
    $job = Job::findOrFail($id);

    // Validate the request
    $request->validate([
        "title" => "required|string|max:255",
        "description" => "required|string",
        "location" => "required|string|max:255",
        "job_type" => "required|string",
        "industry" => "required|string|max:255",
        "application_deadline" => "required|date",
    ]);

    // Update the job
    $job->update([
       'title' => $request->title,
       'description' => $request->description,
       'location' => $request->location,
       'job_type' => $request->job_type,
       'industry' => $request->industry,
       'application_deadline' => $request->application_deadline,
    ]);

    // Redirect with a success message
    return redirect()->route('postinternships.tablecreate')->with('success', 'Job updated successfully.');
}


/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function destroy($id)
{
    $job = Job::findOrFail($id);
    $job->delete();
    return redirect()->back()->with('success', 'Job deleted successfully.');

}
}


