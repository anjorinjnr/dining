<?php

namespace Chefme\Validators;

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
        'password',
        'confirm_password'
    );
    public static $rules = array(
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'confirm_password' => 'required|same:password',
    );

}
