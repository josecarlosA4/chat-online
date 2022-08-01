<?php 

require 'config.php';
require 'models/Auth.php';

$r = new Auth($pdo, $base);

$nick = filter_input(INPUT_POST, 'nick', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$birthdate = filter_input(INPUT_POST, 'birthdate');
$password = filter_input(INPUT_POST, 'password');


if($nick && $email && $birthdate && $password) {

	if(strlen($nick) < 2) {
		$_SESSION['flash'] = 'O campo de login deve ter no minímo 2 caracteres';
		header("Location: ".$base.'/register.php');
		exit;
	} 

	$checkNick = $r->authNick($nick);

	if($checkNick != true) {

		$_SESSION['flash'] = $checkNick;
		header("Location: ".$base.'/register.php');
		exit;
	}

	if($r->emailExists($email) == true) {
		$_SESSION['flash'] = 'Email já está em uso';
		header("Location: ".$base.'/register.php');
		exit;
	}


	if(strlen($password) < 4) {
		$_SESSION['flash'] = 'A senha deve ter no mínimo 4 caracteres';
		header("Location: ".$base.'/register.php');
		exit;
	}

	
	$birthdate = explode('/', $birthdate);

	if(count($birthdate) != 3) {
		$_SESSION['flash'] = 'Está data é invalida';
		header('Location: '.$base.'/register.php');
		exit;
	}

	$birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];

	if(strtotime($birthdate) === false) {
		$_SESSION['flash'] = 'Está data é invalida';
		header('Location: '.$base.'/register.php');
		exit;
	}

	$hash = password_hash($password, PASSWORD_DEFAULT);

	$r->create($nick, $email, $birthdate, $hash);


} else {
	$_SESSION['flash'] = 'Todos os campos devem estar preenchidos';
	header("Location: ".$base.'/register.php');
	exit;
}
