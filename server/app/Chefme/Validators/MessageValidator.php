<?php

namespace Chefmes\Validators;

/**
 * Description of MessageValidator
 *
 * @author kayfun
 */
namespace Chefme\Validators;

class MessageValidator extends Validator {

    protected $fields = array(
		'subject',
        'body',
        'from',
		'to'
    );
    public static $rules = array(
		'subject' => 'required',
        'body' => 'required',
        'from' => 'required',
		'to' => 'required'
    );

}
