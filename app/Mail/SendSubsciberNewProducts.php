<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class SendSubsciberNewProducts extends Mailable
{
    use Queueable, SerializesModels;
    public $subscriber, $products;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscriber, $products)
    {
        $this->subscriber = $subscriber;
        $this->products = $products;
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

        return $this->from(Request::server("HTTP_HOST").'@shop.test')->subject('სიახლე: '.count($this->products).' ახალი პროდუქტი')->markdown('emails.new-products',[
            'products' => $this->products, 'subscriber' => $this->subscriber, 'unsubscribeLink' => $unsubscribeLink
        ]);
    }
}
