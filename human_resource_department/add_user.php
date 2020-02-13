<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/human_resource_header.php');
?>	
<head>
	<title>Add user</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>User</h2>
	<p>Add user</p>
	<hr>
	<div class='row'>
		<div class='col-md-9 col-sm-6 col-xs-10 col-sm-offset-0 col-xs-offset-1'>
			<form action='add_user_input' method='POST' id='add_user_form'>
				<label>Full Name</label>
				<input type='text' class='form-control' name='name'>
				
				<label>NIK</label>
				<input type='number' class='form-control' name='nik'>
				
				<label>Email Address</label>
				<input type='text' class='form-control' name='email'>
				
				<label>User name</label>
				<input type='text' class='form-control' name='username'>
				
				<label>Address</label>
				<textarea class='form-control' style='resize:none' name='address'></textarea>
				
				<label>City</label>
				<input type='text' class='form-control' name='city'>
				
				<label>Bank Account Number</label>
				<input type='text' class='form-control' name='bank_account'>
				
				<label>Gender</label>
				<select class='form-control' name='gender'>
					<option value='1'>Male</option>
					<option value='2'>Female</option>
				</select>
				
				<label>Password</label>
				<input type='password' class='form-control' name='raw_password'>
			</form>
			<br>
			<button type='button' class='button_default_dark' id='add_user_button'>Next</button>
		</div>
	</div>
</div>
<script>
	$('#add_user_button').click(function(){
		var valid_input = true;
		$('input').each(function(){
			if($(this).val() == ''){
				valid_input = false;
				alert('Please input required field');
				$(this).focus();
				return false;
			}
		});
		
		if(valid_input == true){
			$('#add_user_form').submit();
		}
	});
</script>