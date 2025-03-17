<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    use HasFactory;

    // Define the table if it is different from the default plural form of the model name
    protected $table = 'repositories';  // Only necessary if the table name differs

    // Specify the fields that are mass assignable
    protected $fillable = [
        'user_id',
        'github_id',
        'name',
        'description',
        'url',
        'language',
        'stars',
        'forks',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
