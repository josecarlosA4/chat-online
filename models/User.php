<?php 

class User {
	public $id;
	public $nick;
	public $email;
	public $password;
	public $avatar;
	public $description;
	public $birthdate;
	public $token;
}

interface UserDao {

	public function registerUser($u);
	public function findByToken($token);
	public function findByEmail($email);
	public function findById($id);
	public function updateToken($token, $id);
	public function updateUser($id, $nick, $email, $birthdate, $hash, $desc, $avatar);
}