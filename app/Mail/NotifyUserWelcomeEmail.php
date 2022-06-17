<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUserWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Request::server ("HTTP_HOST").'@shop.test')->subject('მოგესალმებით')->markdown('emails.welcome-email',[
            'username' => $this->user->username,'url1' => route('shop'), 'url2' => route('contact'), 'url3' => route('cart.index'),
            'url4' => route('blog')
        ]);
    }
}
