<?php 

require 'config.php';
require 'models/Auth.php';
require 'dao/ChatRelationDaoMySql.php';

header("Content-Type: application/json");

$idChat = intval($_POST['id_chat']);

$array = [];

$r = new Auth($pdo, $base);
$userInfos = $r->checkLogin();

$crDao = new ChatRelationDaoMySql($pdo);
$array['check'] = $crDao->removeRelation($idChat, $userInfos->id);

echo json_encode($array);
return $array;