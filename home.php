<?php 

	require 'config.php';
	require 'models/Auth.php';

	$r = new Auth($pdo, $base);
	$userInfos = $r->checkLogin();

	$birthdate = explode('-', $userInfos->birthdate);
	$birthdate  = $birthdate[2].'/'.$birthdate[1].'/'.$birthdate[0];
 ?>


 <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>HOME - Chat online</title>
	<link rel="stylesheet" type="text/css" href="<?= $base ?>/assets/css/home.css">
</head>
<body>
	<div class="aside">
		<div class="aside-icons-bar">
			<div id="git-link" class="aside-icon">
				<i class="fa-brands fa-github"></i>
			</div>	

			<div onclick="showChatsSideBar()" class="aside-icon">
				<i class="fa-solid fa-comments"></i>
			</div>	

			<div class="aside-icon" onclick="showProfile()">
				<i class="fa-solid fa-user"></i>
			</div>	
			<div onclick="showAddGroupPage()" class="aside-icon">
				<i class="fa-solid fa-plus"></i>
			</div>
			<div  class="aside-icon" onclick="confirm('Deseja realmente sair ?')" id="logout-icon">
				<i class="fa-solid fa-power-off"></i>
			</div>	
		</div>
		<div class="aside-content">
			<div class="title-home">CHAT <span>ONLINE</span></div>
			<div class="aside-search-area">
				<div class="aside-search-items">
					<input type="text" placeholder="Buscar..." id="term">
				</div>	
			</div>
			<div class="list">
				<ul> 

				</ul>
			</div>
		</div>
	</div>



	<div class="container-right" style="background: #363636;">
		<!--
		<div class="container-header">
			<div class="container-header-left">
				<img src="https://www.google.com.br/logos/google.jpg">
				<div class="container-left-info">
					<span>NOME DO GRUPO</span>
					<span>1000 membros, 2 online </span>
				</div>
			</div>

			<div class="container-header-right">
				<button class="follow-button follow">SEGUIR</button>
				<span><i class="fa-solid fa-align-right"></i></span>
			</div>
		</div>

		<div class="container-body">
			<ul class="messages-list">	
				<li class="message-item message-received">
					<span class="message-item-name ">Carlinhos</span>
					<span class="message-item-body">
						aaaaaaaaaaaaaaaaaaaaaaa
					</span>
				</li>
				<li class="message-item message-sent">
					<span class="message-item-name">ANDINHO</span>
					<span class="message-item-body">
						aaaaaaaaaaaaaaaaaaaaaaa
					</span>
				</li>
			</ul>



			<div class="aside-right-container-body" style="display: none;">	
				<div class="aside-right-header">
					<img src="https://www.google.com.br/logos/google.jpg">
					<span class="aside-right-header-name">NOME DO GRUPO</span>
				</div>
				<div class="infos-chat-area">
					<div class="info-option" onclick="showInfosChat()">Informações</div>
					<div class="members-option" onclick="showMemBersChat()">Membros</div>
				</div>
				<div class="aside-right-body">
					<h4>Criado em:</h4>
					<div class="aside-right-header-content">
						23/08/2003
					</div>
					<h4>Descrição:</h4>
					<div class="aside-right-header-content">
						Essa é a descrição do grupoaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
					</div>
					
					<ul class="members-list">
						<li class="member-item">
							<img src="https://www.google.com.br/logos/google.jpg">
							<span class="member-name">José Carlos</span>
							<span class="member-chat-icon"><i class="fa-solid fa-comment"></i></span>
						</li>
					</ul>
				
				</div>
				
			</div>
		</div>
	
	
		<div class="container-footer">
			<div class="message-send-area">
				<textarea></textarea>
				<span><i class="fa-solid fa-image icon-image"></span>
					<input type="file" id="image" name="file">	
			</div>

		</div>
	-->
	</div>

	<script src="https://unpkg.com/imask"></script> 	
	<script type="text/javascript">
		const BASE_URL = '<?= $base ?>';

		var user_infos = {
			'id': <?= $userInfos->id ?>,
			'nick': '<?= $userInfos->nick ?>',
			'email': '<?= $userInfos->email ?>',
			'avatar': '<?= $userInfos->avatar ?>',
			'description': '<?= $userInfos->description ?>',
			'birthdate': '<?= $birthdate?>',
		};
	</script>

	<script type="text/javascript" src="<?= $base ?>/assets/js/jquery-3.6.0.min.js"></script>
	<script type="text/javascript">
		
	</script>





	<script type="text/javascript" src="<?= $base ?>/assets/js/chat.js"></script>
	<script type="text/javascript" src="<?= $base ?>/assets/js/script.js"></script>
	<script src="https://kit.fontawesome.com/1dcd3273ac.js" crossorigin="anonymous"></script>
</body>
</html>