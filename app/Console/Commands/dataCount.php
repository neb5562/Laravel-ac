<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class dataCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:counts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'განახლოს რაოდენობები ადმინ პანელში';

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
        DB::table('config_data')->update([
           'count_purchases' => 0,
            'count_users' => DB::table('users')->count(),
            'count_products' => DB::table('products')->count(),
            'count_images' => DB::table('images')->count(),
            'count_blogs' => DB::table('blog_posts')->count(),
        ]);
    }
}
