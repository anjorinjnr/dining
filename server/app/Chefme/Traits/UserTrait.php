<?php

namespace Chefme\Traits;

use Chefme\Models\User;
/**
 * Description of UserTrait
 *
 * @author eanjorin
 */
trait UserTrait {

  //put your code here

  public function get($id) {
	return User::with('student')->with('tutor')->find($id);
  }

}
