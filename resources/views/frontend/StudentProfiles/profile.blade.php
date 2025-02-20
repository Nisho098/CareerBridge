<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/recruiterProfile.css') }}">
</head>
<body>
<form action="{{ route('studentProfile.update') }}" method="POST" enctype="multipart/form-data">
<div class="profile-container">
@if ($studentProfile)  {{-- ✅ START of IF condition --}}
    <div class="profile-picture">
        <img src="{{ $studentProfile->profile_picture ? asset('storage/profile_pictures/' . $studentProfile->profile_picture) : asset('images/default-profile.jpg') }}" alt="Profile Picture">
    </div>

    <!-- Profile Details Section -->
    <div class="profile-details">
        <h2>{{ $studentProfile->name }}</h2>
        <p><strong>Address:</strong> {{ $studentProfile->location ?? 'Not Provided' }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        <p><strong>Contact:</strong> {{ $studentProfile->contact ?? 'Not Provided' }}</p>
    </div>
</div>

    <!-- Edit Button (Only visible for the owner of the profile) -->
    @if(Auth::user()->id === $studentProfile->user_id)
        <div class="edit-button">
            <a href="{{ route('studentProfile.edit') }}" class="btn">Edit Profile</a>
        </div>
    @endif

    <div class="container">
        <div class="section">
            <h3>About me</h3>
            <p>{{ $studentProfile->about ?? 'No information provided.' }}</p>

            <h3>Education</h3>
            <p>{{ $studentProfile->university_name ?? 'No information provided.' }}</p>
        </div>

        <div class="section">
            <h3>Skills</h3>
            <div class="skills-grid" id="skills-container">
                @if (!empty($studentProfile->skills))
                    @foreach (explode(',', $studentProfile->skills) as $skill)
                        <span class="skill">{{ $skill }}</span>
                    @endforeach
                @else
                    <p>No skills listed.</p>
                @endif
            </div>
        </div>

        <div class="section">
            <h3>File Attachment</h3>

            @if ($studentProfile->resume_url)
                <div class="file-attachment">
                    <div class="file-info">
                        <p>{{ basename($studentProfile->resume_url) }}</p>
                    </div>
                    <a href="{{ asset('storage/' . $studentProfile->resume_url) }}" target="_blank" class="download-btn">
                        <svg viewBox="0 0 24 24">
                            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                        </svg>
                    </a>
                </div>
            @else
                <p>No resume uploaded.</p>
            @endif
        </div>
    </div>
  
@endif

<script src="{{ asset('js/studentdashboard.js') }}"></script>
</body>
</html>
