<?php 

require 'config.php';
require 'models/Auth.php';
require 'vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;
	
Image::configure(['driver' => 'GD']);

$r = new Auth($pdo, $base);

$userInfos = $r->checkLogin();

$nick = filter_input(INPUT_POST, 'nick', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$birthdate = filter_input(INPUT_POST, 'birthdate');
$desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

header("Content-Type: multipart/form-data");
$array = ['errors' => '', 'success' => ''];

if($nick && $email && $birthdate) {

	$imageName = '';

	if(!empty($_FILES['image']['name'])) {
		$img = $_FILES['image'];

		$allowedTypes = ['image/jpeg', 'image/jpg', 'image/pgn'];

		if(in_array($img['type'], $allowedTypes)) {

			$extension = explode('/', $img['type']);
			$extension = $extension[1];

			$imageName = md5(time().rand(0, 9999).$img['name']).'.'.$extension;

			Image::make($img['tmp_name'])->fit(150, 150)->save('media/avatars/'.$imageName); 
		} else {
			$array['errors'] = 'Tipo de image não permitido';
			echo json_encode($array);
			return $array;
		}
	} else {
		$imageName = $userInfos->avatar;
	}

	if(strlen($nick) < 2) {
		$array['errors'] = 'O nick name deve ter no minímo 2 caracteres';
		echo json_encode($array);
		return $array;
	} 

	$checkNick = $r->authNick($nick);

	if($checkNick != true) {

		$array['errors'] = $checkNick;
		echo json_encode($array);
		return $array;
	}

	if($email != $userInfos->email) {
		if($r->emailExists($email) == true) {
			$array['errors'] = 'Email já esté em uso';
			echo json_encode($array);
			return $array;
		}
	}

	$hash = '';

	if($password) {

		if(strlen($password) < 4) {
			$array['errors'] = 'A senha deve ter no minímo 4 caracteres';
			echo json_encode($array);
			return $array;
		}
		$hash = password_hash($password, PASSWORD_DEFAULT);
	} else {
		$hash = $userInfos->password;
	}
	
	
	$birthdate = explode('/', $birthdate);

	if(count($birthdate) != 3) {
		$array['errors'] = 'Está data é invalida';
		echo json_encode($array);
		return $array;
	}

	$birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];

	if(strtotime($birthdate) === false) {
		$array['errors'] = 'Está data é invalida';
		echo json_encode($array);
		return $array;
	}

	$id = $userInfos->id;

	$dao = new UserDaoMySql($pdo);
	$dao->updateUser($id,$nick, $email, $birthdate, $hash, $desc, $imageName);

	$array['tmp_avatar'] = $imageName;
	$array['success'] = 'Dados alterados com sucesso :)';
	echo json_encode($array);
	return $array;

} else {
	$array['errors'] = 'Existem campos obrigatórios vazios';
	echo json_encode($array);
	return $array;
}
