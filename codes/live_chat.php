<style>
	.chat_wrapper{
		cursor:pointer;
		min-width:250px;
		text-align:center;
		border-radius:3px 3px 0px 0px;
		z-index:1000;
		display:inline-block;
		padding:5px 10px;
	}
	.chat_list_wrapper{
		min-width:250px;
		background-color:white;
		position:fixed;
		right:0;
		z-index:995;
		border:1px solid #eee;
		display:none;
		min-height:300px;
		text-align:center;
	}
	.chat_name_footer{
		bottom:0;
		position;fixed;
	}
	.btn-chat{
		width:80%;
		background-color:transparent;
		outline:none;
		padding:3px 3px;
		border:none;
		border-bottom:1px solid #eee;
	}
	#chat_dialog_wrapper{
		position:fixed;
		bottom:0;
		right:0;
	}
	#chat_open_people{
		position:fixed;
		bottom:0;
	}
	#chat_open_initial{
		background-color:rgba(109, 152, 222,1);
	}
	.btn-x{
		background-color:transparent;
		border:none;
	}
	.chat_people_button{
		background-color:white;
		border:1px solid #eee;
	}
	.chat_wrapper_people{
		position:fixed;
		z-index:950;
		background-color:white;
		border:1px solid #333;
		height:300px;
		width:250px;
	}
</style>
<div id='chat_dialog_wrapper'>
	<div class='chat_wrapper' id='chat_open_initial'>
		Chat
	</div>
</div>
<div id='chat_open_people'></div>
<div class='chat_list_wrapper' id='chat_list_initial'>
<?php
	$sql_other_user = "SELECT * FROM users WHERE id <> '" . $_SESSION['user_id'] . "'";
	$result_other_user = $conn->query($sql_other_user);
	while($other_user = $result_other_user->fetch_assoc()){
?>
	<button type='button' class='btn-chat' id='<?= $other_user['id'] ?>'><?= $other_user['name'] ?></button><br>
<?php
	}
?>
</div>
<script>
	var chat_wrapper_height = $('#chat_open_initial').height() + 10;
	var chat_wrapper_position = $('#chat_open_initial').position().right;
	var chat_wrapper_width = $('#chat_open_initial').outerWidth();
	$('#chat_open_people').css('right',chat_wrapper_width);
	$('.chat_list_wrapper').css('bottom',chat_wrapper_height);
	$('#chat_open_initial').click(function(){
		$('#chat_list_initial').toggle();
	});
	$('.btn-chat').click(function(){
		$('.chat_list_wrapper').toggle();
		var user_to_chat_id = $(this).attr('id');
		var user_to_chat_name = $(this).text();
		$('#chat_open_people').append(
			'<div class="chat_wrapper chat_people_button" onclick="chat_people(' + user_to_chat_id + ')" id="chat-' + user_to_chat_id + '">' + user_to_chat_name +
			'<button type="button" class="btn-x">X</button></div>'+
			'<div class="chat_wrapper_people" id="chat_list-' + user_to_chat_id + '"></div>'
		);
	});
	function chat_people(n){
		$.ajax({
			url:'../codes/view_chat.php',
			data:{
				sender:<?= $_SESSION['user_id'] ?>,
				receiver: n
			},
			type:'GET',
			success:function(response){
				$('#chat_list-' + n).html(response);
			},
		});
		$('.chat_wrapper_people').hide();
		var chat_position = $('#chat-' + n).position().right;
		$('#chat_list-' + n).css('right',chat_position);
		$('#chat_list-' + n).css('bottom',chat_wrapper_height);
		$('#chat_list-' + n).show();
	};
</script>