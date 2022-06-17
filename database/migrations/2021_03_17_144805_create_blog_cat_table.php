<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_cat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained('blog_posts')->onDelete('cascade');
            $table->foreignId('cat_id')->constrained('blog_categories')->onDelete('cascade');
            $table->unique(['blog_id', 'cat_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_cat');
    }
}
