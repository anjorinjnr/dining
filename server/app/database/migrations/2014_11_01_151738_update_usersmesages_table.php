<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersmesagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_messages', function(Blueprint $table)
		{
			$table->dropPrimary(['message_id', 'user_id']);
			$table->unique(['message_id', 'user_id']);
			$table->increments('id');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_messages', function(Blueprint $table)
		{
			//
		});
	}

}
