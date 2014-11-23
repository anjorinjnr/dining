<?php

namespace Neartutor\Repository;

/**
 * Description of Repository
 *
 * @author Adekunle Adedayo
 */
abstract class Repository {

    use \Neartutor\Traits\ErrorTrait;

    abstract public function create($data);

    abstract public function get($id);

    abstract public function delete($id);
}
