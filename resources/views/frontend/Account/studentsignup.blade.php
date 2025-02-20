<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Career Bridge</title>
  <link rel="stylesheet" href="{{ asset('css/signup.css') }}">

</head>
<body>
 

<a href="{{ route('home') }}" class="back-btn">Back</a>
  <div class="container">
    <h1>Career Bridge</h1>
    <p>Get started Now by finding the job <br>you are looking for</p>
     <!-- Popup Message (Will appear if session status is set) -->
  @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('Account.registration') }}" method="POST">
    @csrf
    <input type="hidden" name="role" value="student">
    
<div class="form-group">
  <label for="name">Name</label>
  <input type="text" name="name" id="name" placeholder="Enter your name" value="{{ old('name') }}" >
</div>
<div class="form-group">
  <label for="gender">Gender</label>
  <div class="radio-group">
    <div class="radio-item">
      <input type="radio" id="male" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} >
      <label for="male">Male</label>
    </div>
    <div class="radio-item">
      <input type="radio" id="female" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} >
      <label for="female">Female</label>
    </div>
    <div class="radio-item">
      <input type="radio" id="others" name="gender" value="others" {{ old('gender') == 'others' ? 'checked' : '' }} >
      <label for="others">Others</label>
    </div>
  </div>
</div>
<div class="form-group">
  <label for="email">Email address</label>
  <input 
    type="email" 
    name="email" 
    id="email" 
    placeholder="Enter your email" 
    value="{{ old('email') }}" 
    required 
    pattern="[a-zA-Z0-9._%+-]+@edu\.np" 
    title="Your email must be a valid @edu.np email address."
  >
</div>

<div class="form-group">
  <label for="password">Password</label>
  <input type="password" name="password" id="password" placeholder="Enter your password" >
</div>
<div class="form-group">
  <label for="confirm-password">Confirm Password</label>
  <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirm your password" >
</div>
<div class="form-group">
  <label for="contact-number">Contact Number</label>
  <input type="tel" name="contact_number" id="contact-number" placeholder="Enter your number" value="{{ old('contact_number') }}" >
</div>
<div class="form-group">
  <label for="industry">Desired Industry</label>
  <select name="desired_industry" id="industry" >
    <option value="">Select desired industry</option>
    <option value="IT" {{ old('desired_industry') == 'IT' ? 'selected' : '' }}>IT</option>
    <option value="Finance" {{ old('desired_industry') == 'Finance' ? 'selected' : '' }}>Finance</option>
    <option value="Healthcare" {{ old('desired_industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
    <option value="Education" {{ old('desired_industry') == 'Education' ? 'selected' : '' }}>Education</option>
    <option value="Engineering" {{ old('desired_industry') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
    <option value="Other" {{ old('desired_industry') == 'Other' ? 'selected' : '' }}>Other</option>
  </select>
</div>


      <button type="submit" class="btn">Signup</button>
    </form>
    <p class="sign-in-link">Have an account?
    <a href="{{ route('Account.signin') }}">Login</a>
</p>


       
  </div>
</body>
</html>
