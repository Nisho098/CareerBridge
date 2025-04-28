@extends('frontend.RecruiterProfiles.dashboard')

@section('content')
@csrf

<link rel="stylesheet" href="{{ asset('css/application.css') }}">

<div class="container">
    <h1>Candidate Applications 
    </h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Empty State -->
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
                </div>

                <!-- Action Section -->
                <div class="application-actions" style="margin-top: 10px;">
                    @if ($application->application_status === 'submitted')
                        <form action="{{ route('recruiter.rejectApplication', $application->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>

                        <form action="{{ route('recruiter.scheduleInterview', $application->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-primary">Approve</button>
                        </form>
                    @endif

                    <a href="{{ route('job.showReferPage') }}" class="btn btn-warning" style="margin-left: 10px;">Refer Candidate</a>

                    <!-- Status Display -->
                    @if ($application->application_status === 'accepted')
                        <div class="application-status approved" style="margin-top: 10px;">
                            Approved
                        </div>
                    @elseif ($application->application_status === 'rejected')
                        <div class="application-status rejected" style="margin-top: 10px;">
                            Rejected
                        </div>
                    @elseif ($application->application_status === 'under review')
                        <div class="application-status under-review" style="margin-top: 10px;">
                            Under Review
                        </div>
                    @elseif ($application->application_status === 'pending') <!-- Corrected check for 'pending' status -->
                        <div class="application-status pending" style="margin-top: 10px;">
                            Pending
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
