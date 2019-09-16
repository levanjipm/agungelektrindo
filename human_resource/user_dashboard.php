<head>
	<title>Account Control</title>
	<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
	<script src='../universal/jquery/typeahead.bundle.js'></script>
	<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src='../jquery-ui.js'></script>
	<link rel='stylesheet' href='../jquery-ui.css'>
	<link rel="stylesheet" href="user_dashboard.css">
</head>
<body>
<?php
	include('../Codes/connect.php');
	session_start();
	
	$animation = $_GET['style'] ?? "";
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
	$profile_pic	= $row_user['image_url'];
	
	if($profile_pic == ''){
		$profile_pic = 'images/users/users.png';
	}
	if($_SESSION['user_id'] === NULL){
		header('location:../landing_page.php');
	}
	//Apabila pertama kali buka dari login, tampilkan animasi//
	if($animation == 'animate'){
?>
	<div class='welcome_wrapper'>
		<div class='welcome'>
			<h2 style='font-family:bebasneue;color:white'>Welcome <?= $name ?></h2>
		</div>
	</div>
	<script>
		function show_menu_user(){
			$('.dropdown-content').show();
		}
		function close_menu_user(){
			$('.dropdown-content').hide();
		}
		$(document).ready(function(){
			setTimeout(function() {
			$('.welcome_wrapper').fadeOut(500);
			},1500);
		});
		$(document).ready(function(){
			setTimeout(function() {
			$('#dept').fadeIn(500);
			},2000);
		});
	</script>
<?php
	} else {
?>
	<script>
	function show_menu_user(){
		$('.dropdown-content').show();
	}
	function close_menu_user(){
		$('.dropdown-content').hide();
	}
	$(document).ready(function(){
		$('#dept').fadeIn(1000);
	});
</script>
<?php
	}
?>
<div class='top_navigation_bar'>
	<div class='col-lg-4 col-md-5 col-sm-6 col-xs-8'>
		<a href='../human_resource/user_dashboard.php' style='text-decoration:none'>
			<img src='../universal/images/agungelektrindo_header.png' style='height:50px;'>
		</a>
	</div>
	<div class='col-lg-2 col-md-3 col-sm-4 col-xs-4 col-lg-offset-6 col-md-offset-4 col-sm-offset-2 col-xs-offset-0' style='text-align:right'>
		<h3 style='font-family:Bebasneue'><?= $name ?> 
			<span style='display:inline-block'>
				<a href='../codes/logout.php' style='padding-left:10px;text-decoration:none;color:white;' title='log out'>
					 <i class="fa fa-sign-out" aria-hidden="true"></i>
				</a>
			</span>
		</h3>
	</div>
</div>
<div class="sidenav">		
	<button type='button' class='btn-badge' style='text-align:right' id='hide_side_button'>
		<i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i>
	</button>		
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-id-badge" aria-hidden="true"></i>
		Departments
	</button>
	<div class="dropdown-container">
<?php
		$sql_super 		= "SELECT * FROM authorization WHERE user_id = '" . $user_id . "'";
		$result_super 	= $conn->query($sql_super);
		while($row_super 	= $result_super->fetch_assoc()){
			$department 	= $row_super['department_id'];
			$sql_dept 		= "SELECT department FROM departments WHERE id = '" . $department . "'";
			$result_dept 	= $conn->query($sql_dept);
			$row_dept 		= $result_dept->fetch_assoc();
			$department 	= $row_dept['department'];
			
?>
		<a href='../<?= $department ?>/<?= $department ?>' style='color:white;text-decoration:none'>
			<?php $department_name = ($department == 'human_resource')? 'Human resource' : $department; echo $department_name; ?>
		</a>
		<br>
<?php
			}
?>
	</div>
	<a href='../guide/tutorial.php'>
		<button type='button' class='btn-badge' style='color:white'>
		<i class="fa fa-graduation-cap" aria-hidden="true"></i>
		Read Tutorial
		</button>
	</a>
</div>
<div class='sidenav_small'>
	<i class="fa fa-bars" aria-hidden="true"></i>
