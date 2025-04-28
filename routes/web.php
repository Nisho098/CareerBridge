<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\RecruiterProfileController;
use App\Http\Controllers\PostInternshipController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GitHubController;
use App\Http\Controllers\FreelancingController;
use App\Models\Notification;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/signin', [AccountController::class, 'login'])->name('Account.signin');
Route::post('/signin', [AccountController::class, 'loginUser'])->name('loginUser');
Route::get('/student-signup', [AccountController::class, 'registration'])->name('Account.studentsignup');
Route::post('/account-register', [AccountController::class, 'processStudentRegistration'])->name('Account.registration');
Route::get('/recuiter-signup', [AccountController::class, 'recuiterregistration'])->name('Account.recuitersignup');
Route::post('/register', [AccountController::class, 'processRecruiterRegistration'])->name('Account.register');
Route::get('/forgetPassword', [AccountController::class, 'forgetPassword'])->name('Account.forgetpassword');
Route::post('/send-reset-link', [AccountController::class, 'sendResetLink']);
Route::get('/reset-password/{token}', [AccountController::class, 'showResetForm'])->name('Account.resetPassword');
Route::post('/processreset-password/{token}', [AccountController::class, 'processResetPassword'])->name('Account.processResetPassword');

Route::get('/student/profile/{user_id}', [StudentProfileController::class, 'show'])->name('studentProfile.show');
Route::get('/recruiter/{id}/profile', [RecruiterProfileController::class, 'showProfile'])->name('recruiterProfile.show');
   
   
Route::middleware(['auth', 'student'])->group(function () {

   

    // Dashboard Routes
    Route::get('/student/dashboard', [ProfileController::class, 'dindex'])->name('home.dindex');
      // Student Profile Routes
      Route::get('/studentProfile', [StudentProfileController::class, 'create'])->name('studentProfile.create');
      Route::get('studentProfile/edit', [StudentProfileController::class, 'edit'])->name('studentProfile.edit');
      Route::post('/updateProfile', [StudentProfileController::class, 'update'])->name('studentProfile.update');
      

      // GitHub Authentication Routes
Route::get('/auth/github/redirect', [GitHubController::class, 'redirectToGitHub'])->name('github.redirect');
Route::get('/auth/github/callback', [GitHubController::class, 'handleGitHubCallback'])->name('github.callback');
 // Notifications
 Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

  // Profile Picture Upload
  Route::post('/profile/upload', [ProfileController::class, 'uploadProfilePicture'])->name('profile.upload');

 // Freelancing
 Route::get('/freelancing-jobs', [FreelancingController::class, 'index'])->name('freelancing.index');

 // GitHub Routes
 Route::get('/github/edit/{id}', [GitHubController::class, 'edit'])->name('github.edit');
 Route::delete('/github/delete/{id}', [GitHubController::class, 'destroy'])->name('github.delete');
  // Application Routes
  Route::get('/apply/{job_id}', [ApplicationController::class, 'create'])->name('apply.create');
  Route::post('/applyjob/{job_id}', [ApplicationController::class, 'store'])->name('apply.store');
  Route::get('/jobs/apply/{id}', [ApplicationController::class, 'apply'])->name('jobs.apply');

 // Job Details Route
Route::get('/jobdetails/{id}', [JobController::class, 'create'])->name('job.create');
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

 // Student Application Routes
 Route::get('/student/applications', [StudentProfileController::class, 'showStudentApplications'])->name('StudentProfile.showStudentApplications');
});


//Recruiter

Route::middleware(['auth', 'recruiter'])->group(function () {
    Route::get('/recruiterdashboard', [RecruiterProfileController::class, 'dashboard'])->name('recruiterdashboard');
    Route::get('/recruiter/dashboard', [RecruiterProfileController::class, 'recdash'])->name('recruiter.dashboard');

    // Recruiter Profile Routes 
    Route::get('/recruiterProfile', [RecruiterProfileController::class, 'create'])->name('recruiterProfile.create');
    Route::get('recruiterProfile/edit', [RecruiterProfileController::class, 'edit'])->name('recruiterProfile.edit');
    Route::post('/recupdateProfile', [RecruiterProfileController::class, 'update'])->name('recruiterProfile.update');
    

  

    // Internship Routes
  
        Route::get('/createpostinternships', [PostInternshipController::class, 'create'])->name('postinternships.create');
        Route::post('/postinternships/store', [PostInternshipController::class, 'store'])->name('postinternships.store');
        Route::get('/postinternships', [PostInternshipController::class, 'index'])->name('postinternships.index');
        Route::get('postinternships/tablecreate', [PostInternshipController::class, 'tablecreate'])->name('postinternships.tablecreate');
        Route::get('postinternships/{id}/edit', [PostInternshipController::class, 'edit'])->name('postinternships.edit');
        Route::post('postinternships/{id}', [PostInternshipController::class, 'update'])->name('postinternships.update');
        Route::delete('postinternships/{id}', [PostInternshipController::class, 'destroy'])->name('postinternships.destroy');
   



   

    // Recruiter Applications Routes
    Route::get('/recruiter/applications/{jobId?}', [RecruiterProfileController::class, 'showApplications'])->name('recruiter.showApplications');
    Route::post('/recruiter/application/{applicationId}/reject', [RecruiterProfileController::class, 'rejectApplication'])->name('recruiter.rejectApplication');
    Route::post('/recruiter/application/{applicationId}/schedule', [RecruiterProfileController::class, 'scheduleInterview'])->name('recruiter.scheduleInterview');

   
});
   

    // Refer Candidate
    Route::get('/recruiter/refer-candidate', [JobController::class, 'showReferJobPage'])->name('job.showReferPage');
    Route::post('/recruiter/candidate', [JobController::class, 'referCandidate'])->name('job.referCandidate');




// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/pending-jobs', [AdminController::class, 'showPendingJobs'])->name('admin.pendingJobs');
    Route::patch('/admin/approve-job/{id}', [AdminController::class, 'approveJob'])->name('admin.approveJob');
    Route::delete('/admin/delete-job/{id}', [AdminController::class, 'deleteJob'])->name('admin.deleteJob');
    Route::get('/jobs', [AdminController::class, 'jobs'])->name('jobs.index');
    Route::delete('/jobs/{id}', [AdminController::class, 'destroyjob'])->name('jobs.destroy');
});



// Salary Comparison
Route::get('/salary-comparison', [JobController::class, 'compareSalaries'])->name('salary.comparison');

// Search
Route::get('/search-jobs', [JobController::class, 'search'])->name('jobs.search');


