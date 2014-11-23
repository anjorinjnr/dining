<?php

namespace Neartutor\Services;

use Neartutor\Repository\UserRepository;
use Neartutor\Services\NotificationService;
use Neartutor\Services\NotificationType;
use Neartutor\Services\Uploader;
use Neartutor\Validators\SignupValidator;
use Neartutor\Repository\TutorRepository;
use Neartutor\Models\User;
use Neartutor\Models\Tutor;

/**
 * Description of UserService
 * 
 * @author Ebenezer Anjorin <ebby@neartutors.com>
 */
class UserService {

  use \Neartutor\Traits\ErrorTrait;

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

  /**
   *
   * @var TutorRepository
   */
  private $tutorRepository;

  public function __construct(UserRepository $userRepository, NotificationService $notificationService, Uploader $uploader, TutorRepository $tutorRepository) {
	$this->notificationService = $notificationService;
	$this->userRepository = $userRepository;
	$this->uploader = $uploader;
	$this->tutorRepository = $tutorRepository;
  }

  public function create($input) {
	$signupValidator = new SignupValidator($input);

	if (!$signupValidator->passes()) {
	  $this->setError($signupValidator->getValidator()->messages()->all());
	  return false;
	}
	$data = $signupValidator->getData();
	$user = $this->userRepository->create(array("email" => $data['email'],
		"password" => $data['password'],
		"first_name" => $data['firstname'],
		"last_name" => $data['lastname'],
		"state_id" => $data['state_id'],
		"town_id" => $data['town_id'],
		"area_id" => $data['area_id'],
		"user_type" => $data['user_type']
		  //"phone_number" => $data['phone_number']
	));

	if ($this->userRepository->errors()) {
	  $this->setError($this->userRepository->errors());
	  return false;
	}

	$this->sendActivationEmail($user);
	return $user;
  }

  /**
   * Update user data
   * @param Array $input
   * @param int $id
   * @return boolean
   */
  public function update($input, $id) {
	if (isset($input['tutor'])) {
	  if (!$this->updateTutor($input, $id)) {
		return false;
	  }
	  unset($input['tutor']);
	}
	if (isset($input['subjects'])) {
	  if (!$this->updateTutorSubject($input, $id)) {
		return false;
	  }
	  unset($input['subjects']);
	}
	if (!$this->updateUser($input, $id)) {
	  return false;
	}
	return true;
  }

  /**
   * 
   * @param type $input
   * @param type $id
   * @return boolean
   */
  private function updateTutor($input, $id) {

	try {
	  $data = $input['tutor'];  //$validator->getData();

	  if ($data) {
		$this->tutorRepository->update($data, $id);
		return true;
	  }
	} catch (Exception $e) {
	  return false;
	}
  }

  private function validateUserId($id) {
	return User::findOrFail($id);
  }

  private function updateUser($input, $id) {
	$this->validateUserId($id);
	$validator = new \Neartutor\Validators\UserValidator($input);
	if (!$validator->passes()) {
	  $this->setError($validator->getValidator()->messages()->all());
	  return false;
	}
	$data = $validator->getData();
	if (isset($data['profile_picture'])) {
	  if ($this->uploadImage($data['profile_picture'], $id)) {
		$data['photo_path'] = $this->uploader->getFileName();
	  } else {
		$this->addError("File upload error occured");
		return false;
	  }
	}
	unset($data['profile_picture']);
	if ($data) {
	  if (!$this->userRepository->update($data, $id)) {
		$this->addError("invalid records");
		return false;
	  }
	}
	return true;
  }

  public function updatePicture($file, $user) {

	if (isset($file) && $this->uploadImage($file, $user->id)) {
	  $user->photo_path = $this->uploader->getFileName();
	  $user->save();
	} else {
	  $this->addError("File upload was not successful");
	  return false;
	}
	return true;
  }

  /**
   * Add/Remove subjects for a student.
   * If a subject isn't currently in the tutor's list add it.
   * If a subject is on the tutor's list, not missing in the subject's array,
   * remove it.
   * @param Tutor $tutor
   * @param type $subjects
   */
  public function updateTutorSubject($tutor, $subjects) {


	if ($tutor instanceof Tutor && is_array($subjects)) {
	  try {
		$tutor_subjects = $tutor->subjects()->select('subject_id')->get()->toArray();
		$subj_remove = [];
		$subj_add = [];
		$tutor_subjects = array_flatten($tutor_subjects);
		foreach ($tutor_subjects as $subject) {
		  if (!in_array($subject, $subjects)) {
			array_push($subj_remove, $subject);
		  }
		}
		foreach ($subjects as $subject) {
		  if (!in_array($subject, $tutor_subjects)) {
			array_push($subj_add, $subject);
		  }
		}
		if (!empty($subj_add)) {
		  $tutor->subjects()->attach($subj_add);
		}
		if (!empty($subj_remove)) {
		  $tutor->subjects()->detach($subj_remove);
		}
		return true;
	  } catch (Exception $ex) {
		//log
		return false;
	  }
	} else {
	  return false;
	}
  }

  public function removeTutorSubject($input, $id) {
	$data = $input['subjects'];
	if ($data) {
	  foreach ($data as $value) {
		$this->tutorRepository->deleteSubject($id, $value);
	  }
	}
	return true;
  }

  /**
   * @param Tutor $tutor
   * @return boolean
   */
  public function updateAgreeToTerms($tutor) {
	if ($tutor instanceof Tutor) {
	  $tutor->terms_agreed = 1;
	  $tutor->save();
	} else {
	  $this->tutorRepository->update(array("terms_agreed" => 1), $tutor);
	}
	return true;
  }

  public function updateSubjectRate($input, $tutor_id, $subject_id) {
	$rate = $input['rate'];
	if ($rate) {
	  $this->tutorRepository->updateSubject(array("tutor_id" => $tutor_id, "subject_id" => $subject_id, "rate" => $rate), $tutor_id, $subject_id);
	}
	return true;
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
		'confirmlink' => "http://neartutors.com/user/activate/{$enc_user_id}/{$activation_code}"
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
