<!DOCTYPE html>
<html>
<head>
    <title>New Job Referral</title>
</head>
<body>
    <h2>You have been referred to a new job!</h2>
    <p><strong>Job Title:</strong> {{ $jobTitle }}</p>
    <p><strong>Company:</strong> {{ $jobIndustry }}</p>
   
    <p><strong>Application Deadline:</strong> {{ \Carbon\Carbon::parse($jobDeadline)->format('F j, Y') }}</p>
 
    @if(auth()->check())
        <a href="{{ route('jobs.show', $job->id) }}">View Job Details</a>
    @else
        <p><strong>Note:</strong> You need to <a href="{{ route('login') }}">log in</a> to view the job details.</p>
    @endif
</body>
</html>
