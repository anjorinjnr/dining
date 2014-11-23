<?php

namespace Neartutor\Controllers;

use Neartutor\Repository\StudentRepository;

class StudentController extends BaseController {

    /**
     *
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * 
     * @param \Neartutor\Repository\StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository) {
        $this->studentRepository = $studentRepository;
    }


    /**
     * 
     * @param int $id
     * @return String
     */
    public function get($id) {
        $student = $this->studentRepository->get($id);
        if ($student) {
            return $this->json(array("status" => "success", "student" => $student->toArray()));
        } else {
            return $this->json(array("status" => "error", "message" => "No student with ID {$id}"));
        }
    }

}
