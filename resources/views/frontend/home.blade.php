
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Your Perfect Student Job</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<header>
    <nav>
        <a href="#" class="career-bridge">Career Bridge</a>
        <!-- <ul>
            <li><a href="#">Internships</a></li>
            <li><a href="#">Jobs</a></li>
            <li><a href="#">Contact</a></li>
        </ul> -->
        <div class="auth-buttons">
        <a href="{{ route('Account.signin') }}">
            <button class="login-btn">Login</button>
        </a>

     
    <div class="signup-dropdown">
        <button class="signup-btn">Sign Up</button>
        <div class="dropdown-menu">
            <a href="{{ route('Account.studentsignup') }}">Student</a>
            <a href="{{ route('Account.recuitersignup') }}">Recruiter</a>
        </div>
    </div>
</div>
    </div>
</div>
        </div>
        </div>
    </nav>
</header>

<main>
    <section id="internship-search">
        <h1>Find Your Perfect Student Job</h1>
        <p>Discover internships, part-time roles, and entry-level opportunities tailored for students</p>
        <form>
            <input type="text" placeholder="Search jobs, companies, skills...">
            <button type="submit">Search</button>
        </form>
    </section>

    <section id="latest-internships">
        <h2>Browse Job Categories</h2>
        <section class="job-categories">
            <a href="#" class="category-icon">
            <div class="image-container">
            <img src="{{ asset('images/suitcase.png') }}" alt="Illustration">
        </div>
                <span>Internships</span>
            </a>
            <a href="#" class="category-icon">
            <div class="image-container">
            <img src="{{ asset('images/freelancer.png') }}" alt="Illustration">
        </div>
                <span>Part-time</span>
            </a>
            <a href="#" class="category-icon">
            <div class="image-container">
            <img src="{{ asset('images/location.png') }}" alt="Illustration">
        </div>
                <span>Remote</span>
            </a>
            <a href="#" class="category-icon">
            <div class="image-container">
            <img src="{{ asset('images/suitcase.png') }}" alt="Illustration">
        </div>
                <span>Entry Level</span>
            </a>
        </section>
    </section>
</main>

<footer>
    <div>
        <h1>Career Bridge</h1>
        <p>CareerBridge is an internship-focused platform started with the main focus of helping students get quality internships in Nepal and help them excel at it.</p>
    </div>
    <div>
        <h3>For Candidates</h3>
        <p>Build your CV and Profile</p>
        <p>Internships/Jobs</p>
    </div>
    <div>
        <h3>For Employers</h3>
        <p>Become an Employer</p>
        <p>Post New Internships/Jobs</p>
    </div>
    <div>
        <h3>Helpful Resources</h3>
        <a href="#">Privacy Policy</a>
        <a href="#">FAQs</a>
    </div>
</footer>
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>

