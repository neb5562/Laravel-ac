<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;

class SendUserWelcomeEmailListener
{

    /**
     * Handle the event.
     *
     * @param  UserRegisteredEvent  $event
     * @return void
     */
    public function handle($event)
    {
        DB::table('user_welcome_emails')->insert(['user_id' => $event->user->id]);
    }
}
