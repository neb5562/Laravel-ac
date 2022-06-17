<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->unsignedDecimal('product_price', $precision = 15, $scale = 2);
            $table->unsignedSmallInteger('product_count')->default(1);
            $table->text('product_short_description');
            $table->text('product_full_description');
            $table->unsignedSmallInteger('product_thumbs_count')->default(0);
            $table->unsignedInteger('product_sold_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
