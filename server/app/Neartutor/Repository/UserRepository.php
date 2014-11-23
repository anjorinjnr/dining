<?php

namespace Neartutor\Repository;

use Neartutor\Models\User;
use Neartutor\Models\Tutor;
use Neartutor\Models\Student;
use Neartutor\Models\TutorSubject;
use Sentry;

class UserRepository extends Repository {

  public function __construct() {
	
  }

  /**
   * 
   * @param Array $data
   * @return \Neartutors\Data\DAO\UserDAO
   */
  public function create($data) {
	try {
	  // Create the user
	  $user = Sentry::createUser($data);
	  switch ($user->user_type) {
		case 0:
		  $this->createStudent(array("id" => $user->id));
		  break;
		case 1:
		  $this->createTutor(array("id" => $user->id));
	  }
	  return $this->get($user->id);
	} catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
	  $this->addError("User with email already exists");
	  return false;
	}
  }

  private function createTutor($data) {
	Tutor::create($data);
  }

  private function createStudent($data) {
	Student::create($data);
  }

  /**
   * Get user wilh student or tutor
   * 
   * @param int $id
   * @return  \Neartutor\Models\User
   */
  public function get($id) {
	return User::with('student')->with('tutor')->find($id);
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
		$user->update($data);
	  }
	  return true;
	} catch (Exception $e) {
	  return false;
	}
  }

}
