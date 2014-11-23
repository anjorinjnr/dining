<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEducationToTutorTable extends Migration {

	/**
	 * Added fields to capture tutor's highest level of education.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tutors', function(Blueprint $table)
		{
		  $table->string('education');
		  $table->string('major');
		  $table->string('institution');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tutors', function(Blueprint $table)
		{
			//
		});
	}

}
