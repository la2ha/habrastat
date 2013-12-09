<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->integer('post_id')->unsigned();
            $table->integer('author_id')->unsigned();
            $table->integer('parent_id')->nullable();
            $table->text('message');
            $table->string('date_str');
            $table->integer('score_total')->nullable();
            $table->integer('score_minus')->nullable();
            $table->integer('score_plus')->nullable();
        });


    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comments');
    }

}
