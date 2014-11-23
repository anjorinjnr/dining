<?php

namespace Neartutor\Services;

use Neartutor\Validators\NotificationValidator;

/**
 * The notification service class
 *
 *
 * @author eanjorin
 */
class NotificationService {

  use \Neartutor\Traits\ErrorTrait;

  /**
   * 
   * @param array $data
   * @param Neartutor\Services\NotificationType $notificationType
   */
  public function sendEmail(array $data, $notificationType) {
	switch ($notificationType) {
	  case NotificationType::SignUpConfirmation:
		$this->sendActivationEmail($data);
	}
  }

  /**
   * Sends welcome email post signup with activation details.
   * Expects array with the following values:
   *  email
   *  fullname
   *  firstname
   *  confirmlink
   * @param array $data
   */
  private function sendActivationEmail($data) {
	$template_name = 'signup-confirmation';
	$template_content = array();
	$message = array(
		'subject' => 'Welcome! Please confirm your email address.',
		'from_email' => 'info@neartutors.com',
		'from_name' => 'NearTutors',
		'to' => array(
			array(
				'email' => $data['email'],
				'name' => $data['fullname']
			)
		),
		'merge_language' => 'mailchimp',
		'merge_vars' => array(
			array(
				'rcpt' => $data['email'],
				'vars' => array(
					[ 'name' => 'email', 'content' => $data['email']],
					[ 'name' => 'firstname', 'content' => $data['firstname']],
					[ 'name' => 'confirmlink', 'content' => $data['confirmlink']]
				)
			)
		)
	);
	\Email::messages()->sendTemplate($template_name, $template_content, $message);
	//print_r($result);
  }

}
