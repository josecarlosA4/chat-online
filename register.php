<?php 

require 'config.php';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?=$base?>/assets/css/login.css">
	<title>Criar Conta - CHAT ONLINE</title>
</head>
<body>
	<div class="container">
		<form id="login_form" method="POST" action="<?= $base ?>/registerAction.php">
			<h2>Criar Conta</h2>

			<?php if( !empty($_SESSION['flash']) ): ?>
				<div class="flash">
					<?php echo $_SESSION['flash'] ?>
					<?php $_SESSION['flash'] = '';?>	
				</div>
			<?php endif;?>

		<input type="text" placeholder="Digite seu Nick" name="nick">
		<input type="email" placeholder="Digite seu Email" name="email">
		<input type="text" id="birthdate" name="birthdate" placeholder="Digite sua data de aniversario">
		<input type="password" name="password" placeholder="Digite sua senha">
		<input type="submit" value="Entrar">

		<div class="link">
			<p>Já tem conta ?</p> <a href="<?=$base?>/login.php">Faça Login</a>
		</div>
		
	</form>
	</div>
		<script src="https://unpkg.com/imask"></script> 	
	  	<script>
	        IMask(
	            document.getElementById('birthdate'),
	            {
	                mask:"00/00/0000"
	            }
	        );
	 	 </script>
</body>
</html>