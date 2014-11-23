<?php

namespace Neartutor\Controllers;

use Neartutor\Repository\LessonRepository;
use Neartutor\Validators\LessonValidator;

class LessonController extends BaseController {

    private $lessonRepository;

    public function __construct(LessonRepository $lessonRepository) {
        $this->lessonRepository = $lessonRepository;
    }

    public function get($id) {
        $lesson = $this->lessonRepository->get($id);
        if ($lesson) {
            return $this->json(array("status" => "success", "lesson" => $lesson->toArray()));
        } else {
            return $this->json(array("status" => "error", "message" => "No lesson with ID {$id}"));
        }
    }

    public function create() {

        $input = \Input::all();
        $validator = new LessonValidator($input);

        if (!$validator->passes()) {
            return $this->json(array('status' => 'error',
                        'error' => $validator->getValidator()->messages()->all()));
        }
        $data = $validator->getData();
        $timeDiff = strtotime($data['end_time']) - strtotime($data['start_time']);
        $data['hours'] = ceil($timeDiff / 3600);

        if ($data['hours'] < 1) {
            return $this->json(array('status' => 'error',
                        'error' => 'Invalid start or end date'));
        }

        $subject = $this->getSubject($data['tutor_id'], $data['subject_id']);
        if (!$subject) {
            return $this->json(array('status' => 'error',
                        'error' => 'Tutor not registered for selected subject'));
        }
        
        
        if(!$this->getTutorStudentRelationship($data['tutor_id'], $data['subject_id']))
        {
            return $this->json(array('status' => 'error',
                        'error' => 'Tutor not related to student'));
        }

        $data['rate'] = $subject->rate;
        
        /**
         * @todo Confirm how we will handle percentage earned
         */
        $data['percentage_earned'] = 100;
        $lesson = $this->lessonRepository->create($data);
        return $this->json(array("status" => "success", "lesson" => $lesson->toArray()));
    }

    public function delete($id) {
        if ($this->lessonRepository->delete($id)) {
            return json_encode(array("status" => "success", "id" => $id));
        } else {
            return $this->errorResponse();
        }
    }

}
