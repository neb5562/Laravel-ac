<?php

namespace App\Listeners;

use App\Events\ProductAddedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Mailer;
use DB;

class SendProductAddedNotificationListener
{


    /**
     * Handle the event.
     *
     * @param  ProductAddedEvent  $event
     * @return void
     */
    public function handle($event)
    {
        $AllVerifiedSubscribers = Mailer::where('is_verified', True)->get();

        $products_to_email_subscribers = array();

        foreach ($AllVerifiedSubscribers as $key => $value) { 
            $products_to_email_subscribers[] = ['product_id' => $event->product->id, 'subscriber_id' => $value->id];
        }
        DB::table('products_to_email_subscribers')->insert($products_to_email_subscribers);

    }
}
