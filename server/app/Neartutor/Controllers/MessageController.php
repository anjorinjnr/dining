<?php

namespace Neartutor\Controllers;

use Neartutor\Services\MessageService;
use Faker;
use \Input;

class MessageController extends BaseController {

  /**
   *
   * @var MessageService
   */
  private $messageService;

  /**
   * 
   * @param  Neartutor\Services\MessageService
   */
  public function __construct(MessageService $messageService) {
	//$this->messageRepository = $messageRepository;
	$this->messageService = $messageService;
  }

  /**
   * Create message

   * @param  int $id User Id 
   * @return String
   */
  public function createMessage($id) {

	$data = Input::all();
	$this->messageService->createMessages($data, $id);
	if ($this->messageService->errors()) {
	  return $this->json(array("status" => "error",
				"errors" => $this->messageService->errors()));
	}
	return $this->successResponse();
  }

  /**
   * Delete message.

   * @param int $id  user_id
   * @param string $mail_type 
   */
  public function deleteMessages($id, $mail_type) {
	$message_ids = Input::all();
	if (is_array($message_ids) && !empty($message_ids)) {
	  if (!$this->messageService->deleteMessages($id, $mail_type, $message_ids)) {
		return $this->json(array("status" => "error", "errors" => $this->messageService->errors()));
	  }
	  return $this->successResponse();
	} else {
	  return ["status" => "error", "errors" => ["Missing ids."]];
	}
	//print_r(\DB::getQueryLog());
  }

  /**
   * Return user's messages
   * @param int $id
   * @return String $filter
   */
  public function getMessages($id, $filter = 'Inbox') {
	//$faker = Faker\Factory::create();
	//return $faker->name;
	$messages = $this->messageService->getMessages($id, $filter);
	//print_r(\DB::getQueryLog());
	return $messages->toJson();
	//return $this->json(array("status" => "success", "messages" => $messages->toJson()));
  }
  
  public function search($id, $filter = 'INBOX') {
	$results = $this->messageService->search($id, $filter, Input::get('query'));
	//print_r(\DB::getQueryLog());
	return $results;
  }

}
