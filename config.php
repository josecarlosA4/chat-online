<?php 

session_start();

$base = 'http://localhost/projetos_php/chatOnlineOO';

$db_name = 'sistemadechat';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

$pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host,$db_user,$db_pass);
