<?php

namespace Neartutor\Validators;

/**
 * Description of NotificationValidator
 *
 * @author kayfun
 */
class NotificationValidator extends Validator {

    protected $fields = array(
        'email',
        'subject',
        'name',
    );
    public static $rules = array(
        'email' => 'required|email',
        'subject' => 'required',
        'name' => 'required'
    );
    public static $messages = array(
        'email.required' => 'Email address is required',
        'email' => 'Invalid email supplied',
        'subject.required' => 'Message subject is required',
        'name.required' => 'Sender name is required'
    );

}

?>
