@extends('frontend.RecruiterProfiles.dashboard')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Posted Internships</title>
    <link rel="stylesheet" href="{{ asset('css/internshiptable.css') }}">
<body>

<div class="container">
     <!-- Success Message -->
  @if (session('success'))
    <div class="alert alert-success">
      <p>{{ session('success') }}</p>
    </div>
  @endif
    <h1>Posted Internships</h1>

    <div class="box-container">
        <table class="job-listing-table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Job_type</th>
                    <th>Deadline</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 0;
                @endphp
                @foreach ($jobs as $job)
<tr>
    <td>{{ $job->title }}</td>
    <td>{{ ucfirst($job->job_type) }}</td>
    <td>{{ \Carbon\Carbon::parse($job->application_deadline)->format('F j, Y') }}</td>
  
    <td>
    <a href="{{ route('postinternships.edit', $job->id) }}" class="btn btn-primary">Edit</a>
        <!-- Delete Form -->
        <form action="{{ route('postinternships.destroy', $job->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </td>
</tr>
@endforeach

            </tbody>
            
        </table>
    </div>
</div>
<script>
    // Attach the confirmation to delete buttons
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission immediately
            if (confirm('Are you sure you want to delete this internship?')) {
                // If the user confirms, submit the form
                this.closest('form').submit();
            }
        });
    });
</script>
</body>
 </html> 
 @endsection
