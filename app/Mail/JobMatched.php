<?php

namespace App\Mail;

use App\Models\Job;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobMatched extends Mailable
{
    use Queueable, SerializesModels;

    public $job;
    public $user;

    public function __construct(Job $job, User $user)
    {
        $this->job = $job;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Job Match Notification')
                    ->view('frontend.StudentProfiles.job_matched'); 
    }
    
}
