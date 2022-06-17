<?php

namespace App\Console\Commands;

use App\Mail\SendSubsciberNewProducts;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendSubscribersNewProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'დღეში ერთხელ გამომწერებს ვუგზავნი მოცემულ დღეს დამატებულ პროდუქტებს';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscribers = DB::table('email_subscribers')
            ->where('is_verified','=',TRUE)
            ->limit(20)
            ->get();

        foreach($subscribers as $subscriber)
        {
            $products = DB::table('products')
                ->join('products_to_email_subscribers', 'products.id', '=', 'products_to_email_subscribers.product_id')
                ->select('products.*',DB::raw('(select image_id from images where product_id = products.id limit 1) as image'))
                ->where('products_to_email_subscribers.subscriber_id','=',$subscriber->id)
                ->get();

            Mail::to($subscriber->email)->send(new SendSubsciberNewProducts($subscriber,$products));
            DB::table('products_to_email_subscribers')->where('subscriber_id', '=', $subscriber->id)->delete();

        }
    }
}
