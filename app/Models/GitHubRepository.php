<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GitHubRepository extends Model
{
    use HasFactory;
    protected $table = 'github_repositories';

    protected $fillable = [
        'user_id',
        'github_id',
        'github_name',
        'description',
        'url',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
