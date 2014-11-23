<?php

namespace Neartutor\Models;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UserMessage extends \Eloquent {

  protected $guarded = array();

  use SoftDeletingTrait;

  protected $dates = ['deleted_at'];

  public function message() {
	return $this->belongsTo('Neartutor\Models\Message', 'message_id', 'id');
  }

}
