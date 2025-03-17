
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

    <!-- ✅ New Location Dropdown -->
    <div class="mb-3">
        <label class="form-label">Location</label>
        <select class="form-control" id="location" name="address">
            <option value="">Select Location</option>
            <option value="Kathmandu" {{ old('address', optional(Auth::user()->recruiterProfile)->address) == 'Kathmandu' ? 'selected' : '' }}>Kathmandu</option>
            <option value="Lalitpur" {{ old('address', optional(Auth::user()->recruiterProfile)->address) == 'Lalitpur' ? 'selected' : '' }}>Lalitpur</option>
            <option value="Bhaktapur" {{ old('address', optional(Auth::user()->recruiterProfile)->address) == 'Bhaktapur' ? 'selected' : '' }}>Bhaktapur</option>
            <option value="Pokhara" {{ old('address', optional(Auth::user()->recruiterProfile)->address) == 'Pokhara' ? 'selected' : '' }}>Pokhara</option>
            <option value="Chitwan" {{ old('address', optional(Auth::user()->recruiterProfile)->address) == 'Chitwan' ? 'selected' : '' }}>Chitwan</option>
            <option value="Biratnagar" {{ old('address', optional(Auth::user()->recruiterProfile)->address) == 'Biratnagar' ? 'selected' : '' }}>Biratnagar</option>
            <option value="Itahari" {{ old('address', optional(Auth::user()->recruiterProfile)->address) == 'Itahari' ? 'selected' : '' }}>Itahari</option>
        </select>
    </div>
    <div class="mb-3">
    <label class="form-label">Street</label>
    <input type="text" class="form-control" id="street" name="street" placeholder="Enter street name">
</div>

<input type="hidden" name="latitude" id="latitude-hidden" value="{{ old('latitude', optional(Auth::user()->recruiterProfile)->latitude) ?? '' }}">
<input type="hidden" name="longitude" id="longitude-hidden" value="{{ old('longitude', optional(Auth::user()->recruiterProfile)->longitude) ?? '' }}">
<input type="hidden" name="full_address" id="full-address-hidden" value="{{ old('full_address', optional(Auth::user()->recruiterProfile)->full_address) }}">

<script>
    document.getElementById('location').addEventListener('change', function () {
        let locations = {
            'Kathmandu': { lat: 27.7172, lng: 85.3240 },
            'Lalitpur': { lat: 27.6667, lng: 85.3167 },
            'Bhaktapur': { lat: 27.6721, lng: 85.4298 },
            'Pokhara': { lat: 28.2096, lng: 83.9856 },
            'Chitwan': { lat: 27.5291, lng: 84.3542 },
            'Biratnagar': { lat: 26.4525, lng: 87.2718 },
            'Itahari': { lat: 26.6636, lng: 87.2746 }
        };

        let selectedLocation = this.value;
        let latitudeHidden = document.getElementById('latitude-hidden');
        let longitudeHidden = document.getElementById('longitude-hidden');

        if (locations[selectedLocation]) {
            latitudeHidden.value = locations[selectedLocation].lat;
            longitudeHidden.value = locations[selectedLocation].lng;
        } else {
            latitudeHidden.value = '';
            longitudeHidden.value = '';
        }
    });
</script>



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
<script>
    function getCoordinates() {
        let city = document.getElementById("location").value;
        let street = document.getElementById("street").value;
        let company = document.getElementById("company_name").value; // Get company name

        if (!city || !street) {
            return;
        }

        let address = `${street}, ${city}, Nepal`;
        let url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let latitude = data[0].lat;
                    let longitude = data[0].lon;

                    document.getElementById("latitude-hidden").value = latitude;
                    document.getElementById("longitude-hidden").value = longitude;

                    // ✅ Store the full address, including company name
                    document.getElementById("full-address-hidden").value = `${company}, ${street}, ${city}, Nepal`;
                } else {
                    console.log("Location not found");
                }
            })
            .catch(error => console.error("Error fetching data:", error));
    }

    document.getElementById("street").addEventListener("blur", getCoordinates);
    document.getElementById("location").addEventListener("change", getCoordinates);
</script>

@endsection
