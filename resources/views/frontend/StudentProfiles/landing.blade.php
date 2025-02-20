@extends('frontend.StudentProfiles.dashboard') <!-- Extend from dashboard layout -->

@section('content')
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">

<div class="dashboard-main-content">
    <!-- Profile Section -->
    <div class="profile-section">
        <div class="profile-picture">
            <img src="{{ optional(Auth::user()->studentProfile)->profile_picture ? asset('storage/profile_pictures/' . Auth::user()->studentProfile->profile_picture) : asset('images/default-profile.jpg') }}" alt="Profile Picture">
        </div>

        <div class="profile-details">
            <h2>{{ Auth::user()->name }}</h2>
            <p><strong>Address:</strong> {{ optional(Auth::user()->studentProfile)->location ?? 'Not Provided' }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Contact:</strong> {{ optional(Auth::user()->studentProfile)->contact ?? 'Not Provided' }}</p>
        </div>
    </div>
<!-- Job Listings Section -->
<div class="box-container">
    <table class="job-listing-table">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Job Type</th>
                <th>Location</th>
                <th>Company</th> <!-- Added Company Column -->
                <th>Deadline</th>
                <th>Action</th>
            </tr>
        </thead>
    <tbody>
    @foreach ($jobs as $job)
        @if ($job->status === 'approved')  <!-- Ensure only approved jobs are shown -->
            <tr>
                <td>{{ $job->title ?? 'N/A' }}</td>
                <td>{{ ucfirst($job->job_type ?? 'N/A') }}</td>
                <td>{{ $job->location ?? 'N/A' }}</td>

                <td>
                    @if ($job->recruiterProfile && isset($job->recruiterProfile->user_id))
                        <a href="{{ route('recruiterProfile.show', $job->recruiterProfile->user_id) }}" class="company-link">
                            {{ $job->recruiterProfile->name ?? 'Company' }}
                        </a>
                    @else
                        N/A
                    @endif
                </td>

                <td>{{ $job->application_deadline ? \Carbon\Carbon::parse($job->application_deadline)->format('F j, Y') : 'No Deadline' }}</td>
                <td>
                    <div class="action-container">
                        <button class="dropdown-btn">⋮</button>
                        <div class="dropdown-menu">
                            <div class="dropdown-item">
                                <span class="icon">👁️</span>
                                <a href="{{ route('job.create', $job->id) }}" class="btn btn-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endif
    @endforeach
</tbody>


<!-- JavaScript (Placed at bottom) -->
<script src="{{ asset('js/landing.js') }}" defer></script>

@endsection

