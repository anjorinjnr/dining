<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsermessagesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
	Schema::create('user_messages', function($table) {
	  $table->integer('message_id')->references('id')->on('messages');
	  $table->integer('user_id')->references('id')->on('users');
	  $table->enum('status', [1, 0])->default(0); //1 read, 0 unread
	  $table->primary(['message_id', 'user_id']);
	  $table->timestamps();
	  $table->softDeletes();
	  
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
