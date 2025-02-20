@extends('frontend.StudentProfiles.dashboard') <!-- Extend from dashboard layout -->

@section('content')
@csrf
<link rel="stylesheet" href="{{ asset('css/applyForm.css') }}">
<div class="container">
    <h1>Apply for: {{ $job->title }}</h1>

    <!-- Check for success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Check for error message -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Application Form -->
    <form action="{{ route('apply.store', ['job_id' => $job->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
        </div>

        <div>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required>
        </div>

        <div>
            <label for="contact">Phone Number:</label>
            <input type="tel" id="contact" name="contact" value="{{ Auth::user()->studentProfile->contact }}" required>
        </div>

        <div>
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="{{ Auth::user()->studentProfile->location }}" required>
        </div>

        <div>
            <label for="cover_letter">Cover Letter:</label>
            <input type="file" id="cover_letter" name="cover_letter" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>
@endsection
