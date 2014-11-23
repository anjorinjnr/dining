<?php

namespace Chefme\Repository;

use Chefme\Models\User;
use Sentry;

class UserRepository extends Repository {

  public function __construct() {
	
  }

  /**
   * 
   * @param Array $data
   * @return \Chefmes\Data\DAO\UserDAO
   */
  public function create($data) {
	try {
	  // Create the user
	  $user = Sentry::createUser($data); 
	  $user->activated = 1;
	  $user->save();
	  return $user;
	} catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
	  $this->addError("User with email already exists");
	  return false;
	}
  }


  /**
   * Get user wilh student or tutor
   * 
   * @param int $id
   * @return  \Chefme\Models\User
   */
  public function get($id) {
	return User::find($id);
  }

  public function getByEmail($email) {
	return User::where('email', $email)->first();
  }

  /**
   * activate user profile
   * 
   * @param int $userId
   * @param string $activationCode   

   * @return  boolean
   */
  public function activate($userId, $activationCode) {
	try {
	  $user = Sentry::findUserById($userId);
	 
	  //var_dump($user);
	  // Attempt to activate the user
	  if (!$user->attemptActivation($activationCode)) {
		$this->addError("Invalid activation code");
	  }
	  return true;
	} catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
	  $this->addError('Invalid activation link');
	} catch (\Cartalyst\Sentry\Users\UserAlreadyActivatedException $e) {
	  $this->addError('This account is already activated.');
	}
  }

  /**
   * update user password
   * 
   * @param array $data
   * @param int $id
   * @param string $old_password   
   * @param string $password   	

   * @return  boolean
   */
  public function updatePassword($id, $old_password, $password) {
	try {
	  // Find the user using the user id
	  $user = $this->sentry->findUserById($id);

	  if ($user->checkPassword($old_password)) {
		$user->password = $password;
		$user->save();
	  } else {
		$this->addError("Old password is incorrect");
		return false;
	  }
	} catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
	  $this->addError("User was not found");
	  return false;
	}
  }

  public function delete($id) {
	
  }

  public function all($fields) {
	return User::where('activated', 1)->get($fields);
  }

  /**
   * update user
   * 
   * @param array $data
   * @param int $id 

   * @return  true
   */
  public function update($data, $id) {
	try {
	  $user = User::find($id);
	 if ($user) {
		$user->update([
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'bio' => $data['bio'],
			'gender' => $data['gender'],
			'phone_number' => $data['phone_number'],
			'birth_date' => $data['birth_date'],
			'zip' => $data['zip'],
			'address' => $data['address']
			  ] );
	  }
	  return true;
	} catch (\Exception $e) {
	  //echo $e;
	  //var_dump($e);
	  return false;
	}
  }

}
