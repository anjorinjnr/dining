<?php

namespace Neartutors\Validators;

/**
 * Description of LessonValidator
 *
 * @author kayfun
 */
class LessonValidator extends Validator {

    protected $fields = array(
        'subject',
        'note',
        'student_id'
    );
    public static $rules = array(
        'subject' => 'required',
        'note' => 'required',
        'student_id' => 'required'
    );

}
