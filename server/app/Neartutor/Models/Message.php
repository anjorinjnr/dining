<?php

namespace Neartutor\Models;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Message extends \Eloquent {

  protected $guarded = array();

  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];

  public function recipients() {
	return $this->hasMany('Neartutor\Models\UserMessage');
  }
  
}
