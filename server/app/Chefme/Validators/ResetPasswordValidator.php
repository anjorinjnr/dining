<?php

namespace Chefme\Validators;

/**
 * Description of ResetPasswordValidator
 *
 * @author kayfun
 */
class ResetPasswordValidator extends Validator {

    protected $fields = array(
        'id',
        /**
         * @todo New Password min length should be 6
         */
        'new_password',
        'reset_code'
    );
    
    public static $rules = array(
        'id' => 'required',
        'new_password' => 'required',
        'reset_code' => 'required'
    );
    
    public static $messages = array(
        'required' => 'Your password cannot be empty',
        'min' => 'Your password must be at least 6 characters',
        'same' => 'Your password do not match'
    );

}

?>
