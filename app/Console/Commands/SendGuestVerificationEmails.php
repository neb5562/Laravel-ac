<?php

namespace App\Console\Commands;

use App\Mail\SendGuestEmailConfirmationLink;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendGuestVerificationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:guestVerificationEmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'სტუმარ მომხმარებელს ვუგზავნით ელფოსტის ვერიფიკაციის ლინკს რათა დაადასტურონ ელ.ფოსტა და გახდნენ სიახლეების გამომწერები';

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
        $verIds = DB::table('email_verifications_to_send_guests')->limit(5)->get();

        foreach ($verIds as $vId) {

            $guest = DB::table('email_subscribers')->where('email','=',$vId->email)->limit(1)->get();
            Mail::to($guest[0]->email)->send(new SendGuestEmailConfirmationLink($guest[0]));
            DB::table('email_verifications_to_send_guests')->where('email', '=', $guest[0]->email)->delete();
        }
    }

}
