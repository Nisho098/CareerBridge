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
                <input type="text" id="title" name="title" placeholder="Enter internship title" >
            </div>

            <div class="form-group">
                <label for="location">City</label>
                <input type="text" id="location" name="location" placeholder="Enter city">
            </div>

            <div class="form-group">
                <label for="job_type">Internship Type</label>
                <select id="job_type" name="job_type" >
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
                <textarea id="description" name="description" placeholder="Describe the internship" ></textarea>
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
        <script src="{{ asset('js/postinternship.js') }}"></script>
    </div>
</div>
@endsection

