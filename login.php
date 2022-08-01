<?php
	require 'config.php';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login - CHAT ONLINE</title>
	<link rel="stylesheet" type="text/css" href="<?=$base ?>/assets/css/login.css">
</head>
<body>
	<div class="container">
		<form id="login_form" method="POST" action="<?= $base ?>/loginAction.php">
			<h2>Fazer Login</h2>
			<?php if( !empty($_SESSION['flash']) ): ?>
				<div class="flash">
					<?php echo $_SESSION['flash'] ?>
					<?php $_SESSION['flash'] = '';?>	
				</div>
			<?php endif;?>
		<input type="email" placeholder="Digite seu Email" name="email">
		<input type="password" name="password" placeholder="Digite sua senha">
		<input type="submit" value="Entrar">
		

		<div class="link">
			<p>Não tem conta ?</p> <a href="<?= $base ?>/register.php">Crie uma</a>
		</div>
		
	</form>
	</div>
</body>
</html>