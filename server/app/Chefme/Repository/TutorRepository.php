<?php

namespace Chefme\Repository;

use Chefme\Models\Tutor;
use Chefme\Models\TutorSubject;
use \DB;

class TutorRepository extends Repository {

  const SEARCH_PAGE_SIZE = 1;
  use \Chefme\Traits\UserTrait;

  /**
   * 
   * @param Array $data
   * @return \Chefme\Models\Tutor
   */
  public function create($data) {
	$tutor = Tutor::create($data);
	return $tutor;
  }

  /**
   * 
   * @param int $id
   * @return  \Chefme\Models\Tutor
   */
  /*public function get($id) {
	
	$result = Tutor::with('user')->find($id);

	$subjects = $this->getSubjects($id);
	$subarr = array();
	foreach ($subjects as $value) {
	  $subarr[] = $value->subject_id;
	}
	$result['subjects'] = $subarr;

	return $result;
	//die();
	//return Tutor::with('user')->find($id);
  }*/

  public function getSubjects($tutor_id) {

	$results = DB::select('select * from tutor_subjects where tutor_id = ' . $tutor_id);
	return $results;
  }

  /**
   * 
   * @param int $tutor_id
   * @param int[] $subjects
   */
  public function addSubject($tutor_id, $subjects) {
	$tutor =  Tutor::find($tutor_id);
	if($tutor){
	  $tutor->subjects()->attach($subjects);
	}
  }

  public function updateSubject($data, $tutor_id, $subject_id) {


	$results = DB::select('select * from tutor_subjects where tutor_id = ' . $tutor_id . ' and subject_id=' . $subject_id);

	if ($results) {

	  $tutorsubject = TutorSubject::find($results[0]->id);
	  $tutorsubject->update($data);
	  return $tutorsubject;
	} else {
	  return $this->addSubject($data);
	}
  }

  public function deleteSubject($tutor_id, $subject_id) {

	$results = DB::delete('delete from tutor_subjects where tutor_id = ' . $tutor_id . ' and subject_id=' . $subject_id);

	return true;
  }

  public function addStudent($data) {
	return TutorStudent::create($data);
  }

  public function getStudent($tutor_id, $student_id) {
	return TutorStudent::where("tutor_id = {$tutor_id}")->where("student_id
                    = {$student_id}");
  }

  public function getStudents($tutor_id) {
	return TutorStudent::with('user')->where("tutor_id = {$tutor_id}");
  }

  /**
   * 
   * see sql/search.sql for plain sql query
   * Returns list of tutors teaching the specified subject
   * ordered by the higest hours, then the lower rates
   * and matches state, town and area is provided
   * 
   * Plan to factor ratings into best match consideration
   */
  public function getTutorsByBestMatch($subject, $state, $town, $area) {

	$query = $this->queryTutors($subject, $state, $town, $area);
	if ($query) {
	  $tutors = $query->orderByRaw('hours desc, avg_rating desc')
			->paginate(TutorRepository::SEARCH_PAGE_SIZE);
	  return $tutors;
	}
	return null;
  }

  public function getTutorsByHighestRating($subject, $state, $town, $area) {

	$query = $this->queryTutors($subject, $state, $town, $area);
	if ($query) {
	  $tutors = $query->orderByRaw('avg_rating desc, feedback desc')
			->paginate(TutorRepository::SEARCH_PAGE_SIZE);
	  return $tutors;
	}
	return null;
  }

  public function getTutorsByHighestPrice($subject, $state, $town, $area) {

	$query = $this->queryTutors($subject, $state, $town, $area);
	if ($query) {
	  $tutors = $query->orderBy('rate', ' ASC')
			->paginate(TutorRepository::SEARCH_PAGE_SIZE);
	  return $tutors;
	}
	return null;
  }

  public function getTutorsByLowestPrice($subject, $state, $town, $area) {

	$query = $this->queryTutors($subject, $state, $town, $area);
	if ($query) {
	  $tutors = $query->orderBy('rate', 'ASC')->paginate(TutorRepository::SEARCH_PAGE_SIZE);
	  return $tutors;
	}
	return null;
  }

  /**
   * Performs a query for tutors.
   * Expects all arguments to be numeric to prevent sql injection
   * @param type $subject
   * @param type $state
   * @param type $town
   * @param type $area
   * @return null
   */
  private function queryTutors($subject, $state, $town, $area) {

	if (is_numeric($subject) && is_numeric($state) &&
		  is_numeric($town) && is_numeric($area)) {

	  $query = DB::table('users as u')
			->select(DB::raw("t.id, u.first_name, u.last_name,u.photo_path,
                                   t.profile_title, t.profile_summary,
                                 IF ((SELECT @tsrate := ts.rate 
                                      FROM tutor_subjects ts 
                                      WHERE ts.tutor_id = t.id
                                      AND ts.subject_id = {$subject} 
                                      ) IS null, CAST(t.rate AS decimal(8,2)), CAST(@tsrate AS decimal(8,2))) AS rate,
                                 COALESCE((SELECT SUM(hours)
										   FROM lessons
										   WHERE tutor_id = t.id
										   AND subject_id = {$subject}
									       ), 0) AS hours, 
                                 COALESCE((SELECT COUNT(id)
                                           FROM ratings
                                           WHERE tutor_id = t.id), 0) AS ratings,
								 COALESCE( CAST( (SELECT AVG(rate) 
										          FROM ratings 
										          WHERE tutor_id = t.id) as decimal(2,1)) , 0) AS avg_rating,
                                 COALESCE( (SELECT COUNT(id)
                                                   FROM feedbacks
                                                   WHERE tutor_id = t.id), 0) AS feedback,
                                 state_name AS state,
                                 town_name AS town,
                                 area_name AS area"))
			->join('tutors AS t', 'u.id', '=', 't.id')
			->leftJoin('states AS st', 'u.state_id', '=', 'st.id')
			->leftJoin('towns AS tw', 'u.town_id', '=', 'tw.id')
			->leftJoin('areas AS ar', 'u.area_id', '=', 'ar.id')
			->whereIn('t.id', function($subQuery) use($subject) {
		$subQuery->select('tutor_id')
		->from('tutor_subjects')
		->where('subject_id', '=', $subject);
	  });
	  if ($state > 0) {
		$query = $query->where('u.state_id', $state);
	  }
	  if ($town > 0) {
		$query = $query->where('u.town_id', $town);
	  }
	  if ($area > 0) {
		$query = $query->where('u.area_id', $area);
	  }

	  return $query;
	}
	return null;
  }

  public function delete($id) {
	
  }

  public function all() {
	
  }

  public function update($data, $id) {

	//$tutor = Tutor::where("id = {$id}");
	//$tutor->fillFromArray($data);
	$tutor = Tutor::find($id);
	if ($tutor) {
	  $tutor->update($data);
	}
  }

}
