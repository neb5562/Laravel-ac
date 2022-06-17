<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_data', function (Blueprint $table) {
            $table->unsignedInteger('count_purchases')->default(0);
            $table->unsignedInteger('count_users')->default(0);
            $table->unsignedInteger('count_products')->default(0);
            $table->unsignedInteger('count_images')->default(0);
            $table->unsignedInteger('count_blogs')->default(0);
        });

        DB::table('config_data')->insert(
            array(
                'count_purchases' => 0,
                'count_users' => 0,
                'count_products' => 0,
                'count_images' => 0,
                'count_blogs' => 0,
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_data');
    }
}
