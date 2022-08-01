<?php 

require_once 'models/Chat.php';

class ChatDaoMySql implements ChatDao {

	private $pdo;
	
	public function __construct(PDO $driver) {
		$this->pdo = $driver;		
	}

	public function generateChats($data) {

		$array = [];

		foreach($data as $item) {
			$u = new Chat();
			$u->id = $item['id'];
			$u->name = $item['name'];
			$u->avatar = $item['avatar'];
			$u->id_author = $item['id_author'];
			$u->created_at = $item['created_at'];
			$u->type = $item['type'];

			$array[] = $u;
		}

		return $array;
	}

	public function getLastGroup($id_user) {
		$sql = $this->pdo->prepare("SELECT * FROM chats WHERE id_author = :id");
		$sql->bindValue(':id', $id_user);
		$sql->execute();

		$data = $sql->fetchAll(PDO::FETCH_ASSOC);
		$lastGroup = end($data);
		
		return $lastGroup['id'];
	}	

	public function createPublicChat(Chat $data) {

		$sql = $this->pdo->prepare("INSERT INTO chats 
			(name, avatar, id_author, created_at, type) 
				VALUES
			(:name, :avatar, :id_author, :created_at, :type)	
			");
		$sql->bindValue(':name', $data->name);
		$sql->bindValue(':avatar', $data->avatar);
		$sql->bindValue(':id_author', $data->id_author);
		$sql->bindValue(':created_at', $data->created_at);
		$sql->bindValue(':type', $data->type);
		$sql->execute();

		$lastChatId = $this->getLastGroup($data->id_author);

		return $lastChatId;

	}

	public function getChats($chatIds) {

		$array = [];
		
		$sql = $this->pdo->query("SELECT * FROM chats WHERE id IN (".implode(',', $chatIds).")");

		if($sql) {
			$data = $sql->fetchAll(PDO::FETCH_ASSOC);
			$array = $this->generateChats($data);
			
		}
		
		return $array;
	}

	public function search($term) {

		$array = [];

		$sql = $this->pdo->prepare("SELECT * FROM chats WHERE name LIKE :term");
		$sql->bindValue(':term', '%'.$term.'%');
		$sql->execute();

		if($sql->rowCount() > 0 ) {
			$data = $sql->fetchAll(PDO::FETCH_ASSOC);
			$array = $this->generateChats($data);
		}

		return $array;
	}

	public function getChat($idChat) {
		$array = [];

		$sql = $this->pdo->prepare("SELECT * FROM chats WHERE id = :id");
		$sql->bindValue(':id', $idChat);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch(PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getInfosOfActiveGroup($id_group) {
		$array = [];

		$sql = $this->pdo->prepare("SELECT * FROM chats WHERE id = :id");
		$sql->bindValue(':id', $id_group);
		$sql->execute();

		$array = $sql->fetch(PDO::FETCH_ASSOC);

		return $array;
	}
}