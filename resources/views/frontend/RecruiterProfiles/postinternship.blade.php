@extends('frontend.RecruiterProfiles.dashboard')

@section('content')
<div class="container">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Post an Internship</title>
    <link rel="stylesheet" href="{{ asset('css/postinternship.css') }}">

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('postinternships.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Internship Title</label>
            <input type="text" id="title" name="title" placeholder="Enter internship title">
        </div>

        <div class="form-group">
            <label for="job_type">Internship Type</label>
            <select id="job_type" name="job_type" onchange="toggleSalaryFields()">
                <option value="">Select type</option>
                <option value="full-time">Full-time</option>
                <option value="part-time">Part-time</option>
                <option value="internship">Internship</option>
            </select>
        </div>

        <div class="form-group">
            <label for="industry">Industry</label>
            <input type="text" id="industry" name="industry" placeholder="Enter industry">
        </div>

        <div class="form-group">
            <label for="description">Internship Description</label>
            <textarea id="description" name="description" placeholder="Describe the internship"></textarea>
        </div>

        <!-- Salary and Benefits Fields (Initially Hidden) -->
        <div id="salary_fields" style="display: none;">
            <div class="form-group">
                <label for="salary">Salary</label>
                <input type="number" id="salary" name="salary" placeholder="Enter salary amount">
            </div>

            <div class="form-group">
                <label for="salary_type">Salary Type</label>
                <select id="salary_type" name="salary_type">
                    <option value="monthly">Monthly</option>
                    <option value="hourly">Hourly</option>
                    <option value="project-based">Project-Based</option>
                </select>
            </div>

            <div class="form-group">
                <label for="benefits">Benefits (comma separated)</label>
                <input type="text" id="benefits" name="benefits" placeholder="Health Insurance, Remote Work">
            </div>

            <div class="form-group">
                <label for="project_duration">Project Duration</label>
                <input type="text" id="project_duration" name="project_duration" placeholder="e.g., 3 months">
            </div>

            <div class="form-group">
                <label for="payment_terms">Payment Terms</label>
                <input type="text" id="payment_terms" name="payment_terms" placeholder="e.g., Milestone-Based">
            </div>
        </div>

        <div class="form-group">
            <label for="application_deadline">Application Deadline</label>
            <input type="date" id="application_deadline" name="application_deadline">
        </div>

        <div class="form-group">
            <label for="requirements">Requirements</label>
            <textarea id="requirements" name="requirements" placeholder="List the internship requirements"></textarea>
        </div>

        <button type="submit">Post Internship</button>
    </form>

    <script>
        // JavaScript to toggle salary and benefits fields
        function toggleSalaryFields() {
            const jobType = document.getElementById('job_type').value;
            const salaryFields = document.getElementById('salary_fields');

            if (jobType === 'part-time') {
                salaryFields.style.display = 'block'; // Show fields for part-time jobs
            } else {
                salaryFields.style.display = 'none'; // Hide fields for other job types
            }
        }

        // Call the function on page load to set the initial state
        document.addEventListener('DOMContentLoaded', function() {
            toggleSalaryFields();
        });
    </script>
</div>
@endsection