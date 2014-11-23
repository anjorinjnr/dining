<?php

namespace Neartutor\Controllers;

use Neartutor\Repository\RatingRepository;

class RatingController extends BaseController {

    protected $ratingRepository;

    public function __construct(RatingRepository $ratingRepository) {
        $this->ratingRepository = $ratingRepository;
    }

    public function count($tutor_id) {
        $count = $this->ratingRepository->count($tutor_id);
        return $this->json(array('status' => 'success', 'count' => $count));
    }

    public function average($tutor_id) {
        $average = $this->ratingRepository->getAverageRating($tutor_id);
        return $this->json(array('status' => 'success', 'average' => $average));
    }

    public function star_count($tutor_id, $star) {
        $star_count = $this->ratingRepository->getStarCount($tutor_id, $star);
        $percentage_count = $this->ratingRepository->getPercentageCount($tutor_id, $star);

        $data = array(
            "count" => $star_count,
            "percentage" => $percentage_count
        );
        return $this->json(array('status' => 'success', 'info' => $data));
    }

}
