<?php 

require 'config.php';
require 'models/Auth.php';
require 'dao/ChatDaoMySql.php';
require 'dao/ChatRelationDaoMySql.php';
require 'vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;
	
Image::configure(['driver' => 'GD']);


$r = new Auth($pdo, $base);
$user = $r->checkLogin();

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$type = filter_input(INPUT_POST, 'typeChat');

header("Content-Type: multipart/form-data");
$array = ['errors' => '', 'success' => ''];

if($name && $type) {

	$imageName = '';

	if(!empty($_FILES['image']['name'])) {
		$img = $_FILES['image'];

		$allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];

		if(in_array($img['type'] , $allowedTypes)) {
			
			$extension = explode('/', $img['type']);
			$extension = $extension[1];

			$imageName = md5(time().rand(0,9999).$img['name']).'.'.$extension;

			Image::make($img['tmp_name'])->fit(150, 150)->save('media/avatars/'.$imageName);

		} else {
			$array['errors'] = 'Tipo de imagem não permitido';
			echo json_encode($array);
			return $array;
		}
	} else {
		$imageName = 'avatar.jpeg';
	}

	$date = date('Y-m-d H:i:s');

	$c = new Chat();
	$c->name = $name;
	$c->avatar = $imageName;
	$c->id_author = $user->id;
	$c->created_at = $date;
	$c->type = $type;

	$dao = new ChatDaoMySql($pdo);
	$idLastGroup = $dao->createPublicChat($c);

	$daoRelation = new ChatRelationDaoMySql($pdo);
	$daoRelation->setRelation($idLastGroup, $user->id);

	
	$array['success'] = 'Novo Grupo criado com sucesso';
	echo json_encode($array);
	return $array;
} else {	
	$array['errors'] = 'O campo de nome deve estar preenchido';
	echo json_encode($array);
	return $array;
}