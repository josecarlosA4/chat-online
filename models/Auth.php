<?php 

	require_once 'dao/UserDaoMySql.php';

class Auth {

	private $pdo;
	private $base;
	private $dao;


	public function __construct(PDO $driver, $path) {
		$this->pdo = $driver;
		$this->base = $path;
		$this->dao = new UserDaoMySql($this->pdo);
	}

	public function checkLogin() {
		if(!empty($_SESSION['token'])) {

			$token = $_SESSION['token'];
			$user = $this->dao->findByToken($token);

			if($user) {
				return $user;
			} else {
				header('Location: '.$this->base.'/login.php');
				exit;
			}

		} else {
			header('Location: '.$this->base.'/login.php');
			exit;
		}
	}

	public function authNick($nick) {

			$sql = $this->pdo->prepare('SELECT * FROM users WHERE nick = :nick');
			$sql->bindValue(':nick', $nick);
			$sql->execute();


			$msg = '';
			if($sql->rowCount() > 0) {
				$msg = 'Este nick já está em uso';
				return $msg;
			}

			if(preg_match('/^[a-z0-9]+$/', $nick)) {
				return true;		
			} else {
				$msg = 'NickName é invalido, tente usar apenas letras e números ;)';
				return $msg ;
			}

			
	}

	public function emailExists($email) {
		$sql = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
		$sql->bindValue(':email', $email);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}

	}

	public function create($nick, $email, $birthdate, $hash) {

		$token = md5(time().rand(0,9999).$nick.time());

		$u = new User();
		$u->nick = $nick;
		$u->email = $email;
		$u->birthdate = $birthdate;
		$u->password = $hash;
		$u->token = $token;

		$this->dao->registerUser($u);

		$_SESSION['token'] = $token;
		header('Location: '.$this->base.'/home.php');
		exit;

	}

	public function validateLogin($email, $password) {

		$user = $this->dao->findByEmail($email);

		if($user) {

			if(password_verify($password, $user->password)) {

				$token = md5(time().rand(0,9999).$user->nick.time());

				$this->dao->updateToken($token, $user->id);
				$_SESSION['token'] = $token;

				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}
}