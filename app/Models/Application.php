<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Application extends Model
{
  
    use HasFactory;

    protected $fillable = [
        'student_id', 'job_id', 'cover_letter', 'application_status'
    ];

    // Relationship with the StudentProfile
    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }

    // Relationship with the Job
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
    
}
