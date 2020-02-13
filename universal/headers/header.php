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
	
	.profile_option_wrapper table{
		width:100%;
		text-align:left
		vertical-align: bottom;
	}
	
	.profile_option_wrapper table td{
		padding:5px!important;
	}
	
	.profile_option_wrapper::after {
		border-left: 20px solid transparent;
		border-bottom: 20px solid #326d96;
		top: -20px;
		content: "";
		position: absolute;
		right: 20px;
	
	@media only screen and (min-width: 576px){
		#home_button{
			display:inline-block;
		}
		
		#hide_side_button{
			display:inline-block;
		}
		
		#expand_side_button{
			display:none;
		}
	}
	
	@media only screen and (max-width: 576px){
		#home_button{
			display:none!important;
		}
		
		#hide_side_button{
			display:none;
		}
		
		#expand_side_button{
			display:inline-block;
		}
	}
</style>
<?php
	$sql_user 			= "SELECT * FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user 		= $conn->query($sql_user);
	$row_user 			= $result_user->fetch_assoc();
	$name 				= $row_user['name'];
	$role 				= $row_user['role'];
	$hpp 				= $row_user['hpp'];
	$isactive 			= $row_user['isactive'];
	$user_image_url		= '/agungelektrindo/dashboard/' . $row_user['image_url'];
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
	<a href='/agungelektrindo' style='text-decoration:none;color:white;display:inline-block' id='home_button'>
		<h2 style='font-family:bebasneue'>AgungElektrindo</h2>
	</a>
	<button type='button' id='profile_top_nav_button'><h2 style='font-family:Bebasneue'>Welcome, <span style='color:#afdfe6'><?= $name ?></span></h2></button>
</div>
<div class='profile_option_wrapper'>
	<table>
<?php	if($role	== 'superadmin' || $role == 'admin'){ ?>
		<tr onclick="location.href='/dutasaptaenergi'" style='width:50px;cursor:pointer'>
			<td></td>
			<td>Duta Sapta</td>
		</tr>
<?php } ?>
		<tr onclick="location.href='/agungelektrindo/dashboard/user_profile'" style='width:50px;cursor:pointer'>
			<td style='text-align:center!important' valign="bottom"><i class='fa fa-user'></i></td>
			<td valign="bottom">View profile</td>
		</tr>
		<tr onclick="location.href='/agungelektrindo/codes/logout'" style='width:50px;cursor:pointer'>
			<td style='text-align:center!important'><i class='fa fa-sign-out' valign="bottom"></i></td>
			<td valign="bottom">Logout</a>
		</tr>
	</table>
</div>
<script>
	$('#profile_top_nav_button').click(function(){
		$('.profile_option_wrapper').toggle(300);
	});
</script>