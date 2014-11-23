<?php

namespace Chefme\Repository;

use Chefme\Models\Job;
use Chefme\Models\JobApplication;
use \DB;

class JobRepository extends Repository {

  /**
   * 
   * @param Array $data
   * @return \Chefme\Models\Job
   */
  public function get($id) {

	$job = Job::with(['subject' => function($query) {
		  $query->select('id', 'title');
		}])->find($id);
	return $job;
  }

  /**
   * get Student jobs
   * 
   * @param int $student_id
   * @return \Chefme\Models\Job
   */
  public function getStudentJob($student_id) {

	$job = Job::where('student_id', $student_id)->get();
	return $job;
  }

  /**
   * Create job
   * 
   * @param array $data
   * @return \Chefme\Models\Job
   */
  public function create($data) {
	try {
	  $job = Job::create($data);
	  return $this->get($job->id);
	} catch (\Exception $e) {
	  $this->addError("Unable to create job");
	  return false;
	}
  }

  /**
   * Delete job
   * 
   * @param int $job_id
   */
  public function deleteJobs($user_id, $job_ids) {

	$deleted = Job::whereIn('id', $job_ids)
		  ->where('student_id', $user_id)
		  ->delete();
	//print_r($deleted);
	if ($deleted > 0) {
	  return true;
	}
	$this->addError('Unable to delete jobs');
	return false;
  }

  /**
   * Return jobs (tutor requests) created by this user.
   * Include the subject title for which a tutor was requested.
   * Also, include all submitted applications including the name of the tutor,
   * the tutor's rate(use subject rate if present)
   * @param type $user_id
   * @return type
   */
  public function getJobs($user_id) {
	return Job::with(['subject' => function($query) {
				$query->select('id', 'title');
			  }, 'applications' => function($query) {
				$query->select(
							DB::raw("job_id, message, u.id as tutor_id, u.location, "
								  . "coalesce(ts.rate,t.rate) as rate, job_applications.created_at, "
								  . " concat(u.first_name, ' ', u.last_name) as tutor,"
								  . " coalesce(cast((select avg(rate) from ratings "
								  . "				  where tutor_id = u.id) as decimal(2,1)) , 0)"
								  . " AS avg_rating, "
								  . " coalesce((select count(id) from ratings"
								  . "			where tutor_id = t.id), 0) AS ratings"))
					  ->join('jobs as j', 'j.id', '=', 'job_applications.job_id')
					  ->join('tutors as t', 'job_applications.tutor_id', '=', 't.id')
					  ->join('users as u', 't.id', '=', 'u.id')
					  ->leftJoin('tutor_subjects as ts', function($join) {
							  $join->on('u.id', '=', 'ts.tutor_id')
							  ->on('j.subject_id', '=', 'ts.subject_id');
							});
			  }])->where('student_id', $user_id)->get();
  }

  /**
   * update job
   * 
   * @param array $data
   * @param int $student_id
   * @param int $job_id

   */
  public function update($data, $student_id, $job_id) {

	$job = Job::find($job_id);
	if ($job) {
	  $job->update($data);
	}
  }

  public function delete($id) {
	
  }

}
