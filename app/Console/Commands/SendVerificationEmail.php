<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyUserEmailConfirmationLink;

class SendVerificationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:verificationemails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ყოველ 30 წამში გაიგზავნოს ახალი დარეგისტრირებული მომხმარებლისთვის ემაილის ვერიფიკაციის შეტყობინება ელ.ფოსტაზე.';

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
        $verIds = DB::table('email_verifications_to_send')->limit(5)->get();

        foreach($verIds as $vId)
        {
            //უსერს განუახლოს გაგზავნის დრო
            $user = User::find($vId->user_id);
            Mail::to($user->email)->send(new NotifyUserEmailConfirmationLink($user));
            DB::table('email_verifications_to_send')->where('user_id', '=', $vId->user_id)->delete();

        }

    }
}
