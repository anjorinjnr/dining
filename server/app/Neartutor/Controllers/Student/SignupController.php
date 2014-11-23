<?php

namespace Neartutor\Controllers\Student;

use Neartutor\Services\StudentSignupService;

class SignupController extends BaseController {

    /**
     *
     * @var StudentSignupService
     */
    private $studentSignupService;

    /**
     * 
     * @param \Neartutor\Services\StudentSignupService $studentSignupService
     */
    public function __construct(StudentSignupService $studentSignupService) {
        $this->studentSignupService = $studentSignupService;
    }

    /**
     * 
     * @return String
     */
    public function create() {
        $student = $this->studentSignupService->create(\Input::all());
        if ($student) {
            return $this->json(array("status" => "success", "student" => $student));
        }

        return $this->json(array("status" => "error", "errors" => $this->studentSignupService->errors()));
    }


}
