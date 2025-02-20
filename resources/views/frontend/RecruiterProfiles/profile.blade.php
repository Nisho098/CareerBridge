<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruiter Profile</title>
    <link rel="stylesheet" href="{{ asset('css/recruiterProfile.css') }}">
</head>
<body>
    <div class="header">
        <div class="profile-container">
            <!-- Avatar -->
            <div class="avatar">
                <div class="avatar-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>
            <!-- Profile Info -->
            <div class="profile-info">
                <div class="profile-details">
                    <h2>{{ Auth::user()->name }}</h2>
                    <p><strong>Address:</strong> {{ $recruiterProfile->address ?? 'Not Provided' }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Contact:</strong> {{ $recruiterProfile->contact_number ?? 'Not Provided' }}</p>
                </div>
            </div>
            <!-- Edit Button -->
            <div class="edit-button">
                <a href="{{ route('recruiterProfile.edit') }}" class="btn">Edit Profile</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="section">
            <h3>About Company</h3>
            <p>{{ $recruiterProfile->aboutcompany ?? 'No information available' }}</p>
        </div>

        <div class="section">
            <h3>Contact Personal Details</h3>
            <p>{{ $recruiterProfile->personaldetails ?? 'No personal details provided' }}</p>
        </div>

        <div class="section">
            <h3>Company Details</h3>
            <p>{{ $recruiterProfile->details ?? 'No company details available' }}</p>
        </div>
    </div>

    <script src="{{ asset('js/recruiterProfile.js') }}"></script>
</body>
</html>
