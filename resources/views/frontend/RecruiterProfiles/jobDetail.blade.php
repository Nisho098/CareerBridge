@extends('frontend.StudentProfiles.dashboard') <!-- Extend from dashboard layout -->

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
     <!-- CSS -->
     <link rel="stylesheet" href="{{ asset('css/jobDetails.css') }}">
</head>
<body>
    <header>
        <h1>Job Details</h1>
    </header>
    <main>
        <section class="job-details">
            <h2>{{ $job->title }}</h2>
            <p><strong>Location:</strong> {{ $job->location }}</p>
            <p><strong>Industry:</strong> {{ $job->industry }}</p>
            <p><strong>Type:</strong> {{ $job->job_type }}</p>
            <p><strong>Description:</strong> {{ $job->description }}</p>
            <p><strong>Requirements:</strong> {{ $job->requirements }}</p>
            <p><strong>Deadline:</strong> {{ $job->application_deadline }}</p>

       

            <a href="{{ route('apply.create', $job->id) }}" class="btn">Apply Now</a>
        </section>
    </main>
</body>
</html>

@endsection
