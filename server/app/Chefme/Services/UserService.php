<?php

namespace Chefme\Services;

use Chefme\Repository\UserRepository;
use Chefme\Services\NotificationService;
use Chefme\Services\NotificationType;
use Chefme\Services\Uploader;
use Chefme\Validators\SignupValidator;
use Chefme\Models\User;

/**
 * Description of UserService
 * 
 * @author Ebenezer Anjorin <ebby@Chefmes.com>
 */
class UserService {

  use \Chefme\Traits\ErrorTrait;

  /**
   *
   * @var UserRepository
   */
  private $userRepository;

  /**
   *
   * @var NotificationService
   */
  private $notificationService;

  /**
   *
   * @var Uploader
   */
  private $uploader;

  public function __construct(UserRepository $userRepository, NotificationService $notificationService, Uploader $uploader) {
	$this->notificationService = $notificationService;
	$this->userRepository = $userRepository;
	$this->uploader = $uploader;
  }

  public function create($input) {
	$signupValidator = new SignupValidator($input);

	if (!$signupValidator->passes()) {
	  $this->setError($signupValidator->getValidator()->messages()->all());
	  return false;
	}
	$data = $signupValidator->getData();
	$user = $this->userRepository->create(
		  array("email" => $data['email'],
			  "password" => $data['password'],
			  "first_name" => $data['firstname'],
			  "last_name" => $data['lastname']));

	if ($this->userRepository->errors()) {
	  $this->setError($this->userRepository->errors());
	  return false;
	}

	//$this->sendActivationEmail($user);
	return $user;
  }

  /**
   * Update user data
   * @param Array $input
   * @param int $id
   * @return boolean
   */
  public function update($input, $id) {
	if (!$this->updateUser($input, $id)) {
	  return false;
	}
	return true;
  }

  private function validateUserId($id) {
	return User::findOrFail($id);
  }

  private function updateUser($data, $id) {
	if ($data) {
	  if (!$this->userRepository->update($data, $id)) {
		$this->addError("Update was not successful.");
		return false;
	  }
	}
	return true;
  }

  public function updatePicture($file, $user) {

	if (isset($file) && $this->uploadImage($file, $user->id)) {
	  $user->photo_path = $this->uploader->getFileName();
	  $user->save();
	  return $user->photo_path ;
	} else {
	  $this->addError("File upload was not successful");
	  return false;
	}
  }

  /**
   * Upload image for the specified user id.
   * @param File $image
   * @param int $id
   * @return string|boolean
   */
  private function uploadImage($image, $id) {
	$extension = $image->getClientOriginalExtension();
	$filename = md5($id . $image->getClientOriginalName()) . ".$extension";

	$this->uploader->setFileName($filename)
		  ->setDestinationPath('/uploads/pp/')
		  ->isImage();

	if (!$this->uploader->upload($image)) {
	  $this->addError("File upload error occured");
	  return false;
	}

	return $filename;
  }

  /**
   * Send post sign-up activation email
   * @param type $user
   * @return type
   * @todo make base url for activation link an env variable or some injectable
   */
  public function sendActivationEmail($user) {

	$enc_user_id = base64_encode($user->id);
	$activation_code = $user->getActivationCode();
	$data = [
		'fullname' => $user->getFullName(),
		'firstname' => $user->first_name,
		'usertype' => $user->user_type,
		'email' => $user->email,
		'confirmlink' => "http://Chefmes.com/user/activate/{$enc_user_id}/{$activation_code}"
	];
	$this->notificationService->sendEmail($data, NotificationType::SignUpConfirmation);
  }

  public function activate($user_id, $code) {
	if (!is_int($user_id)) {
	  $user_id = base64_decode($user_id);
	}

	if ($this->userRepository->activate($user_id, $code)) {
	  return true;
	} else {
	  $this->setError($this->userRepository->errors());
	  return true;
	}
  }

}
