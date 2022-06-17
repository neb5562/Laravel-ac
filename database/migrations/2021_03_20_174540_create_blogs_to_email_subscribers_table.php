<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsToEmailSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs_to_email_subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained('blog_posts')->onDelete('cascade');
            $table->foreignId('subscriber_id')->constrained('email_subscribers')->onDelete('cascade');
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
        Schema::dropIfExists('blogs_to_email_subscribers');
    }
}
