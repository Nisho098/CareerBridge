@extends('frontend.StudentProfiles.dashboard') <!-- Extend from dashboard layout -->

@section('content')
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">

<div class="dashboard-main-content">

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


    <div class="box-container">
        <table class="job-listing-table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Job Type</th>
                    <th>Company</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobs as $job)
                    @if ($job->status === 'approved' && ($job->job_type === 'full-time' || $job->job_type === 'internship')) <!-- Filter Full-time and Internship jobs -->
                        <tr>
                            <td>{{ $job->title ?? 'N/A' }}</td>
                            <td>{{ ucfirst($job->job_type ?? 'N/A') }}</td>
                            <td>
                                @if ($job->recruiter)
                                    <a href="{{ route('recruiterProfile.show', ['id' => $job->recruiter->user_id]) }}" class="company-link">
                                        {{ $job->recruiter->name ?? 'No Name' }}
                                    </a>
                                @else
                                    <span>No Recruiter</span>
                                @endif
                            </td>
                            <td>{{ $job->recruiter->address ?? 'Not Provided' }}</td>
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
        </table>
    </div>
</div>


<script src="{{ asset('js/landing.js') }}" defer></script>

@endsection
