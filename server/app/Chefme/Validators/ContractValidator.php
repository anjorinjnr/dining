<?php

namespace Chefme\Validators;

/**
 * Description of ContractValidator
 *
 * @author kayfun
 */
class ContractValidator extends Validator {

    protected $fields = array(
        'tutor_id',
        'student_id',
        'subject_id',
        'scheduled_hours',
        'rate'
    );
    public static $rules = array(
        'tutor_id' => 'integer|required',
        'student_id' => 'integer|required',
        'subject_id' => 'integer|required',
        'scheduled_hours' => 'integer',
        'rate' => 'numeric'
    );

}
