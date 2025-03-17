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
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GitHubController;
use App\Http\Controllers\FreelancingController;





Route::get('/',[HomeController::class,'index'])->name('home');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

// Dashboard Route (Student Dashboard Page)
Route::get('/student/dashboard', [ProfileController::class, 'dindex'])->name('home.dindex')->middleware('auth');

// Profile Picture Upload
Route::post('/profile/upload', [ProfileController::class, 'uploadProfilePicture'])->name('profile.upload')->middleware('auth');

// **Authentication Routes**
Route::get('/signin', [AccountController::class, 'login'])->name('Account.signin');
Route::post('/signin', [AccountController::class, 'loginUser'])->name('loginUser');

// **User Registration Routes**
Route::get('/student-signup', [AccountController::class, 'registration'])->name('Account.studentsignup');
Route::post('/account-register', [AccountController::class, 'processStudentRegistration'])->name('Account.registration');

// **Recruiter Registration Routes**
Route::get('/recuiter-signup', [AccountController::class, 'recuiterregistration'])->name('Account.recuitersignup');
Route::post('/register', [AccountController::class, 'processRecruiterRegistration'])->name('Account.register');

// **Password Reset Routes**
Route::get('/forgetPassword', [AccountController::class, 'forgetPassword'])->name('Account.forgetpassword');
Route::post('/send-reset-link', [AccountController::class, 'sendResetLink']);
Route::get('/reset-password/{token}', [AccountController::class, 'showResetForm'])->name('Account.resetPassword');
Route::post('/processreset-password/{token}', [AccountController::class, 'processResetPassword'])->name('Account.processResetPassword');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [StudentProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/recruiterdashboard', [RecruiterProfileController::class, 'dashboard'])->name('recruiterdashboard');
});



// **Recruiter Profile Routes**
Route::get('/recruiterProfile', [RecruiterProfileController::class, 'create'])->name('recruiterProfile.create')
    ->middleware('auth');
Route::get('recruiterProfile/edit', [RecruiterProfileController::class, 'edit'])->name('recruiterProfile.edit')
    ->middleware('auth');
    Route::post('/recupdateProfile', [RecruiterProfileController::class, 'update'])->name('recruiterProfile.update')
    ->middleware('auth');
    Route::get('/recruiter/{id}/profile', [RecruiterProfileController::class, 'showProfile'])
    ->name('recruiterProfile.show')
    ->middleware('auth');



// **Student Profile Routes**
Route::get('/studentProfile', [StudentProfileController::class, 'create'])->name('studentProfile.create')->middleware('auth');
Route::get('studentProfile/edit', [StudentProfileController::class, 'edit'])->name('studentProfile.edit')
    ->middleware('auth');
Route::post('/updateProfile', [StudentProfileController::class, 'update'])->name('studentProfile.update')->middleware('auth');
Route::get('/student/profile/{user_id}', [StudentProfileController::class, 'show'])->name('studentProfile.show')->middleware('auth');



// **Internship Routes (Requires Authentication)**
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/createpostinternships', [PostInternshipController::class, 'create'])->name('postinternships.create');
    Route::post('/postinternships/store', [PostInternshipController::class, 'store'])->name('postinternships.store');
    Route::get('/postinternships', [PostInternshipController::class, 'index'])->name('postinternships.index');
    Route::get('postinternships/tablecreate', [PostInternshipController::class, 'tablecreate'])->name('postinternships.tablecreate');
    Route::get('postinternships/{id}/edit', [PostInternshipController::class, 'edit'])->name('postinternships.edit');
    Route::post('postinternships/{id}', [PostInternshipController::class, 'update'])->name('postinternships.update');
    Route::delete('postinternships/{id}', [PostInternshipController::class, 'destroy'])->name('postinternships.destroy');
});

//Salary comp
Route::get('/salary-comparison', [JobController::class, 'compareSalaries'])->name('salary.comparison');


// **Job Details Route (Requires Authentication)**
Route::middleware(['auth'])->get('/jobdetails/{id}', [JobController::class, 'create'])->name('job.create');
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

// **Application Routes (Requires Authentication)**
Route::middleware('auth')->group(function () {
    Route::get('/apply/{job_id}', [ApplicationController::class, 'create'])->name('apply.create');
    Route::post('/applyjob/{job_id}', [ApplicationController::class, 'store'])->name('apply.store');
   

});
Route::get('/jobs/apply/{id}', [ApplicationController::class, 'apply'])->name('jobs.apply');

// **Recruiter Applications Routes**
Route::middleware(['auth'])->get('/recruiter/applications/{jobId?}', [RecruiterProfileController::class, 'showApplications'])->name('recruiter.showApplications');
Route::middleware(['auth'])->post('/recruiter/application/{applicationId}/reject', [RecruiterProfileController::class, 'rejectApplication'])->name('recruiter.rejectApplication');
Route::middleware(['auth'])->post('/recruiter/application/{applicationId}/schedule', [RecruiterProfileController::class, 'scheduleInterview'])->name('recruiter.scheduleInterview');

// **Student Application Routes**
Route::middleware(['auth'])->get('/student/applications', [StudentProfileController::class, 'showStudentApplications'])->name('StudentProfile.showStudentApplications');


//Admin 
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/admin/pending-jobs', [AdminController::class, 'showPendingJobs'])->name('admin.pendingJobs');
    Route::patch('/admin/approve-job/{id}', [AdminController::class, 'approveJob'])->name('admin.approveJob');
    Route::delete('/admin/delete-job/{id}', [AdminController::class, 'deleteJob'])->name('admin.deleteJob');
});

//Notifications

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');


//search
Route::get('/search-jobs', [JobController::class, 'search'])->name('jobs.search');

//Freelancing
Route::get('/freelancing-jobs', [FreelancingController::class, 'index'])->name('freelancing.index');




// // Route to redirect to GitHub for authentication
// Route::get('auth/github', [GitHubController::class, 'redirectToGitHub'])->name('github.login');

// // Route for the GitHub callback after authentication
// Route::get('auth/github/callback', [GitHubController::class, 'handleGitHubCallback']);



