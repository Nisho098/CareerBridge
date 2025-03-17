<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruiter Profile</title>
    <link rel="stylesheet" href="{{ asset('css/recruiterProfile.css') }}">

    <!-- Leaflet.js for Free Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        #show-map-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        #show-map-btn:hover {
            background-color: #0056b3;
        }
        #map {
            width: 100%;
            height: 400px;
            display: none;
            margin-top: 10px;
        }
    </style>
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
                <h2>{{ $recruiterProfile->user->name ?? 'Not Provided' }}</h2>

                <p><strong>Email:</strong> {{ $recruiterProfile->user->email ?? 'Not Provided' }}</p>
                    <p><strong>Contact:</strong> {{ $recruiterProfile->contact_number ?? 'Not Provided' }}</p>
                    <p><strong>Address:</strong> {{ $recruiterProfile->address ?? 'Not Provided' }}</p>

                    <button id="show-map-btn">View on Map</button>

                    <!-- Map Container -->
                    <div id="map"></div>
                </div>
            </div>

            <!-- Edit Button -->
            @if(Auth::user()->id === $recruiterProfile->user_id)
            <div class="edit-button">
                <a href="{{ route('recruiterProfile.edit') }}" class="btn">Edit Profile</a>
            </div>
            @endif
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

    <script>
    let mapInitialized = false;

    document.getElementById('show-map-btn').addEventListener('click', function () {
        let mapDiv = document.getElementById('map');
        mapDiv.style.display = 'block'; // Show the map

        if (mapInitialized) return; // Prevent reloading the map

        let fullAddress = "{{ $recruiterProfile->street ?? '' }}, {{ $recruiterProfile->address ?? '' }}, Nepal";

        let url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(fullAddress)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let latitude = data[0].lat;
                    let longitude = data[0].lon;

                    let map = L.map('map').setView([latitude, longitude], 15);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    L.marker([latitude, longitude]).addTo(map)
                        .bindPopup("{{ $recruiterProfile->name ?? 'Recruiter Location' }}<br>{{ $recruiterProfile->street ?? '' }}, {{ $recruiterProfile->address ?? '' }}")
                        .openPopup();

                    mapInitialized = true;
                } else {
                    alert("Location not found. Please check the street name.");
                }
            })
            .catch(error => console.error("Error fetching data:", error));
    });
</script>


</body>
</html>
