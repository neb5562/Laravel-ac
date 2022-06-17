<?php

namespace App\Mail;

use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class NotifyUserPasswordChangeLink extends Mailable
{
    use Queueable, SerializesModels;

    public $passwordReset;

    /**
     * Create a new message instance.
     *
     * @param $passwordReset
     */
    public function __construct($passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $passwordresetlink =  URL::temporarySignedRoute(
            'password.resetForm', now()->addMinutes(config('settings.verification_links_expire_time')), ['token' => $this->passwordReset->token]
        );

        return $this->from(Request::server ("HTTP_HOST").'@shop.test')->subject('პაროლის აღდგენა')->markdown('emails.password-change-link',[
            'url' => $passwordresetlink, 'expminutes' =>config('settings.verification_links_expire_time')
        ]);
    }
}
