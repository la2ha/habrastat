<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotHubPostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hub_post', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('hub_id')->unsigned()->index();
			$table->integer('post_id')->unsigned()->index();
			$table->foreign('hub_id')->references('id')->on('hubs')->onDelete('cascade');
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hub_post');
	}

}
