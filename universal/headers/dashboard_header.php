<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	ini_set('date.timezone', 'Asia/Jakarta');
	
	$sql_user 		= "SELECT * FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user 	= $conn->query($sql_user);
	$row_user 		= $result_user->fetch_assoc();
	$user_id 		= $row_user['id'];
	$username 		= $row_user['username'];
	$name 			= $row_user['name'];
	$role 			= $row_user['role'];
	$email 			= $row_user['mail'];
	$nik 			= $row_user['NIK'];
	$username		= $row_user['username'];
	$address		= $row_user['address'];
	$city			= $row_user['city'];
	
	$privilege 		= $row_user['privilege'];
	$profile_pic	= $_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/human_resource/' . $row_user['image_url'];
	
	if($profile_pic == ''){
		$profile_pic = $_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/human_resource/images/users/users.png';
	}
	if($_SESSION['user_id'] === NULL){ header('location:../landing_page.php'); }
?>
	<script>
		$(document).ready(function(){
			setTimeout(function(){
				$('.main').fadeIn(500);
			},500);
		});
	</script>
<head>
	<link rel='stylesheet' href='/agungelektrindo/dashboard/style.css'>
	<title>User dashboard</title>
</head>
<div class="sidenav">		
	<button type='button' style='text-align:right' id='hide_side_button'>
		<i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i>
	</button>		
	<button>Departments</button>
	<div class="dropdown-container">
<?php
		$sql_super 		= "SELECT * FROM authorization WHERE user_id = '" . $user_id . "'";
		$result_super 	= $conn->query($sql_super);
		while($row_super 	= $result_super->fetch_assoc()){
			$department 	= $row_super['department_id'];
			$sql_dept 		= "SELECT department FROM departments WHERE id = '" . $department . "'";
			$result_dept 	= $conn->query($sql_dept);
			$row_dept 		= $result_dept->fetch_assoc();
			$department 	= strtolower($row_dept['department']);
			
?>
		<a href='/agungelektrindo/<?= $department ?>' style='color:white;text-decoration:none'>
			<?php $department_name = ($department == 'human_resource')? 'Human resource' : $department; echo ucwords($department_name); ?>
		</a>
		<br>
<?php
			}
?>
	</div>
	<a href='/agungelektrindo/guide/tutorial'>
		<button>Read Tutorial</button>
	</a>
	<a href='/agungelektrindo/dashboard/user_dashboard' style='text-decoration:none'>
		<button><i class="fa fa-eercast" aria-hidden="true"></i>Account</button>
	</a>
</div>
<div class='sidenav_small'><i class="fa fa-bars" aria-hidden="true"></i></div>
<script>
$('.sidenav button').click(function(){
	if($(this).next().is(':visible')){
		$(this).css('color','white');
	} else {
		$(this).css('color','#00ccff');
	}
	$(this).next().toggle(350);
});

$('#hide_side_button').click(function(){
	$('.sidenav').toggle(200);
	$('#show_side_button').fadeIn();
	setTimeout(function(){	
		$('.main').animate({
			'margin-left':'50px'
		},200);
		
		$('.sidenav_small').toggle(200);
	},200);
});

$('.sidenav_small').click(function(){
	$('.sidenav_small').toggle(200);
	$('#show_side_button').hide();
	setTimeout(function(){		
		$('.sidenav').toggle(200);
		$('.main').animate({
			'margin-left':'200px'
		},200);
	},200);
});
</script>