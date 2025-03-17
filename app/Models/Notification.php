<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'message', 'type', 'read_at']; // changed user_id to student_id

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id'); // Ensuring relationship with the correct column
    }
}
