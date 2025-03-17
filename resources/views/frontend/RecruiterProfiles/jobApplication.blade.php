@extends('frontend.RecruiterProfiles.dashboard')

@section('content')
@csrf
<link rel="stylesheet" href="{{ asset('css/application.css') }}">

<div class="container">
    <h1>Candidate Applications for: 
        @if(isset($job))
            {{ $job->title }}
        @else
            All Jobs
        @endif
    </h1>

    <!-- Check for success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($applications->isEmpty())
        <div class="alert alert-warning">
            No applications have been submitted yet.
        </div>
    @else
        @foreach($applications as $application)
            <div class="application-card">
                <h2>
                    <a href="{{ route('studentProfile.show', $application->student->user_id) }}" class="student-link">
                        {{ $application->student->name }}
                    </a>
                </h2>

                <p><strong>Email:</strong> {{ $application->student->user->email }}</p>
                <p><strong>Phone:</strong> {{ $application->student->contact ?? 'Not Provided' }}</p>
                <p><strong>Location:</strong> {{ $application->student->location ?? 'N/A' }}</p>

                <p><strong>Skills:</strong>
                    @php
                        $skills = json_decode($application->student->skills, true);
                    @endphp
                    @if(is_array($skills))
                        {{ implode(', ', $skills) }}
                    @else
                        {{ $application->student->skills ?? 'N/A' }}
                    @endif
                </p>

                <!-- Job, Job Type & Resume Section -->
                <div class="application-footer">
                    <div>
                        <strong>Applied for Job:</strong> {{ $application->job->title }}
                    </div>
                    <div>
                        <strong>Job Type:</strong> {{ ucfirst($application->job->job_type) }}
                    </div>
                    <a href="{{ asset('storage/resumes/' . $application->resume) }}" 
   class="resume-link" 
   download="{{ $application->resume }}" 
   target="_blank">
   Download CoverLetter
</a>


                <!-- Action Buttons & Status -->
                <div class="application-actions">
                    <form action="{{ route('recruiter.rejectApplication', $application->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>

                    <form action="{{ route('recruiter.scheduleInterview', $application->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Approve</button>
                    </form>

                    <!-- Status Display (Right Side) -->
                    <div class="application-status">
                        @if ($application->application_status == 'approved')
                            <span class="status approved">Approved</span>
                        @elseif ($application->application_status == 'rejected')
                            <span class="status rejected">Rejected</span>
                        @else
                            <span class="status pending">Pending</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

@endsection
