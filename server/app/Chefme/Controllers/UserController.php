<?php

namespace Chefme\Controllers;

use Chefme\Repository\UserRepository;
use Chefme\Services\UserService;
use \Input;

class UserController extends BaseController {

  /**
   *
   * @var UserRepository
   */
  private $userRepository;

  /**
   *
   * @var UserService
   */
  private $userService;

  public function __construct(UserService $userService, UserRepository $userRepository) {
	$this->userService = $userService;
	$this->userRepository = $userRepository;
  }

  public function sendActivationMail($user) {
	$this->userService->sendActivationEmail($user);
	return $this->json(
				[
					'status' => 'success',
					'message' => 'Activation email sent'
				]
	);
  }

  /**
   * user signup for tutor/student records.
   *
   *
   * @return Json Response
   */
  public function signup() {

	$data = \Input::all();
	$user = $this->userService->create($data);

	if ($this->userService->errors()) {
	  return $this->json(array("status" => "error", "errors" => $this->userService->errors()));
	}

	return $this->json(array("status" => "success", "user" => $user->toJson()));
  }

  /**
   * Update User records.
   *
   * @param int $id is user_id
   *
   * @return Json Response
   */
  public function update($id) {
	$data = \Input::all();

	if (!$this->userService->update($data, $id)) {
	  return $this->json(array("status" => "error", "errors" => $this->userService->errors()));
	}

	return $this->successResponse();
  }

  public function uploadPicture($user) {
	if (Input::file('file')->isValid()) {
	  $path = $this->userService->updatePicture(Input::file('file'), $user);
	  if ($path) {
		return ['status' => 'success', 'paths' => [$path]];
	  } else {
		return $this->json(array("status" => "error", "errors" => $this->userService->errors()));
	  }
	} else {
	  return $this->json(["status" => "error", "errors" => ['Expects field of type file named file']]);
	}
	return $this->successResponse();
  }

  /**
   *
   * @param int $id
   * @return String
   */
  public function get($id) {
	$user = $this->userRepository->get($id);
	if ($user) {
	  return $this->json(array("status" => "success", "user" => $user->toArray()));
	} else {
	  return $this->json(array("status" => "error", "message" => "No User with ID {$id}"));
	}
  }

  public function getByEmail() {
	$email = \Input::get('email');
	$user = $this->userRepository->getByEmail($email);
	if ($user) {
	  return $this->json(array("status" => "success", "user" => $user));
	} else {
	  return $this->json(array("status" => "error", "message" => "No user with email {$email}"));
	}
  }

  public function activate() {
	$input = Input::all();
	if ($this->userService->activate($input['id'], $input['code'])) {
	  return ["status" => "success"];
	} else {
	  return ["status" => "error", "errors" => $this->userService->errors()];
	}
  }

  public function index() {
	$fields = array_map(
		  function ($item) {
	  return trim($item);
	}, explode(',', \Input::get('fields'))
	);
	return $this->userRepository->all($fields);
  }

}
