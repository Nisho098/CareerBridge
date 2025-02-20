@extends('frontend.RecruiterProfiles.dashboard')

@section('content')
<div class="container">
  
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit an Internship</title>
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


        
<form action="{{ route('postinternships.update', $job->id) }}" method="POST">
    @csrf
   
             <div class="form-group">
                <label for="title">Internship Title</label>
                <input type="text" id="title" name="title"  value="{{ old('title', $job->title) }}"  placeholder="Enter internship title" >
            </div>

            <div class="form-group">
                <label for="location">City</label>
                <input type="text" id="location" name="location"    value="{{ old('location', $job->location) }}"  placeholder="Enter city">
            </div>

            <div class="form-group">
                <label for="job_type">Internship Type</label>
                <select id="job_type" name="job_type" >
                <option value="full-time" {{ old('job_type', $job->job_type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="part-time" {{ old('job_type', $job->job_type) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="internship" {{ old('job_type', $job->job_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                </select>
            </div>

            <div class="form-group">
                <label for="industry">Industry</label>
                <input type="text" id="industry" name="industry" value="{{ old('industry', $job->industry) }}"  placeholder="Enter industry">
            </div>

            <div class="form-group">
                <label for="description">Internship Description</label>
                <textarea id="description" name="description" placeholder="Describe the internship" required>{{ old('description', $job->description) }}</textarea>
            </div>

           

            <div class="form-group">
                <label for="application_deadline">Application Deadline</label>
                <input type="date" id="application_deadline" name="application_deadline" value="{{ old('application_deadline', $job->application_deadline) }}" >
            </div>

            <div class="form-group">
                <label for="requirements">Requirements</label>
                <textarea id="requirements" name="requirements"  placeholder="List the internship requirements">{{ old('requirements', $job->requirements) }}</textarea>

            <button type="submit">Edit Internship</button>
        </form>
        <script src="{{ asset('js/postinternship.js') }}"></script>
    </div>
</div>
@endsection

