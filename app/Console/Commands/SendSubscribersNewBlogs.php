<?php

namespace App\Console\Commands;

use App\Mail\SendSubscribersNewBlogs as mailsub;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendSubscribersNewBlogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new:blogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'გამომწერებს უგზავნის ყოველ 1 საათში ახალ ბლოგ პოსტებს';

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
            $blogs = DB::table('blog_posts')
                ->join('blogs_to_email_subscribers', 'blog_posts.id', '=', 'blogs_to_email_subscribers.blog_id')
                ->select('blog_posts.*',DB::raw('(select image_id from images where blog_id = blog_posts.id limit 1) as image'))
                ->where('blogs_to_email_subscribers.subscriber_id','=',$subscriber->id)
                ->get();

            Mail::to($subscriber->email)->send(new mailsub($subscriber,$blogs));
            DB::table('blogs_to_email_subscribers')->where('subscriber_id', '=', $subscriber->id)->delete();

        }
    }
}
