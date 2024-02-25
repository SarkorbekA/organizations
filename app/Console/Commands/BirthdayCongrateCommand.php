<?php

namespace App\Console\Commands;

use App\Mail\BirthdayGreetings;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Command\Command as CommandAlias;

class BirthdayCongrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:birthday-init {--ids}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday greetings to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->birthday = true;
            $user->save();
            Mail::to($user->email)->send(new BirthdayGreetings($user));
        }

        $this->info('Congratulations emails sent successfully.');

        return CommandAlias::SUCCESS;
    }
}




//return CommandAlias::SUCCESS;


