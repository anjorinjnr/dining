<?php

namespace Neartutor\Traits;

use Neartutor\Models\User;
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
