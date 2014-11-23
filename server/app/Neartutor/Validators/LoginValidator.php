<?php

namespace Neartutor\Validators;

/**
 * Description of LoginValidator
 *
 * @author kayfun
 */
class LoginValidator extends Validator {

    protected $fields = array(
        'email',
        'password'
    );
    public static $rules = array(
        'email' => 'required|email',
        'password' => 'required'
    );

}

?>
