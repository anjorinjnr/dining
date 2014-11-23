<?php

namespace Chefme\Validators;

/**
 * Description of CategoryValidator
 *
 * @author kayfun
 */
class CategoryValidator extends Validator {

    protected $fields = array(
        'category_name'
    );
    public static $rules = array(
        'category_name' => 'required',
    );

}
