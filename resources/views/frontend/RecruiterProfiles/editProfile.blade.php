
@extends('frontend.RecruiterProfiles.dashboard')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit Recruiter Profile</h2>
    <link rel="stylesheet" href="{{ asset('css/editRecruiterProfile.css') }}">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('recruiterProfile.update', $recruiter->id) }}">

        @csrf
      


        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" 
       value="{{ old('name', optional(Auth::user()->recruiterProfile)->name) }}" required>

        </div>

        <div class="mb-3">
            <label class="form-label">Company Website</label>
            <input type="url" class="form-control" name="company_website" value="{{ old('company_website', optional(Auth::user()->recruiterProfile)->company_website) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number',optional(Auth::user()->recruiterProfile)->contact_number) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" name="address" value="{{ old('address',optional(Auth::user()->recruiterProfile)->address) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Details</label>
            <textarea class="form-control" name="details" rows="3">{{ old('details',optional(Auth::user()->recruiterProfile)->details) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Personal Details</label>
            <textarea class="form-control" name="personaldetails" rows="3">{{ old('personaldetails', optional(Auth::user()->recruiterProfile)->personaldetails) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">About Company</label>
            <textarea class="form-control" name="aboutcompany" rows="3">{{ old('aboutcompany', optional(Auth::user()->recruiterProfile)->aboutcompany) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
