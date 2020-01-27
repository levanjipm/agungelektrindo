<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	session_start();
	$user_id			= $_SESSION['user_id'];
	$sql				= "SELECT * FROM users WHERE id = '$user_id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	$user_name			= $row['name'];
	$user_address		= $row['address'];
	$user_city			= $row['city'];
	$user_nik			= $row['NIK'];
	$user_image_url		= '/agungelektrindo/dashboard/' . $row['image_url'];
	$user_role			= $row['role'];
	$user_mail			= $row['mail'];
	$user_uname			= $row['username'];
?>
	<div class='row'>
		<div class='col-sm-3' style='text-align:center'>
			<img src='<?= $user_image_url ?>' style='width:100%;max-width:150px;border-radius:50%;'>
			<h3 style='font-family:museo'><?= $user_name ?></h3>
			<p style='font-family:museo'><?= $user_role ?></p>
		</div>
		<div class='col-sm-9'>
			<h3 style='font-family:museo'>General data</h3>
			<label>NIK</label>
			<p style='font-family:museo'><?= $user_nik ?></p>
			<label>Email</label>
			<p style='font-family:museo'><?= $user_mail ?></p>
			<label>Username</label>
			<p style='font-family:museo'><?= $user_uname ?></p>
			<label>Address</label>
			<p style='font-family:museo'><?= $user_address . " " . $user_city ?></p>
			<a href='/agungelektrindo/dashboard/profile_edit_dashboard'>
				<button class='button_success_dark'>Edit data</button>
			</a>
		</div>
	</div>