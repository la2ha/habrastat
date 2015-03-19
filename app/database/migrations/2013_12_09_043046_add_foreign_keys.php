<?php

use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
    {
        Schema::table('posts', function ($table) {
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
        Schema::table('comments', function ($table) {
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
    {
        Schema::table('posts', function ($table) {
            $table->dropForeign('posts_author_id_foreign');
        });

        Schema::table('comments', function ($table) {
            $table->dropForeign('comments_author_id_foreign');
            $table->dropForeign('comments_post_id_foreign');
        });
    }

}