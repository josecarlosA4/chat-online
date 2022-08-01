<?php 

require 'config.php';
require 'models/Auth.php';
require 'dao/MessageDaoMySql.php';
require 'dao/ChatRelationDaoMySql.php';

header("Content-Type: application/json");
$array = ['status' => 1, 'msgs' => [], 'lastTime' => date("Y-m-d H:i:s")];

$r = new Auth($pdo, $base);
$userInfos = $r->checkLogin();


$gDao = new ChatRelationDaoMySql($pdo);
$groups = $gDao->getRelations($userInfos->id);

$rDao = new MessageDaoMySql($pdo);


set_time_limit(60);

$ultMsg = date("Y-m-d H:i:s");

if(!empty($_GET['lastTime'])) {
	$ultMsg = $_GET['lastTime'];
}

while(true) {
	session_write_close();

	$msgs = $rDao->getMessagesInRealTime($groups, $ultMsg);

	if(count($msgs) > 0) {
		$array['msgs'] = $msgs;
		$array['lastTime'] = date("Y-m-d H:i:s");
		break;
	} else {
		sleep(2);
		continue;
	}
}

echo json_encode($array);
return $array;
