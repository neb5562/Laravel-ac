<?php

namespace App\Listeners;

use App\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\EmailVerifiedEvent;
use DB;

class MoveVerifiedUserIntoSubscribersListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Verified  $event
     * @return void
     */
    public function handle($event)
    {
        DB::table('email_subscribers')->updateOrInsert(['name' => $event->user->name, 'email' => $event->user->email, 'token' => NULL],['is_verified' => TRUE]);
    }
}
