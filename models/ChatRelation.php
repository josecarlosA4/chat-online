<?php 

class ChatRelation {
	public $id;
	public $id_group;
	public $id_user;
	public $created_at;
}

interface ChatRelationDao {
	public function setRelation($id_group, $id_user);
	public function getRelations($id_user);
	public function removeRelation($idChat, $idUser);
}
