<?php

namespace App\Jobs;

use App\Mail\EmailCampaignMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class SendEmailCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $email;
    protected $offerSub;
    protected $offerBody;

    public $tries = 3;
    public $retryAfter = 60;
    public function __construct($email, $offerSub, $offerBody)
    {
        $this->email = $email;
        $this->offerSub = $offerSub;
        $this->offerBody = $offerBody;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new EmailCampaignMail($this->offerSub, $this->offerBody));
    }

    public function failed(Exception $failed)
    {
        Log::error('Job failed finally: '.$failed->getMessage());
    }
}
