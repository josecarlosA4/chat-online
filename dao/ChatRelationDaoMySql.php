<?php 

require_once 'models/ChatRelation.php';

class ChatRelationDaoMySql implements ChatRelationDao {

	private $pdo;
	
	public function __construct(PDO $driver) {
		$this->pdo = $driver;		
	}

	public function setRelation($id_group, $id_user) {
		$array = [];
		$date = date('Y-m-d H:i:s');

		$sql = $this->pdo->prepare("INSERT INTO chatrelations 
			(id_chat, id_user, created_at) 
			VALUES 
			(:id_chat, :id_user, :created_at)");
		$sql->bindValue(':id_chat', $id_group);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':created_at', $date);
		$sql->execute();

		return true;
	}

	public function getRelations($id_user) {
		$array = [];

		$sql = $this->pdo->prepare("SELECT id_chat FROM chatrelations WHERE id_user = :id_user");
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(PDO::FETCH_ASSOC);

			foreach($data as $item) {
				$array[] = $item['id_chat'];
			}
		}

		return $array;	
	}

	public function getUsers($id_chat) {
		$array = [];

		$sql = $this->pdo->prepare("SELECT chatrelations.id, users.nick, users.avatar FROM chatrelations LEFT JOIN users ON users.id = chatrelations.id_user WHERE id_chat = :id_chat");
		$sql->bindValue(':id_chat', $id_chat);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);

		}
		return $array;
	}

	public function removeRelation($idChat, $idUser) {
			$sql = $this->pdo->prepare("DELETE FROM chatrelations WHERE id_user = :id_user AND id_chat = :id_chat");
			$sql->bindValue(':id_user', $idUser);
			$sql->bindValue(':id_chat', $idChat);
			$sql->execute();
			return true;
	}

}