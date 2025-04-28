<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'password',
        'role',
        'about',
        'email',
        'university_name',
        'contact',
        'location',
        'cv_url',
        'github_id',
        'github_username',
        'github_token',
        'github_avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function studentProfile()
    {
        return $this->hasOne(Studentprofile::class, 'user_id');
    }

    public function recruiterProfile()
    {
        return $this->hasOne(Recruiterprofile::class, 'user_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function repositories()
    {
        return $this->hasMany(GitHubRepository::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'student_id');
    }
    public function jobs()
    {
        return $this->hasMany(Job::class, 'job_poster_id'); // Recruiter le post gareko jobs
    }
}
