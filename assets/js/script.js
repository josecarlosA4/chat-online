var groups = [];
var activeGroup = 0;
var lastTime = '';


function setGroup(id, name, avatar) {
	var found = false;

	for(let i in this.groups) {
		if(this.groups[i].id == id) {
			found = true;
		}
	}

	if(found == false) {
		this.groups.push({
			id: id,
			name: name,
			avatar:avatar,
			msgs:[],
			msgsLive:[],
		})	
	}
}

function showChatsSideBar() {	
	$('.aside-search-area').show('fast');
	chat.showChats();
}

showChatsSideBar()

function setActiveGroup(id) {
	this.activeGroup = id;
	loadGroupActive();
	chat.getHistoricMessages();	
}

var group = null;

function loadGroupActive() {
	if(this.activeGroup != 0) {
		for(let i in this.groups) {
			if(this.groups[i].id == this.activeGroup) {
				group = this.groups[i];
			}
		}

		var html = '';
		html += '<div class="container-header">';
		html += '<div class="container-header-left">';
		html += '<img src="'+BASE_URL+'/media/avatars/'+group.avatar+'">';
		html += '<div class="container-left-info">'
		html += '<span>'+group.name+'</span>';
		html += '<span>1000 membros, 2 online </span>'
		html += '</div>';
		html += '</div>';
		html += '<div class="container-header-right">'
		html += '<button onclick="chat.removeRelation()" class="follow-button  unfollow">Sair</button>';
		html += '<span><i class="fa-solid fa-align-right"></i></span>';
		html += '</div>';
		html += '</div>'

		html += '<div class="container-body">';
		html += '<ul class="messages-list">';
			
		html += '</ul>'


		html += '<div class="aside-right-container-body" style="display: none;">';	
		html += '<div class="aside-right-header">';
		html += '<img src="https://www.google.com.br/logos/google.jpg">';		
		html += '<span class="aside-right-header-name">NOME DO GRUPO</span>'
		html += '</div>'
		html += '<div class="infos-chat-area">'
		html += '<div class="info-option" onclick="chat.getGroupActiveInfos()">Informações</div>'	
		html += '<div class="members-option" onclick="chat.getGroupActiveUsers()">Membros</div>'			
		html += '</div>';			
		html += '<div class="aside-right-body">';		
		html += '<h4>Criado em:</h4>';
		html += '<div class="aside-right-header-content">23/08/2003</div>';			
		html += '<h4>Descrição:</h4>';			
		html += '<div class="aside-right-header-content">Essa é a descrição do grupoaaaaaaaaaaaaa</div>';				
		html += '<ul class="members-list">';			
		html += '<li class="member-item">';
		html += '<img src="https://www.google.com.br/logos/google.jpg">';			
		html += '<span class="member-name">José Carlos</span>';			
		html += '<span class="member-chat-icon"><i class="fa-solid fa-comment"></i></span>'				
		html += '</li>';			
		html += '</ul>';		
		html += '</div>';			
		html += '</div>';				
		html += '</div>';


		html += '<div class="container-footer">';
		html += '<div class="message-send-area">';
		html += '<input type="text" id="input-send-text" placeholder="Digite algo">';
		html += '<span><i class="fa-solid fa-image icon-image"></span>';
		html += '<input type="file" id="image" name="file">';
		html += '</div>';
		html += '</div>';
							
						
		$('.container-right').html(html);

		$('.container-header-right span').on('click', function(){
			$('.aside-right-container-body').toggle('fast');
			chat.getGroupActiveInfos();

		});

		$('.message-send-area span').on('click', function(){
			$('#image').trigger('click');
		});

		$('.message-send-area #input-send-text').on('keyup', function(e){
			if(e.keyCode == 13) {
				var msg = $(this).val();
				$(this).val('');
				chat.sendMessage(msg);
			}
		})

		
		$('#image').on('change', function(e){	
			var image = $('#image').prop('files')[0];
			chat.sendPhoto(image);		
		});
		showInfosChat();

	}
}

function showMembersChat() {
	
			
}

function showInfosChat() {
	$('.aside-right-body').html('');

	html = '';
	html += '<h4>Criado em:</h4>';
	html += '<div class="aside-right-header-content">23/08/2003</div>'
	html += '<h4>Descrição:</h4>';
	html += '<div class="aside-right-header-content">';
	html += 'Essa é a descrição do grupo'
	html += '</div>';

	$('.members-option').removeClass('info-option-selected');
	$('.info-option').addClass('info-option-selected');
	$('.aside-right-body').html(html);
}

