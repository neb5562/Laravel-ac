<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_cat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prod_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('cat_id')->constrained('product_categories')->onDelete('cascade');
            $table->unique(['prod_id', 'cat_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prod_cat');
    }
}
