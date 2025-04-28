@extends('frontend.RecruiterProfiles.dashboard')

@section('content')

<style>
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        font-size: 28px;
        color: #333;
        margin-bottom: 20px;
    }

    .alert {
        padding: 15px;
        background-color:rgb(136, 213, 154);
        color: white;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
    }

    .job-listing {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .job-item {
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .job-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .job-item h3 {
        font-size: 24px;
        color: rgb(63, 128, 46);
        margin-bottom: 10px;
    }

    .job-item p {
        font-size: 16px;
        color: #495057;
        margin: 5px 0;
    }

    .job-item p strong {
        font-weight: bold;
        color: #333;
    }

    .refer-btn {
        display: inline-block;
        padding: 10px 15px;
        background-color:rgb(61, 147, 30);
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 10px;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .refer-btn:hover {
        background-color:rgb(155, 239, 103);
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 30px;
    }

    .pagination a {
        padding: 10px 15px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
    }

    .pagination a:hover {
        background-color: #0056b3;
    }

    .pagination .disabled {
        background-color: #6c757d;
        pointer-events: none;
    }

    .no-results {
        text-align: center;
        font-size: 18px;
        color: #dc3545;
    }
</style>

<div class="container">
    <h1>Select a Job to Refer Candidate</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($jobs->isEmpty())
        <p class="no-results">No jobs available for referral.</p>
    @else
        <div class="job-listing">
            @foreach($jobs as $job)
                <div class="job-item">
                    <h3>{{ $job->title }}</h3>
                    <p><strong>Company:</strong> {{ $job->industry }}</p>
                    <p><strong>Location:</strong> {{ $job->recruiter->address }}</p>
                    
                    <p><strong>Requirements:</strong> {{ $job->requirements }}</p>

                    <!-- Refer Candidate Button -->
                    <form action="{{ route('job.referCandidate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $job->id }}">
                        <input type="hidden" name="original_job_id" value="{{ $job->id }}">
                        <input type="hidden" name="student_id" value="{{ auth()->user()->id }}">
                        <button type="submit" class="refer-btn">Refer Candidate</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
