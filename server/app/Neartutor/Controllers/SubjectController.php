<?php

namespace Neartutor\Controllers;

use Neartutor\Repository\SubjectRepository;
use Neartutor\Validators\SubjectValidator;

class SubjectController extends BaseController {

    private $subjectRepository;

    public function __construct(SubjectRepository $subjectRepository) {
        $this->subjectRepository = $subjectRepository;
    }

    public function all($filter = "") {
        $subjects = $this->subjectRepository->all($filter);
        return $this->json($subjects->toArray());
    }

    public function get($id) {
        $subject = $this->subjectRepository->get($id);
        if ($subject) {
            return $this->json(array("status" => "success", "subject" => $subject->toArray()));
        } else {
            return $this->json(array("status" => "error", "errors" => array("No subject with ID {$id}")));
        }
    }

    public function getSubjectByName() {
        $subject_name = \Input::get('subject');
        $subject = $this->subjectRepository->getSubjectByName($subject_name);
        if ($subject) {
            return $this->json(array("status" => "success", "subject" => $subject->toArray()));
        } else {
            return $this->json(array("status" => "error", "errors" => array("No subject with name {$subject_name}")));
        }
    }

    public function create() {
        $input = \Input::all();
        $validator = new SubjectValidator($input);

        if (!$validator->passes()) {
            return $this->json(array('status' => 'error',
                        'errors' => $validator->getValidator()->messages()->all()));
        }
        $data = $validator->getData();

        $subject = $this->subjectRepository->getSubjectByName($data['title'], true);
        if ($subject) {
            return $this->json(array('status' => 'error',
                        'errors' => array('Subject title exists')));
        }
        $addedSubject = $this->subjectRepository->create($data);
        return $this->json(array("status" => "success", "subject" => $addedSubject->toArray()));
    }

    public function delete($id) {
        if ($this->subjectRepository->delete($id)) {
            return json_encode(array("status" => "success", "id" => $id));
        } else {
            return $this->errorResponse();
        }
    }

}
