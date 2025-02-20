<a href="{{ route('home') }}" class="back-btn">Back</a>

<div class="login-container">
    <div class="login-box">
  
  
        <h1>Welcome back!</h1>
        <p>Enter your credentials to access your account</p>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        @if (session('success'))
    <div class="alert alert-success">
        <p>{{ session('success') }}</p>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        <p>{{ session('error') }}</p>
    </div>
@endif

<!-- The rest of your login form goes here -->

        <form action="{{ route('Account.signin') }}" method="POST">
      


            @csrf
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" >
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" >
            </div>
            <div class="form-group">
            <a href="{{ route('Account.forgetpassword') }}" class="forgot-password">Forgot password?</a>

            </div>
            
            <button type="submit" class="btn">Login</button>
           
           

            
        </form>
        <p class="sign-in-link">Don't have an account?
    <a href="{{ route('Account.studentsignup') }}">SignUp</a>
</p>
    </div>
</div>


