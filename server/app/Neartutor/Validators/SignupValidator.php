<?php

namespace Neartutor\Validators;

/**
 * Description of SignupValidator
 *
 * @author kayfun
 */
class SignupValidator extends Validator {

    protected $fields = array(
        'firstname',
        'lastname',
        'email',
        'state_id',
        'town_id',
        'area_id',
        'password',
        'confirm_password',
        'user_type',
        'terms_agreed'
    );
    public static $rules = array(
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email',
        'state_id' => 'required|min:1',
        'town_id' => 'required|min:1',
        'area_id' => 'required|min:1',
        'password' => 'required',
        'confirm_password' => 'required|same:password',
        'user_type' => 'required|in:0,1,2',
        'terms_agreed' => 'required'
    );

}
