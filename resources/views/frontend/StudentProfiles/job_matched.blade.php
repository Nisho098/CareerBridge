<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Match Notification</title>
</head>
<body>
    <h1>Congratulations, {{ $user->name }}!</h1>
    <p>We found a job that matches your profile:</p>
    <h2>{{ $job->title }}</h2>
    <p><strong>Company:</strong> {{ $job->industry }}</p>
    <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($job->application_deadline)->format('F j, Y') }}</p>
    
 
    @if(auth()->check())
        <a href="{{ route('jobs.show', $job->id) }}">View Job Details</a>
    @else
        <p><strong>Note:</strong> You need to <a href="{{ route('login') }}">log in</a> to view the job details.</p>
    @endif
</body>
</html>
