<?php

namespace Neartutor\Validators;

/**
 * Description of LessonValidator
 *
 * @author kayfun
 */
class LessonValidator extends Validator {

    protected $fields = array(
        'subject_id',
        'tutor_id',
        'student_id',
        'start_time',
        'end_time',
        'percentage_earned',
        'hours'
    );
    public static $rules = array(
        'subject_id' => 'required',
        'tutor_id' => 'required',
        'student_id' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'hours' => 'required'
    );

}
