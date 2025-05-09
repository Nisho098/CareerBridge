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

   
    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }

    
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
    

}
