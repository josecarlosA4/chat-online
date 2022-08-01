<?php 

require 'config.php';
require 'models/Auth.php';
require 'dao/MessageDaoMySql.php';

$id_chat = intval($_GET['id_chat']);

$array = [];

header("Content-Type: application/json");

$r = new Auth($pdo, $base);
$userInfos = $r->checkLogin();

$dao = new MessageDaoMySql($pdo);
$array = $dao->getMessages($id_chat);

echo json_encode($array);
return $array;
