<?php

class Chat {

	public $id;
	public $name;
	public $avatar;
	public $id_author;
	public $created_at;
	public $type;
}


interface ChatDao {
	public function createPublicChat(Chat $data);
	public function getChats($chatIds);
	public function search($term);
	public function getChat($idChat);
	public function getInfosOfActiveGroup($id_group);
	
}