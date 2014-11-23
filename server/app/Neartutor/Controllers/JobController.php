<?php

namespace Neartutor\Controllers;

use Neartutor\Services\JobService;
use \Input;

class JobController extends BaseController {
 
  /**
   *
   * @var UserService
   */
  private $jobService;

  /**
   * @param Neartutor\Services\JobService $jobService
   */
  public function __construct(JobService $jobService) {
	$this->jobService = $jobService;
  }

  /**
   * Create tutor requests
   * @return Json response
   */
  public function postJob() {

	$data = Input::all();
	//print_r($data);
	$job = $this->jobService->createJob($data);
	if ($this->jobService->errors()) {
	  return $this->json(array("status" => "error", "errors" => $this->jobService->errors()));
	}
	return ["status" => "success", "job" => $job];
  }

  /**
   * Update student job.

   * @param  int $id  //student_id
   * @param  int $id1 //job_id
   * @return String
   */
  public function updateStudentJob($id, $id1) {
	$data = \Input::all();

	if (!$this->userService->updateStudentJob($data, $id, $id1)) {
	  return $this->json(array("status" => "error", "errors" => $this->userService->errors()));
	}

	return $this->successResponse();
  }

  /**
   * Delete/remove student job.

   * @param  int $id  //student_id
   * @param  int $id1 //job_id
   * @return String
   */
  public function removeStudentJob($id, $id1) {


	if (!$this->userService->removeStudentJob($id, $id1)) {
	  return $this->json(array("status" => "error", "errors" => $this->userService->errors()));
	}

	return $this->successResponse();
  }

  
  public function query() {
	if (Input::has('user_id')) {
	  return $this->jobService->getJobs(Input::get('user_id'));  
	} else {
	    return ["status" => "error", "errors" => ["user_id query param is missing"]];
	}
	
  }
  /**
   * 
   * @param int $id
   * @return String
   */
 /* public function get($id) {
	$tutor = $this->jobRepository->get($id);
	if ($tutor) {
	  return $this->json(array("status" => "success", "tutor" => $tutor->toArray()));
	} else {
	  return $this->json(array("status" => "error", "errors" => array("No Job with ID {$id}")));
	}
  }*/

  public function deleteJob($user_id) {
	$job_ids = Input::all();
	if (is_array($job_ids) && !empty($job_ids)) {
	  if (!$this->jobService->deleteJobs($user_id, $job_ids)) {
		return ["status" => "error", "errors" => $this->jobService->errors()];
	  }
	  return $this->successResponse();
	} else {
	  return ["status" => "error", "errors" => ["Missing ids."]];
	}
	
  }
}
