<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Career Bridge Registration</title>
  <link rel="stylesheet" href="{{ asset('css/recuitersignup.css') }}">
</head>
<body>


  <a href="{{ route('home') }}" class="back-btn">Back</a>
 

  <div class="container">
    <h1>Career <span class="highlight">Bridge</span></h1>
    <p>Register with Career Bridge, Find the perfect candidate.</p>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('Account.register') }}" method="POST">
      @csrf
      <input type="hidden" name="role" value="recruiter">
      <div class="form-group">
        <label for="companyName">Company Name</label>
        <input type="text" id="companyName" name="name" placeholder="Enter your company name" >
      </div>

      <div class="form-group">
        <label for="industry">Company Industry</label>
        <select id="industry" name="industry" >
          <option value="" disabled selected>Select Company Industry Type</option>
          <option value="IT">IT</option>
          <option value="Healthcare">Healthcare</option>
          <option value="Education">Education</option>
        </select>
      </div>

      <div class="form-group">
        <label for="contactNo">Company Contact No</label>
        <input type="tel" id="contactNo" name="contact_no" placeholder="Enter Company Contact number" >
      </div>

      <div class="form-group">
        <label for="email">Official Email</label>
        <input type="email" id="email" name="email" placeholder="Enter company email address" >
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" >
      </div>

      <div class="form-group">
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" >
      </div>

      <div class="form-group">
        <label for="city">City</label>
        <input type="text" id="city" name="city" placeholder="Enter Company city" >
      </div>

      <div class="form-group">
        <label for="location">Location</label>
        <input type="text" id="location" name="location" placeholder="Enter company street Address" >
      </div>

      <button type="submit" class="btn">Signup</button>
    </form>

   
  </div>
</body>
</html>
