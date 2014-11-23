<?php

namespace Neartutor\Models;

class Student extends \Eloquent {

    protected $guarded = array();

    public function user() {
        return $this->belongsTo('Neartutor\Models\User', 'id', 'id');
    }

}
