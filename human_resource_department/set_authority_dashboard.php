<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/human_resource_header.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>User</h2>
	<p>Set authority</p>
	<hr>
	<label>User</label>
	<select class='form-control' id='user_id'>
		<option value='0'>-- Please select a user</option>
<?php
	$sql		= "SELECT id, name FROM users WHERE isactive = '1' ORDER BY name ASC";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
?>
		<option value='<?= $row['id'] ?>'><?= $row['name'] ?></option>
<?php
	}
?>
	</select>
	<br>
	<button type='button' class='button_success_dark' id='edit_button'>Edit</button>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	$('#edit_button').click(function(){
		if($('#user_id').val() == 0){
			alert('Please insert a user');
			$('#user_id').focus();
			return false;
		} else {
			$.ajax({
				url		: 'set_authority_view.php',
				data	: {
					user_id	: $('#user_id').val(),
				},
				type	: 'POST',
				beforeSend:function(){
					$('#edit_button').html('<i class="fa fa-spin fa-spinner" aria-hidden="true"></i>');
				},
				success:function(response){
					$('#edit_button').html('Edit');
					$('.full_screen_box').html(response);
					$('.full_screen_wrapper').fadeIn();
				}
			});
		};
	});
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_box').html('');
		$('.full_screen_wrapper').fadeOut();
	});
	
	function add_auth(user,department){
		$.ajax({
			url		: 'add_authority.php',
			data	: {
				user: user,
				dept: department,
			},
			type	: 'POST',
			beforeSend:function(){
				$('#del_auth_button').attr('disabled',true);
			},
			success:function(response){
				$('#del_auth_button').attr('disabled',false);
				if(response == 1){
					$('#del_auth_button').removeClass('button_success_dark').addClass('button_danger_dark');
				}
			},
		})
	};
	
	function delete_auth(user,department){
		$.ajax({
			url		: 'delete_authority.php',
			data	: {
				user: user,
				dept: department,
			},
			type	: 'POST',
			beforeSend:function(){
				$('#add_auth_button').attr('disabled',true);
			},
			success:function(response){
				if(response == 1){
					$('#add_auth_button').attr('disabled',false);
					$('#add_auth_button').removeClass('button_success_dark').addClass('button_danger_dark');
				}
			},
		})
	};
</script>