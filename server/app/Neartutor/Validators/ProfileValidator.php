<?php

namespace Neartutor\Validators;

/**
 * Description of ProfileValidator
 *
 * @author kayfun
 */
use Neartutor\Validators\Validator;

class ProfileValidator extends Validator {

    protected $fields = array(
        'occupation',
        'gender',
        'dob',
        'phone_number'
    );
    public static $rules = array(
        'gender' => 'required',
        'dob' => 'required',
        'phone_number' => 'required',
        'tutor_id' => 'required'
    );

}
