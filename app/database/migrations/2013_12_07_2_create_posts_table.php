<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->integer('author_id')->unsigned();
            $table->string('title')->nullable();
            $table->mediumText('content');
            $table->dateTime('date');
            $table->integer('views')->nullable();
            $table->integer('favorite')->nullable();
            $table->integer('size')->nullable();
            $table->boolean('not_found');
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
        Schema::drop('posts');
    }

}
