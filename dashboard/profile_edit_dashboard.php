<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/dashboard_header.php');
	$user_id			= $_SESSION['user_id'];
	$mail 				= $row_user['mail'];
	$name 				= $row_user['name'];
	$bank 				= $row_user['bank'];
	$address 			= $row_user['address'];
	$city 				= $row_user['city'];
	$user_name			= $row_user['username'];
	$profile_pic		= $row_user['image_url'];
	
	if($profile_pic == ''){
		$profile_pic = $_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/dashboard/images/users/users.png';
	} else {
		$profile_pic	= $row_user['image_url'];
	}
?>
<style>
	#profile_picture_input{
		width:0;
		height:0;
	}
	
	#profile_picture_button{
		text-align:center;
		width:100%;
		max-width:250px;
		cursor:pointer;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Profile data</h2>
	<p style='font-family:museo'>Edit profile</p>
	<hr>
	<div class='col-sm-4 col-xs-4 col-sm-offset-1 col-xs-offset-4' style='text-align:center'>
		<img src='<?= $profile_pic ?>' style='width:100%;max-width:150px;border-radius:50%' id='profile_picture_image'>
		<br><br>
		<label class='button_default_dark' id='profile_picture_button'>
			<input type='file' name='profile_picture' id='profile_picture_input' accept="image/x-png,image/gif,image/jpeg">
			Upload Image
		</label>
	</div>
	<div class='col-sm-6 col-xs-10 col-sm-offset-0 col-xs-offset-1'>
		<form id='edit_user_form'>
			<h3 style='font-family:bebasneue'>Profile Information</h3>
			<label>Email</label>
			<input type='text' class='form-control' id='email' value='<?= $mail ?>'>
			<label>Address</label>
			<textarea class='form-control' style='resize:none' id='address'><?= $address ?></textarea>
			<label>City</label>
			<input type='text' class='form-control' id='city' value='<?= $city ?>'>
			<label>Bank</label>
			<input type='text' class='form-control' id='bank' value='<?= $bank ?>'>
			<label>Password</label>
			<input type='password' class='form-control' id='password'>
		</form>
		<br>
		<button type='button' class='button_success_dark' id='submit_profile_button'>Submit</button>
	</div>
</div>
<script>
	$('#profile_picture_input').change(function(){
		formdata = new FormData();
		if($(this).prop('files').length > 0){
			file =$(this).prop('files')[0];
			formdata.append('<?= $user_id ?>', file);
			$.ajax({
				url: 'profile_picture_change.php',
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function (result) {
					$('#profile_picture_image').attr('src',result);
				}
			})
		}
	});
	
	$('#submit_profile_button').click(function(){
		var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
		var email = $('#email').val();
		
		if(!pattern.test(email)){
			alert('Please insert a valid email');
			return false;
		} else {
			$.ajax({
				url:'edit_profile.php',
				data:{
					email: $('#email').val(),
					address: $('#address').val(),
					city: $('#city').val(),
					bank: $('#bank').val(),
					password: $('#password').val(),
				},
				type:'POST',
			});
		}
	});
</script>