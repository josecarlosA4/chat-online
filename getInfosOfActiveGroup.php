<?php 

require 'config.php';
require 'models/Auth.php';
require 'dao/ChatRelationDaoMySql.php';
require 'dao/ChatDaoMySql.php';

header("Content-Type: application/json");

$array = [];

$idGroup = intval(filter_input(INPUT_POST, 'id_chat'));

$r = new Auth($pdo, $base);
$userInfos = $r->checkLogin();

$cDao = new ChatDaoMySql($pdo);
$array['infoschat'] = $cDao->getInfosOfActiveGroup($idGroup);


$uDao = new UserDaoMySql($pdo);
$array['author'] = $uDao->findById($array['infoschat']['id_author']);


$crDao = new ChatRelationDaoMySql($pdo);
$array['users'] = $crDao->getUsers($idGroup);


echo json_encode($array);
return $array;
