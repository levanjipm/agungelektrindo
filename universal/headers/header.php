<?php
	include('head.php');
	session_start();
?>
<style>	
	#hide_side_button{
		text-align:center;
		display:inline-block;
		text-align:center;
		font-size:2em;
		padding:10px;
		margin-right:10px;
		padding-bottom:0;
	}
	
	#expand_side_button{
		text-align:center;
		display:inline-block;
		text-align:center;
		font-size:2em;
		padding:10px;
		margin-right:10px;
	}
	
	#profile_top_nav_button{
		float:right;
	}
	
	.profile_option_wrapper{
		position:fixed;
		top:90px;
		width:250px;
		right:20px;
		z-index:50;
		background-color:#326d96;
		display:none;
		padding:10px;
		color:white;
	}
	
	.profile_option_wrapper a{
		color:white;
		text-decoration:none;
	}
	
	.profile_option_wrapper::after {
		border-left: 20px solid transparent;
		border-bottom: 20px solid #326d96;
		top: -20px;
		content: "";
		position: absolute;
		right: 20px;
	}
</style>
<?php
	$sql_user 			= "SELECT isactive,name,role,hpp FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user 		= $conn->query($sql_user);
	$row_user 			= $result_user->fetch_assoc();
	$name 				= $row_user['name'];
	$role 				= $row_user['role'];
	$hpp 				= $row_user['hpp'];
	$isactive 			= $row_user['isactive'];
	if (empty($_SESSION['user_id']) && $isactive != 1) {
?>
	<script>
		window.location.href='/agungelektrindo/codes/logout';
	</script>
<?php
	}
?>
<body>
<div class='loading_wrapper_initial'>
	<div class='loading_wrapper'>
		<h2 style='font-size:8em'><i class='fa fa-circle-o-notch fa-spin'></i></h2>
	</div>
</div>
<script>
	$( window ).on( "load", function() {
		$('.loading_wrapper_initial').show;
	});
	
	$(document).ready(function(){
		$('.loading_wrapper_initial').fadeOut(450);
		$('.main').fadeIn(450);
	});
</script>
<div class='top_navigation_bar'>
		<button id='hide_side_button'><i class='fa fa-bars'></i></button>
		<button id='expand_side_button' style='display:none'><i class='fa fa-expand'></i></button>
		<a href='/agungelektrindo' style='text-decoration:none;color:white;display:inline-block'>
			<h2 style='font-family:bebasneue'>AgungElektrindo</h2>
		</a>
		<button type='button' id='profile_top_nav_button'><h2 style='font-family:Bebasneue'>Welcome, <span style='color:#afdfe6'><?= $name ?></span></h2></button>
	</div>
</div>
<div class='profile_option_wrapper'>
<?php	if($role	== 'superadmin' || $role == 'admin'){ ?>
	<a href='/dutasaptaenergi'><p style='font-family:museo'>Duta Sapta</p></a>
	<hr style='margin:10px 0px;'>
<?php } ?>
	<a href='/agungelektrindo/codes/logout'><p style='font-family:museo'>Logout</p></a>
</div>
<script>
	$('#profile_top_nav_button').click(function(){
		$('.profile_option_wrapper').toggle(300);
	});
</script>