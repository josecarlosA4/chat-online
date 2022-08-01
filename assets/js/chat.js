var chat = {



	createPublicGroup:function(name, image, ajaxCallBack) {

		var body = new FormData();

		body.append('name', name);
		body.append('image', image);
		body.append('typeChat', 'public');


		$.ajax({
			url: BASE_URL+'/createGroupAction.php',
			method:'POST',
			data: body,
			dataType: 'json',
			contentType: false,
			processData: false,
			success:function(json) {
				ajaxCallBack(json);
			}
		})
	},

	editUserInfos:function(avatar, nick, email, birth, pass, desc, ajaxCallBack) {

		var body = new FormData();

		body.append('image', avatar);
		body.append('email', email);
		body.append('nick', nick);
		body.append('birthdate', birth);
		body.append('description', desc);
		body.append('password', pass);

		$.ajax({
			url: BASE_URL+'/updateUserAction.php',
			method: 'POST',
			data: body,
			dataType: 'json',
			contentType: false,
			processData: false,
			success:function(json) {
				ajaxCallBack(json)
			}
		});
	},

	showChats:function() {

		$.ajax({
			url: BASE_URL+'/getChatsUser.php',
			method: 'GET',
			dataType: 'json',
			success:function(json) {
				if(json.status == '1') {
					
				var jsonChats = json.chats;

				if(Array.isArray(groups)){
					for(let i in jsonChats) {
						setGroup(jsonChats[i].id, jsonChats[i].name, jsonChats[i].avatar)
					}
				}
				var html = '';

				var chats = groups;	

				html += '<p class="chat-header">Conversas: </p>';
				for(let i in chats) {
					html += '<li class="chats-aside" onclick="setActiveGroup('+chats[i].id+')" style="margin-bottom: 10px;">';
					html += '<img class="chat-img" src="'+BASE_URL+'/media/avatars/'+chats[i].avatar+'">';
					html += '<div class="infos-chat">';
					html += '<span class="chat-name">'+chats[i].name+'</span>';
					html += '</div>';
					html += '</li>';

					$('.list ul').html(html);
				}

				}
			}
		});
	},

	searchTerm:function(term) {
		if(term != '') {

			$.ajax({
				url: BASE_URL+'/searchAction.php',
				method: 'GET',
				data: {term: term},
				dataType: 'json',
				success:function(json) {
					if(json != '') {

						var html = '';

						var chats = json;	

						html += '<p class="chat-header">Resultado de: '+term+' </p>';
						for(let i in chats) {
							html += '<li class="chats-aside" onclick="chat.setRelation('+chats[i].id+')" style="margin-bottom: 10px;">';
							html += '<img class="chat-img" src="'+BASE_URL+'/media/avatars/'+chats[i].avatar+'">';
							html += '<div class="infos-chat">';
							html += '<span class="chat-name">'+chats[i].name+'</span>';
							html += '</div>';
							html += '</li>';

							$('.list ul').html(html);
						}

					} else {
						$('.list ul').html('<span style="color:white; padding:5px;"><i>Não há registros...</i></span>');
					}
				}
			});
		}
	},

	setRelation:function(id_chat) {
		$.ajax({
			url: BASE_URL+'/setRelation.php',
			method: 'POST',
			data: {id_chat: id_chat},
			dataType: 'json',
			success:function(json) {
				showChatsSideBar();
				setActiveGroup(id_chat);
			}
		});
	},

	getHistoricMessages:function() {
		if(activeGroup != 0) {

		var id_chat = activeGroup;
		
		$.ajax({
			url: BASE_URL+'/getHistoricMessages.php',
			method: 'GET',
			data:{id_chat},
			dataType: 'json',
			success:function(json) {
				
				var groupActive;
				for(let i in groups) {
					if(groups[i].id == activeGroup) {
						groupActive = groups[i];
					}
				}

				groupActive.msgs = [];

				for(let i in json) {
					
						groupActive.msgs.push({
							nick: json[i].user_nick,
							body: json[i].msg,
							id_user: json[i].id_user,
							id: json[i].id,
							sender_date: json[i].date_msg,
							msg_type: json[i].msg_type
						});	
						
				}
				var htmlMsgs = '';

				for(let i in groupActive.msgs) {
				if(groupActive.msgs[i].msg_type == 'text') {

					if(groupActive.msgs[i].id_user == user_infos.id) {
							htmlMsgs += '<li class="message-item message-sent">'
							htmlMsgs += '<span class="message-item-name ">'+groupActive.msgs[i].nick+'</span>'
							htmlMsgs += '<span class="message-item-body">'+groupActive.msgs[i].body+'</span>'
							htmlMsgs += '</li>';
						} else {
							htmlMsgs += '<li class="message-item message-received">'
							htmlMsgs += '<span class="message-item-name ">'+groupActive.msgs[i].nick+'</span>'
							htmlMsgs += '<span class="message-item-body">'+groupActive.msgs[i].body+'</span>'
							htmlMsgs += '</li>';
					}
				} else if (groupActive.msgs[i].msg_type == 'image'){
					if(groupActive.msgs[i].id_user == user_infos.id) {
							htmlMsgs += '<li class="message-item image-message message-sent">'
							htmlMsgs += '<span class="message-item-name ">'+groupActive.msgs[i].nick+'</span>'
							htmlMsgs += '<img  src="'+BASE_URL+'/media/images/'+groupActive.msgs[i].body+'">';
							htmlMsgs += '</li>';
						} else {
							htmlMsgs += '<li class="message-item image-message message-received ">'
							htmlMsgs += '<span class="message-item-name ">'+groupActive.msgs[i].nick+'</span>'
							htmlMsgs += '<img  src="'+BASE_URL+'/media/images/'+groupActive.msgs[i].body+'">'
							htmlMsgs += '</li>';
					}
				}

				$('.messages-list').html(htmlMsgs);

				}
				
			}
		});

		}
	},

	sendMessage:function(msg) {
		if(activeGroup != 0) {
			var id_chat = activeGroup;

			$.ajax({
				url: BASE_URL+'/insertMessage.php',
				method: 'POST',
				data: {id_chat: id_chat, msg: msg},
				dataType: 'json',
				success:function() {

				}
			})
		}
	},

	sendPhoto:function(img){
		if(activeGroup != 0) {
			var body = new FormData();
			body.append('id_chat', activeGroup);
			body.append('image', img);

			$.ajax({
				url: BASE_URL+'/insertPhoto.php',
				method: 'POST',
				data: body,
				dataType: 'json',
				contentType: false,
				processData: false,
				success:function() {

				}
			})
		}
	},

	updateLastTime:function(last_time) {
		 lastTime = last_time
	},

	insertMessages:function(item) {

		for(let i in groups) {
			if(item.id_chat == groups[i].id) {
				groups[i].msgsLive.push({
					nick: item.user_nick,
					body: item.msg,
					id_user: item.id_user,
					id: item.id,
					sender_date: item.date_msg,
					msg_type: item.msg_type,
				});	

				var htmlMsgs = '';

				if(groups[i].msgsLive[0].msg_type == 'text') {

					if(groups[i].msgsLive[0].id_user == user_infos.id) {
							htmlMsgs += '<li class="message-item message-sent">'
							htmlMsgs += '<span class="message-item-name ">'+groups[i].msgsLive[0].nick+'</span>'
							htmlMsgs += '<span class="message-item-body">'+groups[i].msgsLive[0].body+'</span>'
							htmlMsgs += '</li>';
						} else {
							htmlMsgs += '<li class="message-item message-received">'
							htmlMsgs += '<span class="message-item-name ">'+groups[i].msgsLive[0].nick+'</span>'
							htmlMsgs += '<span class="message-item-body">'+groups[i].msgsLive[0].body+'</span>'
							htmlMsgs += '</li>';
					}
				} else if (groups[i].msgsLive[0].msg_type == 'image'){
					if(groups[i].msgsLive[0].id_user == user_infos.id) {
							htmlMsgs += '<li class="message-item image-message message-sent">'
							htmlMsgs += '<span class="message-item-name ">'+groups[i].msgsLive[0].nick+'</span>'
							htmlMsgs += '<img  src="'+BASE_URL+'/media/images/'+groups[i].msgsLive[0].body+'">';
							htmlMsgs += '</li>';
						} else {
							htmlMsgs += '<li class="message-item image-message message-received ">'
							htmlMsgs += '<span class="message-item-name ">'+groups[i].msgsLive[0].nick+'</span>'
							htmlMsgs += '<img  src="'+BASE_URL+'/media/images/'+groups[i].msgsLive[0].body+'">'
							htmlMsgs += '</li>';
					}
				}

				$('.messages-list').prepend(htmlMsgs);
				groups[i].msgsLive = [];			
			}
		}
	},

	chatActivity:function() {

		if(groups.length > 0) {
			$.ajax({
				url: BASE_URL+'/getMessagesInRealTime.php',
				method: 'GET',
				data:{lastTime: lastTime},
				dataType: 'json',
				success:function(json) {
					if(json.status == '1') {
						chat.updateLastTime(json.lastTime);

						for(var i in json.msgs) {
							chat.insertMessages(json.msgs[i]);
						}
					}
				},
				complete:function(){
					chat.chatActivity();
				} 
			});
		} else {
			setTimeout(function(){
				chat.chatActivity()
			}, 1000);
		}
		
	},

	getGroupActiveInfos:function() {
		if(activeGroup != 0) {
			$.ajax({
				url: BASE_URL+'/getInfosOfActiveGroup.php',
				method: 'POST',
				data:{id_chat: activeGroup},
				dataType: 'json',
				success:function(json) {

					console.log(json)
					var htmlHeader = '';
					htmlHeader += '<img src="'+BASE_URL+'/media/avatars/'+ json.infoschat.avatar+'">';
					htmlHeader += '<span class="aside-right-header-name">'+json.infoschat.name+'</span>';

					$('.aside-right-header').html(htmlHeader);

					$('.aside-right-body').html('');

					var date = json.infoschat.created_at.split(' ');
					date = date[0].split('-');
					date = date[2]+'/'+date[1]+'/'+date[0]

					html = '';
					html += '<h4>Criado em:</h4>';
					html += '<div class="aside-right-header-content">'+date+'</div>'
					html += '<h4>Criado por:</h4>';
					html += '<div class="aside-right-header-content">';
					html += json.author.nick
					html += '</div>';

					$('.members-option').removeClass('info-option-selected');
					$('.info-option').addClass('info-option-selected');
					$('.aside-right-body').html(html);

				}
			});
		}
	},

	getGroupActiveUsers:function() {
		if(activeGroup != 0) {
			$.ajax({
				url: BASE_URL+'/getInfosOfActiveGroup.php',
				method: 'POST',
				data:{id_chat: activeGroup},
				dataType: 'json',
				success:function(json) {

					var htmlHeader = '';

					htmlHeader += '<img src="'+BASE_URL+'/media/avatars/'+ json.infoschat.avatar+'">';
					htmlHeader += '<span class="aside-right-header-name">'+json.infoschat.name+'</span>';

					$('.aside-right-header').html(htmlHeader);

					$('.aside-right-body').html('');

					html = '';
					html += '<ul class="members-list">'
					for(let i in json.users) {
						html += '<li class="member-item">'
						html += '<img src="'+BASE_URL+'/media/avatars/'+ json.users[i].avatar+'">';
						html += '<span class="member-name">'+json.users[i].nick+'</span>';
						html += '</li>'
					}
					html += '</ul>'
					
					$('.info-option').removeClass('info-option-selected');
					$('.members-option').addClass('info-option-selected');
					$('.aside-right-body').html(html);

				}
			});
		}
	},
	removeRelation:function() {
		if(activeGroup != 0) {
			var id_chat = activeGroup;
			$.ajax({
				url: BASE_URL+'/removeRelation.php',
				method: 'POST',
				data:{id_chat: activeGroup},
				dataType: 'json',
				success:function(json) {
					activeGroup = 0;
					$('.container-right').html('');
					window.location.href = BASE_URL+'/home.php';
				}
			});
		}
	}

}