function showProfile() {
	$('.list ul').html('');

	$('.aside-search-area').hide('fast');

	var html = '';

	html += '<div class="profile">';
	html += '<span class="profile-header">'+'<img class="chat-img" src="'+BASE_URL+'/media/avatars/'+user_infos.avatar+'">'+'</span>';
	html += '<span class="userinfos">'
	html += '<div class="userinfo-item"><span>NickName:</span><br>'+user_infos.nick+'</div>';
	html += '<div class="userinfo-item"><span>Email:</span><br>'+user_infos.email+'</div>';
	html += '<div class="userinfo-item"><span>Data de Nascimento:</span><br>'+user_infos.birthdate+'</div>';
	html += '<div class="userinfo-item"><span>Descrição:</span><br>'+user_infos.description.replace('&#13;', '<br>')+'</div>'
	html+= '</span>'
	html += '<button onclick="showEditPage()" class="edit-button">Editar</button>'
	html += '</div>';

	$('.list ul').html(html);
}
function showEditPage() {

	$('.list ul').html('');

	$('.aside-search-area').hide('fast');

	var html = '';

	html += '<div class="profile">';
	html += '<span class="profile-header">'
	html += '<div class="json-callback-area"></div>'
	html += '<img class="chat-img" src="'+BASE_URL+'/media/avatars/'+user_infos.avatar+'">'
	html += '<span class="editAvatarIcon"><i class="fa-solid fa-image"></i></span>';
	html += '</span>';
	html += '<span class="userinfos">';
	html += '<div class="userinfo-item"><span>NickName: (obrigatório)</span><br><input value="'+user_infos.nick+'" type="text" id="nick"></div>';
	html += '<div class="userinfo-item"><span>Email: (obrigatório)</span><br><input type="email" value="'+user_infos.email+'" id="email"></div>';
	html += '<div class="userinfo-item"><span>Data de Nascimento: (obrigatório)</span><br><input type="text" value="'+user_infos.birthdate+'" id="birthdate"></div>';
	html += '<div class="userinfo-item"><span>Senha: (opcional)</span><br><input type="password" id="password"></div>';
	html += '<div class="userinfo-item"><span>Descrição: (opcional)</span><br><textarea id="desc" style="max-height: 90px;">'+user_infos.description+'</textarea> </div>';
	html += '<input type="file" class="file-input" id="avatar" name="file">';
	html += '</span>';
	html += '<div class="buttonProfileArea">';
	html += '<button class="edit-button">Salvar</button>';
	html += '<button onclick="showProfile()" class="cancel-button">Voltar</button>';
	html += '</div>'
	html += '</div>';

	$('.list ul').html(html);

	$('.editAvatarIcon').on('click', function(){
		$('#avatar').trigger('click')
	});

	$('.edit-button').on('click', function(){
		var avatar = $('#avatar').prop('files')[0];
		var nick = $('#nick').val();
		var email = $('#email').val();
		var birth =  $('#birthdate').val();
		var pass = $('#password').val();
		var desc = $('#desc').val();

		chat.editUserInfos(avatar, nick, email, birth, pass, desc, function(json){
			
			if(json.errors == '') {
				var tmpAvatar = json.tmp_avatar;
				$('.json-callback-area').show('fast');
				$('.json-callback-area').removeClass('json-callback-error');
				$('.json-callback-area').addClass('json-callback-success');
				$('.json-callback-area').html(json.success);
				setInterval(showProfile(), 1000);
			} else {
				$('.json-callback-area').show('fast');
				$('.json-callback-area').removeClass('json-callback-success');
				$('.json-callback-area').addClass('json-callback-error');
				$('.json-callback-area').html(json.errors);
			}
		});
	})

	IMask(
        document.getElementById('birthdate'),
        {
            mask:"00/00/0000"
        }
	);

}

function showAddGroupPage() {
	$('.list ul').html('');

	$('.aside-search-area').hide('fast');

	var html = '';

	html += '<div class="add-group-area">';
	html += '<h3>Adicionar novo grupo: </h3>'
	html += '<div class="json-callback-area"></div>'
	html += '<span class="add-group-name-span">Nome do grupo:</span>';
	html += '<input type="text" id="name-group">';
	html += '<button class="add-image-group">Foto do grupo</button>';
	html += '<input type="file" id="avatar-group">';
	html += '<button class="add-group-button">Criar</button>';
	html += '</div>';

	$('.list ul').html(html);

	$('.add-image-group').on('click', function(){
		$('#avatar-group').trigger('click');

	})

	$('.add-group-button').on('click', function(){

		var name = $('#name-group').val();
		var image = $('#avatar-group').prop('files')[0];

		chat.createPublicGroup(name, image, function(json){
			if(json.errors == '') {
				$('.json-callback-area').show('fast');
				$('.json-callback-area').removeClass('json-callback-error');
				$('.json-callback-area').addClass('json-callback-success');
				$('.json-callback-area').html(json.success);
			} else {
				$('.json-callback-area').show('fast');
				$('.json-callback-area').removeClass('json-callback-success');
				$('.json-callback-area').addClass('json-callback-error');
				$('.json-callback-area').html(json.errors);
			}
		});
	});
}

$(function(){

	$('#git-link').bind('click', function(){
		window.location.href = 'https://github.com/josecarlosA4';
		
	})

	chat.chatActivity();

	$('#logout-icon').on('click', function(){
		window.location.href = BASE_URL+'/logout.php';
	});

	$('#term').on('keyup', function(e) {
		if(e.keyCode == 13) {
			var term = $(this).val();
			chat.searchTerm(term);
		}
	});

	
	
});

