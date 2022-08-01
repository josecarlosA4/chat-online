<?php 

	require 'config.php';
	require 'models/Auth.php';
	require 'dao/ChatRelationDaoMySql.php';
	require 'dao/ChatDaoMySql.php';

	
	header("Content-Type: application/json");
	$array = ['status' => 1, 'group' => ''];
	$idChat = intval($_POST['id_chat']);

	$r = new Auth($pdo, $base);
	$userInfos = $r->checkLogin();

	$gDao = new ChatDaoMySql($pdo);
	$group = $gDao->getChat($idChat);

	$dao = new ChatRelationDaoMySql($pdo);
	$dao->setRelation($idChat, $userInfos->id);


	$array['group'] = $group;
	echo json_encode($array);
	return $array;