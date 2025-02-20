<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'recruiter_id'];

    // Relationship to User (Student)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relationship to User (Recruiter)
    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    // // Relationship to Messages
    // public function messages()
    // {
    //     return $this->hasMany(Chat::class);
    // }
}
