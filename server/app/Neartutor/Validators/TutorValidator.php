<?php

namespace Neartutor\Validators;

/**
 * Description of TutorValidator
 *
 * @author kayfun
 */

class TutorValidator extends Validator {

    protected $fields = array(
		'rate',
		'profile_title',
		'profile_summary',
		'occupation',
		'terms_agreed',
		'created_at',
		'updated_at'
    );
    public static $rules = array(
    );

}
