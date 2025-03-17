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
        'salary',
        'benefits',
       'salary_type',
       'project_duration',
       'payment_terms',
        'application_deadline',
        'recruiter_id',
        'status'
    ];

    protected $casts = [
        'benefits' => 'array', 
    ];

    public function recruiterProfile()
    {
        return $this->belongsTo(RecruiterProfile::class, 'recruiter_id', 'id');
    }
    
   
    public function user()
{
    return $this->belongsTo(User::class);
}
public function recruiter()
{
    return $this->belongsTo(RecruiterProfile::class, 'recruiter_id');
}




    
    
    
    
    
public function applications()
{
    return $this->hasMany(Application::class);
}


}