<?php

namespace Neartutor\Services;

use \Neartutor\Repository\JobRepository;
use Neartutor\Validators\JobValidator;

/**
 * Description of JobService
 *
 * @author eanjorin
 */
class JobService {

  //put your code here
  use \Neartutor\Traits\ErrorTrait;

  private $jobRepository;

  public function __construct(JobRepository $jobRepository) {
	$this->jobRepository = $jobRepository;
  }
  
  public function getJobs($user_id) {
	return $this->jobRepository->getJobs($user_id);
  }

  public function createJob($data) {
	$validator = new JobValidator($data);
	if ($validator->passes()) {
	  $job = $this->jobRepository->create($data);
	  if ($job) {
		return $job;
	  } else {
		$this->setError($this->jobRepository->errors());
		return false;
	  }
	} else {
	  $this->setError($validator->getValidator()->messages()->all());
	}
  }
  public function deleteJobs($user_id, $job_ids) {
	if($this->jobRepository->deleteJobs($user_id, $job_ids)){
	  return true;
	} else {
	  $this->addError($this->jobRepository->errors());
	  return false;
	}
  }

}
