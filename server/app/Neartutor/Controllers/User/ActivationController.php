<?php
namespace Neartutor\Controllers\User;

use \Neartutor\Controllers\BaseController;

/**
 * Description of ActivationController
 *
 * @author adekunleadedayo
 */
class ActivationController extends BaseController {

    private $userRepository;
    private $notificationService;

    public function __construct(UserRepository $userRepository, \Neartutor\Services\NotificationService $notificationService) {
        $this->userRepository = $userRepository;
        $this->notificationService = $notificationService;
    }
    
    public function sendactivationmail($userId) {

        $user = $this->userRepository->get($userId);
        if ($user && $this->notificationService->sendEmail($user->getEmail(), $user->getFullName(), "Activation email}", "emails.activation")) {
            return $this->json(array("status" => "success", "message" => "Activation email sent"));
        } else {
            return $this->json(array("status" => "error", "error" => "Error occured while sending email"));
        }
    }

    public function activate($activationCode, $encryptedUserId) {
        $userId = base64_decode($encryptedUserId);
        $this->userRepository->activate($userId, $activationCode);
        if ($this->userRepository->errors()) {
            return $this->json(array("status" => "error", "error" => $this->userRepository->errors()));
        }
        return $this->json(array("status" => "success", "message" => "User activation successful"));
    }

}
