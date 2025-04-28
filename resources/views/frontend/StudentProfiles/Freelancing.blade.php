@extends('frontend.StudentProfiles.dashboard')

@section('content')


<a href="{{ route('salary.comparison') }}" class="btn-compare-salary">Compare Salaries</a>

<style>
  
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fc;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 100%;
        margin: 0 auto;
        padding: 30px;
    }

 
    h1 {
        text-align: left;
        font-size: 2.5rem;
        color: #2a2a2a;
        margin-bottom: 40px;
        font-weight: 600;
    }

  
    .btn-compare-salary {
        display: inline-block;
        padding: 12px 20px;
        font-size: 1rem;
        color: white;
        background-color: rgb(98, 184, 61);;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        margin-bottom: 20px;
    }

    .btn-compare-salary:hover {
        background-color: rgb(116, 150, 101);
    }

  
    .job-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }


    .job-card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        padding: 20px;
        border: 1px solid #e2e2e2;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .job-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

 
    .job-card h3 {
        font-size: 1.7rem;
        color: #333;
        margin-bottom: 15px;
        font-weight: 700;
        transition: color 0.3s ease;
    }

    .job-card h3:hover {
        color: rgb(116, 150, 101);
    }


    .job-card p {
        font-size: 1rem;
        color: #555;
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .job-card p strong {
        color: rgb(98, 184, 61);
        font-weight: 600;
    }


    .job-card .skills-required {
        font-size: 0.95rem;
        color: #777;
        margin-bottom: 20px;
    }

 
    .job-card .btn-primary {
        background-color: rgb(98, 184, 61);
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-size: 1rem;
        text-align: center;
        display: inline-block;
        transition: background-color 0.3s ease;
        margin-top: auto;
    }

    .job-card .btn-primary:hover {
        background-color: rgb(116, 150, 101);
    }

 
    .job-list p {
        text-align: center;
        font-size: 1.2rem;
        color: #777;
        margin-top: 30px;
    }


    @media screen and (max-width: 768px) {
        .job-list {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media screen and (max-width: 480px) {
        .job-list {
            grid-template-columns: 1fr;
        }

        .job-card {
            padding: 15px;
        }
    }
</style>

<div class="container">
    <h1>Freelancing Opportunities</h1>

  
    <div style="margin-bottom: 20px; padding: 15px; background-color: #eef2ff; border-radius: 5px;">
       
    </div>

    @if($freelancingJobs->isEmpty())
        <p>No freelancing opportunities available at the moment.</p>
    @else
        <div class="job-list">
            @foreach($freelancingJobs as $job)
                <div class="job-card">
                    <h3>{{ $job->title }}</h3>
                    <p><strong>Company:</strong> {{ $job->industry ?? 'N/A' }}</p>

                    <p class="skills-required">
                        <strong>Skills Required:</strong> 
                        @php
                            $skills = json_decode($job->requirements, true);
                            if (!is_array($skills)) {
                                $skills = explode(',', $job->requirements);
                            }
                        @endphp
                        {{ implode(', ', array_map('trim', $skills)) }}
                    </p>

                    <p><strong>Description:</strong> 
                        {{ Str::limit($job->description, 150, '...') }}
                    </p>

                    <p><strong>Salary:</strong> Rs. {{ number_format($job->salary, 2) }}</p>

                
                    <a href="{{ route('apply.create', $job->id) }}" class="btn-primary">Apply Now</a>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
