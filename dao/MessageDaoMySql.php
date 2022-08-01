<?php 

require_once 'models/Message.php';

class MessageDaoMySql implements MessageDao {

	public function __construct(PDO $driver) {
		$this->pdo = $driver;
	}

	

	public function insertMessage(Message $m) {
		$sql = $this->pdo->prepare("INSERT INTO messages 
			(id_chat, id_user, date_msg, msg_type, msg)
			VALUES 
			(:id_chat, :id_user, :date_msg, :msg_type, :msg)
			");
		$sql->bindValue(':id_chat', $m->id_chat);
		$sql->bindValue(':id_user', $m->id_user);
		$sql->bindValue(':date_msg', $m->date_msg);
		$sql->bindValue(':msg_type', $m->msg_type);
		$sql->bindValue(':msg', $m->msg);
		$sql->execute();

		return true;
	}

	public function getMessages($id_chat) {
		$array = [];
		
		$sql = $this->pdo->prepare("SELECT messages.*, users.nick as user_nick FROM  messages LEFT JOIN  users ON users.id = messages.id_user WHERE id_chat = :id_chat ORDER BY date_msg DESC");
		$sql->bindValue(':id_chat', $id_chat);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		
		return $array;
	}

	public function getMessagesInRealTime($groups, $lastTime) {
		$array = [];

		$sql = $this->pdo->prepare("SELECT messages.*, users.nick as user_nick FROM messages LEFT JOIN users ON users.id = messages.id_user WHERE date_msg > :lasttime AND id_chat IN (".implode(',', $groups).") ORDER BY date_msg ASC");
		$sql->bindValue(':lasttime', $lastTime);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		return $array;

	}
}