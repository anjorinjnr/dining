<?php

namespace Neartutor\Repository;

use Neartutor\Models\Message;
use Neartutor\Models\UserMessage;
use \DB;

class MessageRepository extends Repository {

  /**
   * Get the Message from message id.
   * @param  int  $id

   * @return message data
   */
  const PAGE_SIZE = 14;

  public function get($id) {

	$message = Message::find($id);
	return $message;
  }

  public function delete($param) {
	
  }

  public function getInbox($user_id) {
	return DB::table('user_messages as um')
				->join('messages as m', 'um.message_id', '=', 'm.id')
				->join('users as u', 'm.sender_id', '=', 'u.id')
				->select(DB::raw("um.id, um.status, m.subject, m.message, u.id as sender_id, "
							. "concat(u.first_name, ' ' , u.last_name) as sender, "
							. "m.created_at"))
				->where('um.user_id', $user_id)
				->whereNull('um.deleted_at')
				//->where('um.status', 0)
				->orderBy('created_at', 'desc')->paginate(self::PAGE_SIZE);
  }

  public function getSent($user_id) {
	$result = Message::with(['recipients' => function($query) {
					  $query->select(DB::raw("message_id, u.id as user_id, "
								  . "concat(u.first_name, ' ', u.last_name) as name"))
					  ->join('users as u', 'u.id', '=', 'user_messages.user_id');
					}])->where('sender_id', $user_id)
				->orderBy('created_at', 'desc')->paginate(self::PAGE_SIZE);
	//print_r(DB::getQueryLog());
	return $result;
  }

  /**
   * Create Message with message data array.
   * @param  array $data

   * @return message id;
   */
  public function create($data) {
	try {
	  $message = Message::create($data);
	  return $message->id;
	} catch (Exception $e) {
	  $this->addError("Message Not Created");
	  return false;
	}
  }

  /**
   * Delete messages given a list of ids
   * @param integer $user_id
   * @param array $mail_ids
   * @param string $mail_type inbox/sent
   * @return boolean
   */
  public function deleteMessages($user_id, array $mail_ids, $mail_type) {
	switch (strtoupper($mail_type)) {
	  case "INBOX":
		$deleted = UserMessage::whereIn('id', $mail_ids)
			  ->where('user_id', $user_id)
			  ->delete();
		break;
	  case "SENT":
		$deleted = Message::whereIn('id', $mail_ids)
			  ->where('sender_id', $user_id)
			  ->delete();
	}
	if ($deleted > 0) {
	  return true;
	} else {
	  return false;
	}
  }

  public function search($user_id, $mail_type, $query) {
	switch (strtoupper($mail_type)) {
	  case "INBOX":
		$results = DB::table('messages as m')
			  ->join('user_messages as um', 'm.id', '=', 'um.message_id')
			  ->join('users as u', 'm.sender_id', '=', 'u.id')
			  ->select(DB::raw("um.id, um.status, m.subject, m.message, u.id as sender_id, "
						  . "concat(u.first_name, ' ' , u.last_name) as sender, "
						  . "m.created_at"))
			  ->whereRaw("um.deleted_at IS NULL AND um.user_id = ? AND ( "
					. "Match(m.subject, m.message) against (?) "
					. " OR u.first_name = ? "
					. " OR u.last_name = ? "
					. " OR concat(u.first_name, ' ', u.last_name) = ?"
					. " OR concat(u.last_name, ' ', u.first_name) = ?)", [$user_id, $query, $query, $query, $query, $query])
			  ->paginate(self::PAGE_SIZE);
		return $results;
	  case "SENT":

		//$query_like = addcslashes($query_like, "%_");
		$ids = DB::table('messages as m')
			  ->join('user_messages as um', 'm.id', '=', 'um.message_id')
			  ->join('users as u', 'um.user_id', '=', 'u.id')
			  ->select('m.id')
			  ->whereRaw("m.deleted_at IS NULL AND m.sender_id = ? AND ( "
					. "Match(m.subject, m.message) against (?) "
					. " OR u.first_name = ? "
					. " OR u.last_name = ? "
					. " OR concat(u.first_name, ' ', u.last_name) = ?"
					. " OR concat(u.last_name, ' ', u.first_name) = ?)", [$user_id, $query, $query, $query, $query, $query])
			  ->get();
		if (count($ids) > 0) {
		  $mails = array_pluck($ids, 'id');
		  $result = Message::with(['recipients' => function($query) {
							$query->select(DB::raw("message_id, u.id as user_id, "
										. "concat(u.first_name, ' ', u.last_name) as name"))
							->join('users as u', 'u.id', '=', 'user_messages.user_id');
						  }])->whereIn('id', $mails)
					  ->orderBy('created_at', 'desc')->paginate(20);
		  return $result;
		} else {
		  return [];
		}
	}
  }

  /**
   * Update Message.
   * @param  array $data
   * @param  int $id

   * @return boolean
   */
  public function update($data, $id) {
	$message = Message::find($id);
	if ($message) {
	  $message->update($data);
	  return true;
	}
	return false;
  }

}
