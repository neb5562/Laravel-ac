<?php

namespace App\Console\Commands;

use App\Mail\NotifyUserWelcomeEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:welcomemails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'გაეგზავნოს შეტყობინება ახალ დარეგისტრირებულ მომხმარებელს';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $verIds = DB::table('user_welcome_emails')->limit(10)->get();

        foreach($verIds as $vId)
        {
            $user = User::find($vId->user_id);
            Mail::to($user->email)->send(new NotifyUserWelcomeEmail($user));
            DB::table('user_welcome_emails')->where('user_id', '=', $vId->user_id)->delete();

        }
    }
}
