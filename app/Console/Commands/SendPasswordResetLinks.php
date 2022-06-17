<?php

namespace App\Console\Commands;

use App\Mail\NotifyUserEmailConfirmationLink;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyUserPasswordChangeLink;

class SendPasswordResetLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:passwordresets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ყოველ 30 წამში გააგზავნოს პაროლის აღსადგენი ლინკი';

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
        $verIds = DB::table('password_resets')->where('is_send',FALSE)->limit(5)->get();

        foreach($verIds as $vId)
        {
            Mail::to($vId->email)->send(new NotifyUserPasswordChangeLink($vId));
            DB::table('password_resets')->where('email', '=', $vId->email)->update(['is_send' => TRUE]);

        }
    }
}
