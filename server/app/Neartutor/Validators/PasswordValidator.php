<?php

namespace Neartutor\Validators;

/**
 * Description of PasswordValidator
 *
 * @author kayfun
 */
class PasswordValidator extends Validator {

    protected $fields = array(
        'id',
        'old_password',
        /**
         * @todo New Password min length should be 6
         */
        'password'
    );
    
    public static $rules = array(
        'id' => 'required',
        'old_password' => 'required',
        'password' => 'required'
    );
    
    public static $messages = array(
        'required' => 'Your password cannot be empty',
        'min' => 'Your password must be at least 6 characters'
    );

}

?>
