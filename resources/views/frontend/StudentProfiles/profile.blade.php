<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/recruiterProfile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/studentProfile.css') }}">
</head>
<body>

<div class="profile-container">
    @if ($studentProfile)  
        <div class="profile-picture">
            <img src="{{ $studentProfile->profile_picture ? asset('storage/profile_pictures/' . $studentProfile->profile_picture) : asset('images/default-profile.jpg') }}" alt="Profile Picture">
        </div>

        <div class="profile-details">
            <h2>{{ $studentProfile->name }}</h2>
            <p><strong>Address:</strong> {{ $studentProfile->location ?? 'Not Provided' }}</p>
            <p><strong>Email:</strong> {{ $studentProfile->user->email ?? 'Not Provided' }}</p>
            <p><strong>Contact:</strong> {{ $studentProfile->contact ?? 'Not Provided' }}</p>
        </div>
    </div>

    @if(Auth::check() && Auth::user()->id === $studentProfile->user_id)
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
            <div class="skills-grid">
                @if (!empty($studentProfile->skills))
                    @foreach (explode(',', $studentProfile->skills) as $skill)
                        <span class="skill">{{ trim($skill) }}</span>
                    @endforeach
                @else
                    <p>No skills listed.</p>
                @endif
            </div>
        </div>

       
     



<div class="section">
    <h3>GitHub Repositories</h3>
    
    @php
        $repositories = \App\Models\GitHubRepository::where('user_id', $studentProfile->user_id)->get();
    @endphp
    
    @if($repositories->isNotEmpty())
        <div class="repository-list">
            @foreach($repositories as $repo)
                <div class="repository">
                    <h4>
                        <a href="{{ $repo->url }}" target="_blank">{{ $repo->github_name }}</a>
                    </h4>
                    <p>{{ $repo->description ?? 'No description available' }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p>No GitHub repositories found.</p>
    @endif
    
   
    @if(Auth::check() && Auth::user()->id === $studentProfile->user_id)
        <a href="{{ route('github.redirect') }}" class="btn btn-primary">Connect GitHub</a>
    @endif
</div>



<div class="section1">
            <h3>Resume</h3>

            @if ($studentProfile->resume_url)
                <div class="file-attachment">
                    <div class="file-info">
                        <p>{{ basename($studentProfile->resume_url) }}</p>
                    </div>
                    <a href="{{ asset('storage/' . $studentProfile->resume_url) }}" 
                       target="_blank" 
                       class="download-btn" 
                       download="{{ basename($studentProfile->resume_url) }}">
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
