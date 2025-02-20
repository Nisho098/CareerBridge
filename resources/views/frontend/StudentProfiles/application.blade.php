
@extends('frontend.StudentProfiles.dashboard') <!-- Extend from dashboard layout -->

@section('content')
    <div class="container">
        <h1>My Job Applications</h1>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

        @if($applications->isEmpty())
            <p>You have not applied to any jobs yet.</p>
        @else
        <link rel="stylesheet" href="{{ asset('css/studentApplications.css') }}">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Job Type</th>
                        <th>Location</th>
                        <th>Application Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                        <tr>
                            <td>{{ $application->job->title }}</td>
                            <td>{{ $application->job->job_type }}</td>
                            <td>{{ $application->job->location }}</td>
                            <td>
                                @if($application->application_status == 'submitted')
                                    <span class="badge badge-warning">Submitted</span>
                                @elseif($application->application_status == 'interview')
                                    <span class="badge badge-info">Interview Scheduled</span>
                                @elseif($application->application_status == 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @elseif($application->application_status == 'in_review')
                                    <span class="badge badge-primary">In Review</span>
                                @else
                                    <span class="badge badge-secondary">Unknown</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    @endsection


