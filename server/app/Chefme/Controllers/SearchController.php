<?php

namespace Chefme\Controllers;

use \Input;

class SearchController extends BaseController {

  const SORT_LOWEST_PRICE = 1;
  const SORT_HIGHEST_PRICE = 2;
  const SORT_RATING = 3;
  const SORT_BEST_MATCH = 4;

  use \Chefme\Traits\Location;

  protected $tutorRepository;

  public function __construct(\Chefme\Repository\TutorRepository $tutorRepository) {
	$this->tutorRepository = $tutorRepository;
  }

  /**
   * Returns the tutors that match the search criteria
   * Arguments:
   *  @subject, required, return tutors teaching this subject
   *  @state, optional, return tutors in this state
   *  @town, optional, return tutors in this town
   *  @area, optional, return tutors in this area
   *  @page, optional, return tutors in the page of the results
   *  @sort, optional, sort the results by this option
   */
  public function tutors() {

	if (Input::has("subject")) {
	  $subject = Input::get("subject");
	  $state = (int) Input::get("state", 0);
	  $town = (int) Input::get("town", 0);
	  $area = (int) Input::get("area", 0);
	  $sort = (int) Input::get("sort", 4);
	  switch ($sort) {
		case self::SORT_LOWEST_PRICE:
		  $tutors = $this->tutorRepository->getTutorsByLowestPrice($subject, $state, $town, $area);
		  break;
		case self::SORT_HIGHEST_PRICE:
		  $tutors = $this->tutorRepository->getTutorsByHighestPrice($subject, $state, $town, $area);
		  break;
		case self::SORT_RATING:
		  $tutors = $this->tutorRepository->getTutorsByHighestRating($subject, $state, $town, $area);
		  break;
		case self::SORT_BEST_MATCH:
		  $tutors = $this->tutorRepository->getTutorsByBestMatch($subject, $state, $town, $area);
		  break;
		default:
		  $tutors = $this->tutorRepository->getTutorsByBestMatch($subject, $state, $town, $area);
	  }

	  if ($tutors) {
		return $this->json(array("status" => "success", "tutors" => $tutors->toArray()));
	  } else {
		return $this->json(array("status" => "success", "message" => "Your search returned no result"));
	  }
	} else {
	  return ["status" => "error", "errors" => ["subject id is required but missing"]];
	  
	}
  }

  /**
   * return list of towns for the input state
   * @return type

    public function towns() {
    $state_id = Input::get("stateid");
    $towns = getTowns($state_id);
    return $this->json(array("status" => "success", "towns" => $towns->toArray()));
    }

   */
  /**
   * return list of areas for the input town 
   * @return type

    public function areas() {
    $town_id = Input::get("townid");
    $areas = getAreas($town_id);
    return $this->json(array("status" => "success", "towns" => $areas->toArray()));
    }
   * */
}
