<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Notifications\VerifyEmail;
use Chatify\Traits\ChatifyMessenger;

class User extends Authenticatable
{
    
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   

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
        // Add other fields if necessary
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function studentProfile()
    {
        return $this->hasOne(Studentprofile::class, 'user_id',);
    }
    public function recruiterProfile()
    {
        return $this->hasOne(Recruiterprofile::class, 'user_id', 'id');
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }
    
    
    
    
 

  



    
  
}

