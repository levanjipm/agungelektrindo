<?php
	include('hrheader.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>User</h2>
	<p>Set authority</p>
	<hr>
	<label>User</label>
	<select class='form-control' id='user_id'>
		<option value='0'>-- Please select a user</option>
<?php
	$sql		= "SELECT * FROM users WHERE isactive = '1' ORDER BY name ASC";
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
<style>
	.view_wrapper{
		width:100%;
		height:100%;
		background-color:rgba(25,25,25,0.8);
		position:fixed;
		top:0;
		left:0;
		z-index:50;
		display:none;
	}
	
	.view_box{
		width:80%;
		height:80%;
		position:absolute;
		top:10%;
		left:10%;
		background-color:white;
		overflow-y:scroll;
		padding:10px;
	}
	
	.button_close_view{
		position:fixed;
		top:10%;
		left:10%;
		border:none;
		outline:none!important;
		color:#333;
		z-index:55;
		background-color:transparent;
	}
</style>
<div class='view_wrapper'>
	<button class='button_close_view'>&times</button>
	<div class='view_box'>
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
					$('.view_box').html(response);
					$('.view_wrapper').fadeIn();
				}
			});
		};
	});
	
	$('.button_close_view').click(function(){
		$('.view_box').html('');
		$('.view_wrapper').fadeOut();
	});
</script>