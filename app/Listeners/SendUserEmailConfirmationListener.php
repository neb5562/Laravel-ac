<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;
use Illuminate\Support\Str;

class SendUserEmailConfirmationListener
{

    /**
     * Handle the event.
     *
     * @param  UserRegisteredEvent  $event
     * @return void
     */
    public function handle($event)
    {
        $event->user->email_verification_token = Str::random(33);
        $event->user->save();
        DB::table('email_verifications_to_send')->updateOrInsert(['user_id' => $event->user->id]);
    }
}
