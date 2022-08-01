<?php 

require 'config.php';
require 'models/Auth.php';
require 'dao/MessageDaoMySql.php';

$r = new Auth($pdo, $base);
$userInfos = $r->checkLogin();

$id_chat = intval(filter_input(INPUT_POST, 'id_chat'));
$img = $_FILES['image'];

header("Content-Type: multipart/form-data");
$array = ['status' => 1, 'errors' => ''];

if($id_chat && !empty($_FILES['image']['tmp_name'])) {

		$imageName = '';
		$allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];

		if(in_array($img['type'] , $allowedTypes)) {
			
			$extension = explode('/', $img['type']);
			$extension = $extension[1];

			$imageName = md5(time().rand(0,9999).$img['name']).'.'.$extension;

			move_uploaded_file($img['tmp_name'], 'media/images/'.$imageName);

		} else {
			$array['status'] = 0;
			$array['errors'] = 'Tipo de imagem não permitida';
			echo json_encode($array);
			return $array;
		}
	$date = date('Y-m-d H:i:s');
	$m = new Message();
	$m->id_chat = $id_chat;
	$m->id_user = $userInfos->id;
	$m->date_msg = $date;
	$m->msg_type = 'image';
	$m->msg = $imageName;

	$dao = new MessageDaoMySql($pdo);
	$dao->insertMessage($m);

	echo json_encode($array);
	return $array;

}