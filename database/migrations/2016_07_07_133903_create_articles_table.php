<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function(Blueprint $table){
            $table->increments('id');
            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->string('brief', 500);
            $table->text('content');
            $table->string('source', 200)->nullable();
            $table->integer('orderby', false, true)->default(0);
            $table->integer('user_id', false, true);
            $table->integer('image_id', false, true)->nullable();
            $table->integer('image_fb_id', false, true)->nullable();
            $table->tinyInteger('status', false, true)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
