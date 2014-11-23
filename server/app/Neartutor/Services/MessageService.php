<?php

namespace Neartutor\Services;

use Neartutor\Repository\MessageRepository;
use Neartutor\Validators\MessageValidator;
use \DB;

/**
 * Description of MessageService
 *
 * @author eanjorin
 */
class MessageService {

  use \Neartutor\Traits\ErrorTrait;

  private $messageRepository;

  public function __construct(MessageRepository $msgRepo) {
	$this->messageRepository = $msgRepo;
  }
  
    /**
   * Delete a mail.
   * Use soft delete to temporarily delete a message.
   * @param int $user_id
   * @param string $mail_type inbox/sent
   * @param array $mail_ids
   * @return boolean
   */
  public function deleteMessages($user_id, $mail_type, array $mail_ids)  {
	if($this->messageRepository->deleteMessages($user_id, $mail_ids, $mail_type)){
	  return true;
	} else {
	  $this->addError($this->messageRepository->errors());
	}
  }

  /**
   * Return all user's message for the specified filter
   * @param  int  $id

   * @return message data
   */
  public function getMessages($id, $filter) {

	switch (strtoupper($filter)) {
	  case "INBOX":
		return $this->messageRepository->getInbox($id);
	  case "SENT":
		return $this->messageRepository->getSent($id);
	}
	return [];
  }

  /**
   * Validate that the required fields are present and the sender_id
   * in the url matches the from field.
   * @param type $input
   * @param type $id
   * @return boolean
   */
  private function validateMessage($input, $id) {
	$validator = new MessageValidator($input);
	if (!$validator->passes()) {
	  $this->setError($validator->getValidator()->messages()->all());
	  return false;
	}
	if ($input['from'] != $id) {
	  $this->addError(["Sender id mismatch"]);
	  return false;
	}
	return true;
  }

  /**
   * Create Messages.
   *
   * @param array $input Array with message data
   * @param int $id Id of user sending the message
   * @todo (ebby) bulk insert the messages
   *
   */
  public function createMessages($input, $id) {
	
	if ($this->validateMessage($input, $id)) {
	  $recipients = $input['to'];
	  if (is_array($recipients)) {
		$message_id = $this->createMessage([
			"subject" => $input['subject'],
			"message" => $input['body'],
			"sender_id" => $id
		]);
		$messages = [];
		foreach ($recipients as $user) {
		  array_push($messages, [
			  "message_id" => $message_id,
			  "user_id" => $user
		  ]);
		}
		DB::table('user_messages')->insert($messages);
		return true;
	  }
	  return false;
	} else {
	  return false;
	}
  }

  /** Create message record in messages table
   * @param array $data Message data
   * @return int Id of create message
   */
  private function createMessage($data) {
	return $this->messageRepository->create($data);
  }

  public function search($id, $filter, $query) {
	return $this->messageRepository->search($id, $filter, $query);
  }
}
