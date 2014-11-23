<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectCategoriesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
	Schema::create('subject_categories', function($table) {
	  $table->integer('subject_id')->references('id')->on('subjects');
	  $table->integer('category_id')->references('id')->on('categories');
	  $table->timestamps();
	});
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
	//
  }

}
