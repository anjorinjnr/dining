<?php

namespace Neartutor\Repository;

use Neartutor\Models\Rating;

class RatingRepository {

    public function count($tutor_id) {
        return Rating::where('tutor', $tutor_id)->count();
    }

    public function getStarCount($tutor_id, $star) {
        $count = Rating::where('tutor', $tutor_id)->where('rate', $star)->count();
        return $count;
    }

    public function getPercentageCount($tutor_id, $star) {
        $count = $this->getStarCount($tutor_id, $star);
        $total_count = 0;
        if (is_numeric($count) && $count) {
            $total_count = $this->count($tutor_id);
            return round(($count / $total_count ) * 100);
        }

        return 0;
    }

    public function getAverageRating($tutor_id) {
        return floor(Rating::where('tutor', $tutor_id)->avg('rate'));
    }

}
