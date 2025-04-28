<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Job;

class JobReferralMail extends Mailable
{
    use Queueable, SerializesModels;

    public $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function build()
   
{
    return $this->subject('New Job Referral')
                ->view('frontend.StudentProfiles.job_referral') 
                ->with([
                    'jobTitle' => $this->job->title,
                    'jobIndustry' => $this->job->industry,
                    'jobLocation' => $this->job->location,
                    'jobDeadline' => \Carbon\Carbon::parse($this->job->application_deadline)->format('F j, Y'),
                ]);
}

}
