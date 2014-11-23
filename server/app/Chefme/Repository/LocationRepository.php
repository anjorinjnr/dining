<?php

/**
 * Description of LocationRepository
 *
 * @author eanjorin
 */

namespace Chefme\Repository;

use Chefme\Models\State;

class LocationRepository extends Repository {

  public function create($data) {
	
  }

  public function delete($id) {
	
  }

  public function get($id) {
	
  }

  public function update($data) {
	
  }

  public function states() {
	return State::get();
  }

//put your code here
}
