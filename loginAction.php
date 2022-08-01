<?php 

require 'config.php';
require 'models/Auth.php';

$r = new Auth($pdo, $base);

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');


if($email && $password) {
  	if($r->validateLogin($email, $password)) {
  		header("Location: ".$base."/home.php");
		exit;
  	} else {
  		$_SESSION['flash'] = 'Email e/ou senha invalidos';
		header("Location: ".$base."/login.php");
		exit;	
  	}

} else {
	$_SESSION['flash'] = 'Todos os campos devem estar preenchidos';
	header("Location: ".$base.'/login.php');
	exit;
}



