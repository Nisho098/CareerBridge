<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'message', 'type', 'read_at']; 

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id'); 
    }
}
