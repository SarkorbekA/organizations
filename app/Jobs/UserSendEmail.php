<?php

namespace App\Jobs;

use App\Mail\ConfirmAccount;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UserSendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * create a new job instance.
     */
    public function __construct(
        private User $user,
        private int  $random
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(5);
        Mail::to($this->user->email)->send(new ConfirmAccount($this->user, $this->random));
    }
}

