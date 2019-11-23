<head>
	<title>Financial Department</title>
	<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
	<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<link rel="stylesheet" href="financialstyle.css">
<?php
	include("../codes/connect.php");
	session_start();
	if($_SESSION['user_id'] == NULL){
		header('location:../landing_page.php');
	}
	
	$sql_user 		= "SELECT name,role FROM users WHERE id = " . $_SESSION['user_id'];
	$result_user 	= $conn->query($sql_user);
	$row_user 		= $result_user->fetch_assoc();
	$role 			= $row_user['role'];
	$user_name 		= $row_user['name'];
	if(mysqli_num_rows($result_user) == 0){
		header('location:../landing_page.php');
	}
	$sql_otorisasi = "SELECT * FROM authorization WHERE user_id = '" . $_SESSION['user_id'] . "' AND department_id = '3'";
	$otorisasi 		= $conn->query($sql_otorisasi);
	if (isset( $_SESSION['user_id'] ) && mysqli_num_rows($otorisasi) != 0) {
?>
</head>
<div class='top_navigation_bar'>
	<div class='col-lg-4 col-md-5 col-sm-6 col-xs-8'>
		<a href='../human_resource/user_dashboard' style='text-decoration:none;display:inline-block'>
			<img src='../universal/images/agungelektrindo_header.png' style='height:50px;'>
		</a>
	</div>
	<div class='col-lg-2 col-md-4 col-sm-4 col-xs-4 col-lg-offset-6 col-md-offset-3 col-sm-offset-1 col-xs-offset-0' style='text-align:right'>
		<h3 style='font-family:Bebasneue'><?= $user_name ?> 
			<span style='display:inline-block'>
				<a href='../codes/logout' style='padding-left:10px;text-decoration:none;color:white;' title='log out'>
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
		<i class="fa fa-university" aria-hidden="true"></i>
		Bank Account
	</button>
	<div class="dropdown-container">
		<a href='view_mutation_dashboard'>
			<p>View mutation</p>
		</a>
		<a href="add_transaction_dashboard">
			<p>Add a transaction</p>
		</a>
	</div>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-money" aria-hidden="true"></i>
		Petty Cash
	</button>
	<div class="dropdown-container">
		<a href="petty_dashboard">
			<p>Add a transaction</p>
		</a>
		<a href="petty_edit">
			<p>Edit transaction</p>
		</a>
		<a href="petty_view">
			<p>View table</p>
		</a>
	</div>
	<hr>
	<a href='financial.php' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Financial Department
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
<?php
} else{
	header('location:../landing_page.php');
};
?>
