<?php

namespace Neartutor\Controllers;

use Neartutor\Repository\TutorRepository;
use Neartutor\Services\UserService;
use \Input;

class TutorController extends BaseController {

  /**
   *
   * @var TutorRepository
   */
  private $tutorRepository;
  private $userService;

  /**
   * 
   * @param \Neartutor\Repository\TutorRepository $tutorRepository
   */
  public function __construct(TutorRepository $tutorRepository, UserService $userService) {
	$this->tutorRepository = $tutorRepository;
	$this->userService = $userService;
  }

  /**
   * Update tutor's data
   * API: Post /tutor/{id}/update/profile
   * Params: Json object
   * @param int $id tutor id
   * @return json
   */
  public function update($id) {
	$data = Input::all();

	if (!$this->userService->update($data, $id)) {
	  return $this->json(array("status" => "error", "errors" => $this->userService->errors()));
	}

	return $this->successResponse();
  }

  /**
   * Add or remove subjects for a tutor
   * API: Post /tutor/{id}/subjects
   * Params: Array of subject ids
   * @param Tutor $tutor
   * @return json
   */
  public function updateSubject($tutor) {
	$subjects = Input::all();
	if (!$this->userService->updateTutorSubject($tutor, $subjects)) {
	  return $this->json(array("status" => "error", "errors" => $this->userService->errors()));
	}

	return $this->successResponse();
  }

  public function removeSubject($id) {
	$data = \Input::all();

	if (!$this->userService->removeTutorSubject($data, $id)) {
	  return $this->json(array("status" => "error", "errors" => $this->userService->errors()));
	}

	return $this->successResponse();
  }

  /**
   * Agree to terms
   * API: Post /tutor/{id}/agreetoterms
   * Params: None 
   * @param Tutor $tutor
   * @return json
   */
  public function updateAgreeToTerms($tutor) {

	if (!$this->userService->updateAgreeToTerms($tutor)) {
	  return $this->json(array("status" => "error", "errors" => $this->userService->errors()));
	}

	return $this->successResponse();
  }

  public function updateSubjectRate($tutorId, $subjectId) {
	$data = \Input::all();
	if (!$this->userService->updateSubjectRate($data, $tutorId, $subjectId)) {
	  return $this->json(array("status" => "error", "errors" => $this->userService->errors()));
	}
	return $this->successResponse();
  }

  /**
   * 
   * @param int $id
   * @return String
   */
  public function get($id) {
	$tutor = $this->tutorRepository->get($id);
	if ($tutor) {

	  return $this->json(array("status" => "success", "user" => $tutor->toArray()));
	} else {
	  return $this->json(array("status" => "error", "errors" => array("No tutor with ID {$id}")));
	}
  }

}
