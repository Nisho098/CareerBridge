<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\support\facades\validator;
use Illuminate\support\facades\Auth;
use Illuminate\support\str;
use Illuminate\support\facades\hash;
use App\Models\User;
use App\Models\Studentprofile;
use App\Models\Recruiterprofile;
use App\Mail\ResetPassword;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    //this method will show user registration
    public function registration()
    {
        return view('frontend.Account.studentsignup');

    }
    public function recuiterregistration()
    {
        return view('frontend.Account.recuitersignup');
    }
           //this method will save user registration
           public function processStudentRegistration(Request $request)
           {
               // Validate the student registration data
               $validator = Validator::make($request->all(), [
                   'name' => 'required|string|max:50',
                   'email' => [
                       'required',
                       'email',
                       'unique:users,email',
                       'max:100',
                       function ($attribute, $value, $fail) {
                           if (!str_ends_with($value, '@edu.np')) {
                               $fail('The email must end with @edu.np.');
                           }
                       },
                   ],
                   'password' => 'required|min:5|same:confirm_password',
                   'confirm_password' => 'required',
                   'role' => 'required|string|in:student',
               ], [
                   // Custom error messages
                   'name.required' => 'The name field is required.',
                   'email.required' => 'Please enter your email address.',
                   'email.email' => 'Please enter a valid email address.',
                   'email.unique' => 'This email is already registered.',
                   'email.max' => 'The email address must not exceed 100 characters.',
                   'password.required' => 'The password field is required.',
                   'password.min' => 'The password must be at least 5 characters long.',
                   'password.same' => 'The password and confirm password must match.',
                   'confirm_password.required' => 'The confirm password field is required.',
                   'role.required' => 'The role field is required.',
                   'role.in' => 'Invalid role selected. Please select a valid role.',
               ]);
           
               if ($validator->fails()) {
                   return redirect()->back()
                       ->withErrors($validator)
                       ->withInput();
               }
           
               // Save the student to the database
               $user = User::create([
                   'name' => $request->name,
                   'email' => $request->email,
                   'password' => Hash::make($request->password),
                   'role' => 'student',
               ]);
           
               // Create student profile
               Studentprofile::create([
                   'user_id' => $user->id,
                   'name' => $user->name,
               ]);
           
               // Log in the user
               Auth::login($user);
           
               return redirect()->route('Account.signin')->with('success', 'Registration successful! You can now log in.');
           }
           



    public function processRecruiterRegistration(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email|max:100',
            'password' => 'required|min:8|same:confirm_password',
            'confirm_password' => 'required',
            'role' => 'required|string|in:recruiter',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'Please enter your email.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.same' => 'The password and confirm password must match.',
            'confirm_password.required' => 'The confirm password field is required.',
            'role.required' => 'The role field is required.',
        ]);
        
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // Create a new recruiter user in the `users` table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Assign role from validated input
        ]);
    
        // Create a corresponding profile in the `recruiter_profiles` table
        Recruiterprofile::create([
            'user_id' => $user->id,
            'name' => $user->name,
        ]);
    
        // Redirect to the recruiter's dashboard or a success page
        return redirect()->route('Account.signin')->with('success', 'Recruiter registration successful!');
    }
    


public function forgetPassword()
{
    return view('frontend.Account.forgetPassword');

}
public function sendResetLink(Request $request)
{
    // Validate the email
    $request->validate([
        'email' => 'required|email|exists:users,email', // Ensure the email exists in the 'users' table
    ]);

    // Generate a token
    $token = Str::random(60);

    // Insert the token and email into the password_resets table
    DB::table('password_resets')->where('email', $request->email)->delete();
    DB::table('password_resets')->insert([
        'email' => $request->email,
        'token' => $token,
        'created_at' => now(), // Ensure this function is used with parentheses
    ]);

    // Send Email Here
    $user = User::where('email', $request->email)->first();

    $formData = [
        'token' => $token,
        'user' => $user,
        'mailSubject' => 'You have requested to reset your password', // Add a comma here
    ];

    Mail::to($request->email)->send(new ResetPassword($formData));

    return redirect()->route('Account.signin')->with('success', 'Please check your inbox to reset your password');
}

public function showResetForm($token)
{
    // Pass the token to the view as part of the formData
    $tokenExist =DB::table('password_resets')->where('token', $token)->first();
    if($tokenExist==null){
        return redirect()->route('Account.forgetPassword')->with('error','Invalid request');
    }
 return view('frontend.Account.reset-Password', ['token' => $token]);
}

public function processResetPassword(Request $request)
{
    // Get token from the request
    $token = $request->token;

    // Fetch the password reset record by token
    $tokenObj = DB::table('password_resets')->where('token', $token)->first();

    if ($tokenObj === null) {
        return redirect()->route('Account.forgetPassword')->with('error', 'Invalid or expired reset link.');
    }

    // Fetch the user associated with the email
    $user = User::where('email', $tokenObj->email)->first();

    if (!$user) {
        return redirect()->route('Account.forgetPassword')->with('error', 'User not found.');
    }

    // Validate the input fields
    $request->validate([
        'password' => 'required|min:5',
        'password_confirmation' => 'required|same:password',
    ]);

    // Update the user's password
    $user->update([
        'password' => Hash::make($request->password),
    ]);

    // Delete the reset token record
    DB::table('password_resets')->where('email', $user->email)->delete();

    // Redirect with success message
    return redirect()->route('Account.signin')->with('success', 'Your password has been reset successfully. You can now log in.');
}








   
        
           


           public function login()
           {
               return view('frontend.Account.signin');
           }
           
          
           
           public function loginUser(Request $request)
           {
               // Validate input fields
               $request->validate([
                   'email' => 'required|email',
                   'password' => 'required',
               ]);
           
               // Attempt to authenticate the user
               if (Auth::attempt($request->only('email', 'password'))) {
                   // Get the authenticated user
                   $user = Auth::user();
           
                   // Redirect based on the user's role
                   if ($user->role === 'student') {
                    return redirect()->route('dashboard')->with('success', 'Welcome to the student dashboard!');
                } elseif ($user->role === 'recruiter') {
                    return redirect()->route('recruiterdashboard')->with('success', 'Welcome to the recruiter dashboard!');
                } elseif ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard')->with('success', 'Welcome to the admin dashboard!');
                } else {
                    // Logout if the role is invalid or not recognized
                    Auth::logout();
                    return redirect()->route('login')->withErrors('Invalid role. Contact support.');
                }
            
               }
           
               // If authentication fails, redirect back with error
               return back()->with('error', 'Invalid email or password.');
           }
        
    
           
           
           
           

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
