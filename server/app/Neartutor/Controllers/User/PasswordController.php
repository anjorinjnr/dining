<?php

namespace Neartutor\Controllers\User;

use \Neartutor\Controllers\BaseController;
use Neartutor\Validators\PasswordValidator;
use Neartutor\Validators\ResetPasswordValidator;
use Neartutor\Repository\UserRepository;

/**
 * Description of PasswordController
 *
 * @author adekunleadedayo
 */
class PasswordController extends BaseController {

    private $userRepository;
    private $notificationService;

    public function __construct(UserRepository $userRepository, \Neartutor\Services\NotificationService $notificationService) {
        $this->userRepository = $userRepository;
        $this->notificationService = $notificationService;
    }

    /**
     * 
     * @return type
     * @todo Test removal of password confirmation 
     */
    public function changePassword() {
        $validator = new PasswordValidator(\Input::all());
        if ($validator->passes()) {
            $data = $validator->getData();

            $this->userRepository->updatePassword($data['id'], $data['old_password'], $data['password']);
            if ($this->userRepository->errors()) {
                return $this->json(array('status' => 'error',
                            'errors' => $this->userRepository->errors()));
            }
            return $this->json(array("status" => "success", "message" => "Password changed successfully"));
        }
        return $this->json(array('status' => 'error',
                    'errors' => $validator->getValidator()->messages()->all()));
    }

    /**
     * This is the first step of the reset password process where an email 
     * is sent to the supplied email address if it exists in the system
     * 
     * @return type
     */
    public function sendResetPasswordInstruction() {
        $data = \Input::all();
        /**
         * @todo Validate Email
         */
        if (!isset($data['email']) || !$data['email']) {
            return $this->json(array('status' => 'error',
                        'errors' => array('No email address supplied')));
        }

        try {

            // Find the user using the user email address
            $user = \Sentry::findUserByLogin($data['email']);

            // Get the password reset code
            $resetCode = $user->getResetPasswordCode();

            // Send password reset email to the user
            $this->notificationService->sendEmail($data['email'], $user->getEmail(), 'Reset Your Password', 'email.resetpassword', compact('user', 'resetCode'));

            return $this->json(array("status" => "success", "message" => "Password reset instruction sent"));
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return $this->json(array('status' => 'error',
                        'errors' => array('User was not found')));
        }
    }

    /**
     * This is the second and final step of the password reset process 
     */
    public function completeResetPassword() {
        $validator = new ResetPasswordValidator(\Input::all());
        if (!$validator->passes()) {
            return $this->json(array('status' => 'error',
                        'errors' => $validator->getValidator()->messages()->all()));
        }
        $data = $validator->getData();
        try {
            // Find the user using the user id
            $user = Sentry::findUserById($data['id']);

            // Check if the reset password code is valid
            if ($user->checkResetPasswordCode($data['reset_code'])) {
                // Attempt to reset the user password
                if ($user->attemptResetPassword($data['reset_code'], $data['new_password'])) {
                    return $this->json(array("status" => "success", "message" => "Password reset successful"));
                } else {
                    return $this->json(array('status' => 'error',
                                'errors' => array('Password reset failed')));
                }
            } else {
                return $this->json(array('status' => 'error',
                            'errors' => array('The provided password reset code is Invalid')));
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return $this->json(array('status' => 'error',
                        'errors' => array('User not found')));
        }
    }

}
