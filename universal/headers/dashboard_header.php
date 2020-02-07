<?php
	include('header.php');
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
	if(empty($_SESSION['user_id'])){ header('location:/agungelektrindo/codes/logout'); }
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
<div class='sidenav'>	
	<button class='dropdown_button'>Departments</button>
	<div class="dropdown-container">
<?php
		$sql_super 			= "SELECT authorization.department_id, departments.department FROM authorization
								JOIN departments ON authorization.department_id = departments.id
								WHERE authorization.user_id = '" . $user_id . "' ORDER BY departments.department";
		$result_super 		= $conn->query($sql_super);
		while($row_super 	= $result_super->fetch_assoc()){
			$department 	= $row_super['department_id'];
			$department 	= strtolower($row_super['department']);
			
?>
		<a href='/agungelektrindo/<?= $department ?>' style='color:white;text-decoration:none'><button>
			<?php $department_name = ($department == 'human_resource')? 'Human resource' : $department; echo ucwords($department_name); ?>
		</button></a>
		<br>
<?php
		}
?>
	</div>
	<a href='/agungelektrindo/guide/tutorial'><button>Read Tutorial</button></a>
<?php
	if($role				== 'superadmin'){
?>
	<a href='/agungelektrindo/administrator'><button>Administrator</button></a>
<?php
	}
?>
	<a href='/agungelektrindo' style='text-decoration:none'><button><i class="fa fa-eercast" aria-hidden="true"></i>Account</button></a>
</div>
<div class='sidenav_small'></div>
<script>
	$('.dropdown_button').click(function(){
		$('.dropdown-container').hide();
		$('button').removeClass('active');
		$(this).addClass('active');
		$(this).next().toggle(350);
	});
	
	
	$('#hide_side_button').click(function(){
		$('.sidenav').toggle(200);
		$('#expand_side_button').fadeIn();
		$('#hide_side_button').hide();
		setTimeout(function(){	
			$('.main').animate({
				'margin-left':'50px'
			},200);
			
			$('.sidenav_small').toggle(200);
		},200);
	});

	$('#expand_side_button').click(function(){
		$('.sidenav_small').toggle(200);
		$('#expand_side_button').hide();
		$('#hide_side_button').fadeIn();
		setTimeout(function(){		
			$('.sidenav').toggle(200);
			$('.main').animate({
				'margin-left':'200px'
			},200);
		},200);
	});
</script>