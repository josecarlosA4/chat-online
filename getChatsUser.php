<?php 

require 'config.php';
require 'models/Auth.php';
require 'dao/ChatRelationDaoMySql.php';
require 'dao/ChatDaoMySql.php';

$array = [];

header("Content-Type: application/json");

$r = new Auth($pdo, $base);
$userInfos = $r->checkLogin();

$rDao = new ChatRelationDaoMySql($pdo);
$chatIds = $rDao->getRelations($userInfos->id);

$gDao = new ChatDaoMySql($pdo);
$array['chats'] = $gDao->getChats($chatIds);
$array['status'] = 1;

echo json_encode($array);
return $array;
