<?php

namespace App\Jobs;

use App\Mail;
use App\Mail\MailNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;

    /**
     * Create a new job instance.
     *
     * @param $data
     */
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $user) {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new MailNotify);
        }
    }
}
