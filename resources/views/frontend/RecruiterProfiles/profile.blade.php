<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruiter Profile</title>
    <link rel="stylesheet" href="{{ asset('css/recruiterProfile.css') }}">
    
   
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        #show-map-btn {
            background-color: rgb(63, 128, 46);
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        #show-map-btn:hover {
            background-color: rgb(63, 128, 46);
        }

        #map {
            width: 100%;
            height: 400px;
            display: none;
            margin-top: 10px;
        }

      
        .chat-button {
            background-color: rgb(63, 128, 46);
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            margin: 12px 0;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
        }

        .chat-button:hover {
            background-color: rgb(63, 128, 46);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .chat-button::before {
            content: "💬";
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="profile-container">
          
            <div class="profile-info">
                <div class="profile-details">
                    <h2>{{ $recruiterProfile->user->name ?? 'Not Provided' }}</h2>
                    <p><strong>Email:</strong> {{ $recruiterProfile->user->email ?? 'Not Provided' }}</p>
                    <p><strong>Contact:</strong> {{ $recruiterProfile->contact_number ?? 'Not Provided' }}</p>
                    <p><strong>Address:</strong> {{ $recruiterProfile->address ?? 'Not Provided' }}</p>

                    <button id="show-map-btn">View on Map</button>
                    <div id="map"></div>
                </div>
            </div>

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
        
        <!-- Only show chat button if user is not the recruiter themselves -->
        @if(Auth::user()->id !== $recruiterProfile->user_id)
            <div style="text-align: center;">
                <a href="javascript:void(0)" class="chat-button" id="chatify-btn">
                    <span>Chat with Recruiter</span>
                </a>
            </div>
        @endif
    </div>

    <!-- Only include chat container if user is not the recruiter themselves -->
    @if(Auth::user()->id !== $recruiterProfile->user_id)
        @isset($chatifyVars)
        <div id="chatify-chat-container" style="display:none;">
            @include('vendor.Chatify.layouts.app', $chatifyVars)
        </div>
        @endisset
    @endif

    <script src="{{ asset('js/recruiterProfile.js') }}"></script>

    <script>
        // Map functionality
        let mapInitialized = false;

        document.getElementById('show-map-btn').addEventListener('click', function() {
            let mapDiv = document.getElementById('map');
            mapDiv.style.display = 'block';
            
            if (mapInitialized) return;
            
            let fullAddress = "{{ $recruiterProfile->street ?? '' }}, {{ $recruiterProfile->address ?? '' }}, Nepal";
            let url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(fullAddress)}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let map = L.map('map').setView([data[0].lat, data[0].lon], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                        L.marker([data[0].lat, data[0].lon])
                            .addTo(map)
                            .bindPopup("{{ $recruiterProfile->name ?? 'Recruiter Location' }}")
                            .openPopup();
                        mapInitialized = true;
                    } else {
                        alert("Location not found. Please check the address.");
                    }
                })
                .catch(console.error);
        });

        // Chat functionality (only if button exists)
        const chatButton = document.getElementById('chatify-btn');
        if (chatButton) {
            chatButton.addEventListener('click', function() {
                let chatContainer = document.getElementById('chatify-chat-container');
                chatContainer.style.display = chatContainer.style.display === 'none' ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>