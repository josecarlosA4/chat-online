<?php 

require 'config.php';
require 'models/Auth.php';
require 'dao/ChatDaoMySql.php';

$r = new Auth($pdo, $base);
$userInfos = $r->checkLogin();

$dao = new ChatDaoMySql($pdo);

header("Content-Type: application/json");
$array = [];
$term = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_SPECIAL_CHARS);

if($term) {
	$array = $dao->search($term);	
}

echo json_encode($array);
return $array;