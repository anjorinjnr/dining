<?php

namespace Chefme\Repository;

/**
 * Description of Repository
 *
 * @author Adekunle Adedayo
 */
abstract class Repository {

    use \Chefme\Traits\ErrorTrait;

    abstract public function create($data);

    abstract public function get($id);

    abstract public function delete($id);
}
