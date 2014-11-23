<?php

namespace Neartutors\Validators\Tutor;

/**
 * Description of SubjectValidator
 *
 * @author kayfun
 */
use Neartutors\Validators\Validator;

class SubjectValidator extends Validator {

    protected $fields = array(
        'subject',
        'rate',
        'note',
        'supporting_document',
        'tutor_id'
    );
    public static $rules = array(
        'subject' => 'required',
        'rate' => 'required',
        'note' => 'required',
        'supporting_document' => 'mimes:doc,docx,pdf',
        'tutor_id' => 'required'
    );

}
