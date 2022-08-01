<?php

	require_once 'models/User.php';

	class UserDaoMySql implements UserDao {

		private $pdo;

		public function __construct(PDO $driver) {
			$this->pdo = $driver;
		}

		public function generateUser($data) {
			$u = new User();

			$u->id = $data['id'];
			$u->nick = $data['nick'];
			$u->email = $data['email'];
			$u->password = $data['password'];
			$u->avatar = $data['avatar'];
			$u->birthdate = $data['birthdate'];
			$u->description = $data['description'];
			$u->token = $data['token'];

			return $u;
		}

		public function findByToken($token) {
			$sql = $this->pdo->prepare('SELECT * FROM users WHERE token = :token');
			$sql->bindValue(':token', $token);
			$sql->execute();

			if($sql->rowCount() > 0) {
				$data = $sql->fetch(PDO::FETCH_ASSOC);
				$user = $this->generateUser($data);
				return $user;
			} else {
				return false;
			}
		}

		public function registerUser($u) {
			 $sql = $this->pdo->prepare("INSERT INTO users 
			 	(nick, email, password,token, birthdate) 
			 	VALUES 
			 	(:nick, :email, :password, :token, :birthdate)");

			 $sql->bindValue(':nick', $u->nick);
			 $sql->bindValue(':email', $u->email);
			 $sql->bindValue(':password', $u->password);
			 $sql->bindValue(':token', $u->token);
			 $sql->bindValue(':birthdate', $u->birthdate);
			 $sql->execute();

			 return true;
		}

		public function teste() {
			$sql = $this->pdo->query("SELECT * FROM chats");

			$data = $sql->fetchAll(PDO::FETCH_ASSOC);

			print_r($data);
			exit;
		}

		public function findByEmail($email) {
			$sql = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
			$sql->bindValue(':email', $email);
			$sql->execute();

			if($sql->rowCount() > 0 ) {
				$data = $sql->fetch(PDO::FETCH_ASSOC);
				$user = $this->generateUser($data);
				return $user;
			} else {	
				return false;
			}
		}

		public function updateToken($token, $id) {
			$sql = $this->pdo->prepare("UPDATE users SET token = :token WHERE id=:id");
			$sql->bindValue(':token', $token);
			$sql->bindValue(':id', $id);
			$sql->execute();


			return true;
		}

		public function updateUser($id, $nick, $email, $birthdate, $hash, $desc, $avatar) {
			$sql = $this->pdo->prepare("UPDATE users SET
				nick = :nick, email = :email, birthdate = :birthdate, password = :password,
				description = :description, avatar = :avatar 
				WHERE id = :id
				");
			$sql->bindValue(':nick', $nick);
			$sql->bindValue(':email', $email);
			$sql->bindValue(':birthdate', $birthdate);
			$sql->bindValue(':password', $hash);
			$sql->bindValue(':description', $desc);
			$sql->bindValue(':avatar', $avatar);
			$sql->bindValue(':id', $id);
			$sql->execute();

			return true;
		}

		public function findById($id) {
			$array = [];

			$sql = $this->pdo->prepare("SELECT nick,avatar FROM users WHERE id = :id");
			$sql->bindValue(":id", $id);
			$sql->execute();

			$array = $sql->fetch(PDO::FETCH_ASSOC);

			return $array;
		}

	}