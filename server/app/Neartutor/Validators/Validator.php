<?php

namespace Neartutor\Validators;

abstract class Validator {

    protected $data;
    protected $raw_data;
    protected $fields;
    protected $validator;
    public $errors;
    public static $rules;
    public static $messages = array(
        'required' => 'The :attribute field is required.',
        'email' => 'Invalid e-mail address!',
    );

    public function __construct($data = null) {
        $this->raw_data = $data;
        $this->extractData();
    }

    public function passes() {
        $this->validator = \Validator::make($this->raw_data, static::$rules, static::$messages);
        if ($this->validator->passes()) {
            return true;
        }

        return false;
    }

    public function getValidator() {
        return $this->validator;
    }

    public function getData() {
        return $this->data;
    }

    /**
     * Function to extract just the data needed by specific resource, nothing more
     */
    protected function extractData() {
        $this->data = array();

        if ($this->raw_data) {
            foreach ($this->raw_data as $field => $value) {
                if (in_array($field, $this->fields)) {
                    $this->data[$field] = $value;
                }
            }
        }
    }

}
