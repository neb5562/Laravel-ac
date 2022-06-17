<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class SendSubscribersNewBlogs extends Mailable
{
    use Queueable, SerializesModels;
    public $subscriber, $blog;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscriber, $blogs)
    {
        $this->subscriber = $subscriber;
        $this->blogs = $blogs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $unsubscribeLink =  URL::temporarySignedRoute(
            'newsletter.unsubscribe', now()->addMinutes(43200), ['email' => Crypt::encrypt($this->subscriber->email)]
        );

        return $this->from(Request::server ("HTTP_HOST").'@shop.test')->subject('სიახლე: '.count($this->blogs).' ახალი ბლოგი')->markdown('emails.new-blogs',[
            'blogs' => $this->blogs, 'subscriber' => $this->subscriber, 'unsubscribeLink' => $unsubscribeLink
        ]);
    }
}