</div>
<script>
$('.dropdown-btn').click(function(){
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
<div class='notification_large' id='announcement_notification'>
	<div class='notification_box'>
		<h2 style='font-family:bebasneue'>Create new Announcement</h2>
		<label>Date</label>
		<input type='date' class='form-control' name='announcement_date' min='<?= date('Y-m-d') ?>'>
		<label>Event name</label>
		<input type='text' class='form-control' name='event' required>
		<br>
		<button type='button' class='btn-back'>Back</button>
		<button type='button' class='btn-confirm' id='confirm_button_announcement'>Confirm</button>
	</div>
</div>
<div class='main' id='dept' style='display:none'>
	<div class='row'>
		<div class='col-md-4 col-sm-6 col-xs-10 col-md-offset-0 col-sm-offset-0 col-xs-offset-1' style='text-align:center;border-right:2px solid #333'>
			<img src='<?= $profile_pic ?>' style='width:100%;max-width:150px;border-radius:50%'>
			<h3 style='font-family:Bebasneue'><?= $name ?></h3>
			<h4 style='font-family:bebasneue'>Profile Information</h4>
			<div style='text-align:left'>
				<label>Name</label>
				<p><?= $name ?></p>
				<label>NIK</label>
				<p><?= $nik ?></p>
				<label>E-mail</label>
				<p><?= $email ?></p>
				<label>Username</label>
				<p><?= $username ?></p>
			</div>
			<a href='edit_user_dashboard.php'>
				<button class='button_default_dark'>Edit profile</button>
			</a>
		</div>
		<div class='col-md-8 col-sm-6 col-xs-12 col-md-offset-0 col-sm-offset-0 col-xs-offset-0' style='position:relative'>
			<div class='button_wrapper'>
				<button type='button' class='button_default_light active_button' id='news_button'>
					News
				</button>
				<button type='button' class='button_default_light' id='salary_button'>
					Salary Slip
				</button>
<?php
	if($privilege == 1){
?>
				<button type='button' class='button_default_light' id='att_list_button'>
					Att. List
				</button>
<?php
	}
?>
			</div>
			<div id='menu_wrapper'>
			</div>
		</div>
	</div>
</div>
<style>
	#create_news_wrapper{
		width:100%;
		height:100%;
		background-color:rgba(30,30,30,0.8);
		display:none;
		position:fixed;
		top:0;
		z-index:100;
	}
	
	#create_news_box{
		width:80%;
		height:80%;
		background-color:white;
		z-index:120;
		position:absolute;
		top:10%;
		left:10%;
		padding:40px;
	}
	
	#close_news_wrapper_button{
		position:fixed;
		top:10%;
		left:10%;
		z-index:125;
		color:#333;
		background-color:transparent;
		border:none;
		outline:none;
	}
</style>
<div id='create_news_wrapper'>
	<button type='button' id='close_news_wrapper_button'>X</button>
	<div id='create_news_box'>
		<h2 style='font-family:bebasneue'>Create a news</h2>
		<form id='create_news_form'>
			<label>Date</label>
			<input type='date' class='form-control' id='news_date'>
			<label>Subject</label>
			<input type='text' class='form-control' id='news_subject'>
			<label>Other description</label>
			<textarea class='form-control' style='resize:none' id='news_description'></textarea>
			<br>
			<button type='button' class='button_default_dark' id='add_news_button'>Submit</button>
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
		$.ajax({
			url:'news_section.php',
			success:function(response){
				$('#menu_wrapper').html(response)
			}
		});
	});
	
	$('#news_button').click(function(){
		$('.active_button').removeClass('active_button');
		$(this).addClass('active_button');
		$.ajax({
			url:'news_section.php',
			success:function(response){
				$('#menu_wrapper').html(response)
			}
		});
	})
	
	$('#salary_button').click(function(){
		$('.active_button').removeClass('active_button');
		$(this).addClass('active_button');
		$.ajax({
			url:'salary_section.php',
			success:function(response){
				$('#menu_wrapper').html(response)
			}
		});
	})
	
	$('#att_list_button').click(function(){
		$('.active_button').removeClass('active_button');
		$(this).addClass('active_button');
		$.ajax({
			url:'calendar_absent.php',
			success:function(response){
				$('#menu_wrapper').html(response);
			}
		});
	});
	
	$('#add_news_button').click(function(){
		if($('#news_date').val() == ''){
			alert('Please inset a date');
			$('#news_date').focus();
			return false;
		} else if($('#news_subject').val() == ''){
			alert('Please insert a subject');
			$('#news_subject').focus();
			return false;
		} else {
			$.ajax({
				url:'create_announcement.php',
				data:{
					subject: $('#news_subject').val(),
					date: $('#news_date').val(),
					description: $('#news_description').val(),
					created_by: <?= $user_id ?>,
				},
				beforeSend:function(){
					$('#add_news_button').attr('disabled',true);
				},
				success:function(){
					$('#add_news_button').attr('disabled',false);
					$('#close_news_wrapper_button').click();
					$('#news_button').click();
				},
				type:'POST',
			})
		}
	});		
</script>