<?php


namespace Neartutor\Validators;
/**
 * Description of JobValidator
 *
 * @author kayfun
 */
class JobValidator extends Validator {

    protected $fields = array(
        'subject_id',
		'student_id',
        'details',
		);
    public static $rules = array(
        'subject_id' => 'required',
		'student_id' => 'required',
		'details' => 'required'
    );

}
