<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;

class SendGuestEmailConfirmationLink extends Mailable
{
    use Queueable, SerializesModels;

    public $guest;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($guest)
    {
        $this->guest = $guest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailConfirmationLink =  URL::temporarySignedRoute(
            'verifyGuestEmail', now()->addMinutes(config('settings.verification_links_expire_time')), ['slug' => $this->guest->token]
        );
        return $this->from(Request::server ("HTTP_HOST").'@shop.test')->subject('გთხოვთ დაადასტუროთ თქვენი ელფოსტა')->markdown('emails.guest-email-confirmation-link',[
            'url' => $emailConfirmationLink, 'expminutes' => config('settings.verification_links_expire_time')
        ]);
    }
}
