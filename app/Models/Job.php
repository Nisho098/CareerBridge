<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'location',
        'job_type',
        'industry',
        'requirements',
        'application_deadline',
        'recruiter_id',
        'status'
    ];

    
    public function jobs()
    {
        return $this->hasMany(Job::class, 'recruiter_id');
    }
   
    
    public function recruiterProfile()
    {
        return $this->belongsTo(RecruiterProfile::class, 'recruiter_id', 'user_id');
    }
    
    
    
public function applications()
{
    return $this->hasMany(Application::class);
}


}