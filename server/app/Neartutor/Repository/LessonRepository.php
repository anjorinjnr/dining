<?php

namespace Neartutor\Repository;

use Neartutor\Models\Lesson;

class LessonRepository extends Repository {

    public function create($data) {
        $lesson = Lesson::create($data);
        return $lesson;
    }

    public function get($id) {
        $lesson = Lesson::where('id', $id)->first();
        return $lesson;
    }

    public function delete($id) {
        $lesson = Lesson::find($id);
        $lesson->delete();
    }

    public function update($data, $id) {
        
    }

}
