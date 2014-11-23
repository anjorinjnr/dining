<?php

namespace Neartutor\Validators;

/**
 * Description of SubjectValidator
 *
 * @author kayfun
 */

class SubjectValidator extends Validator {

    protected $fields = array(
        'title'
    );
    public static $rules = array(
        'title' => 'required'
    );

}
