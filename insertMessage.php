<?php 

require 'config.php';
require 'models/Auth.php';
require 'dao/MessageDaoMySql.php';

$r = new Auth($pdo, $base);
$userInfos = $r->checkLogin();

$id_chat = intval(filter_input(INPUT_POST, 'id_chat'));
$msg = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_SPECIAL_CHARS);

header("Content-Type: application/json");
$array = ['status' => 1];

if($id_chat && $msg) {

	$date = date('Y-m-d H:i:s');
	$m = new Message();
	$m->id_chat = $id_chat;
	$m->id_user = $userInfos->id;
	$m->date_msg = $date;
	$m->msg_type = 'text';
	$m->msg = $msg;

	$dao = new MessageDaoMySql($pdo);
	$dao->insertMessage($m);

	echo json_encode($array);
	return $array;

}