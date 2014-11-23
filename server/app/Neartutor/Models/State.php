<?php

namespace Neartutor\Models;

class State extends \Eloquent {

    protected $guarded = array();
	
	public function towns() {
	  return $this->hasMany('Neartutor\Models\Town');
	}

}
