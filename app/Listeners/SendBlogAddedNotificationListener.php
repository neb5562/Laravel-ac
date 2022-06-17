<?php

namespace App\Listeners;

use App\Events\BlogAddedEvent;
use App\Models\Mailer;
use DB;

class SendBlogAddedNotificationListener
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
     * @param  BlogAddedEvent  $event
     * @return void
     */
    public function handle($event)
    {
        $AllVerifiedSubscribers = Mailer::where('is_verified', True)->get();

        $blogs_to_email_subscribers = array();

        foreach ($AllVerifiedSubscribers as $key => $value) {
            $blogs_to_email_subscribers[] = ['blog_id' => $event->blog->id, 'subscriber_id' => $value->id];
        }
        DB::table('blogs_to_email_subscribers')->insert($blogs_to_email_subscribers);
    }
}
