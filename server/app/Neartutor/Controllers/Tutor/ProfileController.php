<?php

/**
 * Description of ProfileController
 *
 * @author kayfun
 */
class ProfileController extends \Neartutor\Controllers\BaseController {

    protected $studentService;
    protected $userRepository;

    public function __construct(StudentService $studentService, Neartutor\Repository\UserRepository $userRepository) {
        $this->studentService = $studentService;
        $this->userRepository = $userRepository;
    }

    public function message() {
        $data = $validator->getData();
        $tutor_id = $data['tutor'];
        $message = $data['message'];
        //create new account
        if ($data['newaccount']) {
            $student = $this->createNewAccount();
            //student wasn't created, 	
            if (!$student) {
                return $this->json(array(
                    'status' => 'error',
                    'error' => $this->studentService->errors()
                ));
            }
        } else {
            $student = $this->userRepository->get($data['student_id']);
            if (!$student) {
                return $this->json(array(
                    'status' => 'error',
                    'error' => 'student with ID not found'
                ));
            }
        }

        $user = $this->userRepository->get($student->id);
        $tutor = $this->userRepository->get($tutor_id);
        if ($this->notificationService->sendEmail($tutor->email, sprintf("New Tutoring Inquiry from %s", $user->getFullName()), $message)) {
            $response = array('status' => 'success', 'message' => 'Message sendt successfully');
            if ($data['new_accout']) {
                $response['email'] = $data['email'];
                $response['password'] = $user->password;
            }
            return $this->json($response);
        } else {
            return $this->json(array(
                'status' => 'error',
                'errors' => array("Your message couldn't be sent at this time. Please try again")
            ));
        }
    }

    private function createNewAccount($data) {
        $tmp_password = \Helpers::generateTempPassword(8);
        $student_data = array(
            'first_name' => $data['firstname'],
            'last_name' => $data['lastname'],
            'email' => $data['email'],
            'phone_number' => $data['phone'],
            'state' => $data['state'],
            'town' => $data['town'],
            'area' => $data['area'],
            'source' => $data['source'],
            'password' => $tmp_password,
            'confirm_password' => $tmp_password
        );
        return $this->studentService->create($student_data);
    }

}
