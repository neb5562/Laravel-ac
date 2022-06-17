<?php

namespace App\Mail;

use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class NotifyUserEmailConfirmationLink extends Mailable
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
        $emailConfirmationLink =  URL::temporarySignedRoute(
            'verifyEmail', now()->addMinutes(config('settings.verification_links_expire_time')), ['slug' => $this->user->email_verification_token]
        );
        return $this->from(Request::server ("HTTP_HOST").'@shop.test')->subject('გთხოვთ დაადასტუროთ თქვენი ელფოსტა')->markdown('emails.email-confirmation-link',[
            'username' => $this->user->username, 'url' => $emailConfirmationLink, 'expminutes' => Config::get('settings.verification_links_expire_time')
        ]);
    }
}
