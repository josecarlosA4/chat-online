<?php 

class Message {

	public $id;
	public $id_chat;
	public $id_user;
	public $date_msg;
	public $msg_type;
	public $msg;
}

interface MessageDao {
	public function insertMessage(Message $m);
	public function getMessages($id_chat);
	public function getMessagesInRealTime($groups, $lastTime);
}