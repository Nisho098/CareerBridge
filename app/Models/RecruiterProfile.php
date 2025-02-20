<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruiterProfile extends Model

{
    protected $table = 'recruiter_profiles'; 
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'company_website',
        'contact_number',
        'address',
        'details',
        'personaldetails',
        'aboutcompany',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    
}
