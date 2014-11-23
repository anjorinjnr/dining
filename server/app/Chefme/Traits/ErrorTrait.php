<?php

namespace Chefme\Traits;

/**
 * Description of ErrorTrait
 *
 * @author eanjorin
 */
trait ErrorTrait {

    protected $errors = array();

    public function errors() {
        return $this->errors;
    }

    //set the errors array
    public function setError($error) {
        if (is_array($this->errors)) {
            $this->errors = $error;
        }
    }

    //append or merge an error to the error array
    public function addError($error) {
        if (is_array($error)) {
            $this->errors = array_merge($this->errors, $error);
        } else {
            $this->errors[] = $error;
        }
    }

}
