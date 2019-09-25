<head>
<title> Purchasing Department</title>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<link rel="stylesheet" href="purchasingstyle.css">
<?php
	include("../codes/connect.php");
	session_start();
	if($_SESSION['user_id'] === NULL){
		header('location:../landing_page.php');
		die();
	}
	$sql_user 		= "SELECT * FROM authorization WHERE user_id = '" . $_SESSION['user_id'] . "' AND department_id = '2'";
	$result_user 	= $conn->query($sql_user);
	if(mysqli_num_rows($result_user) == 0){
		header('location:../landing_page.php');
		die();
	} else {
		$sql_users 		= "SELECT name,role FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
		$result_users 	= $conn->query($sql_users);
		$row_users 		= $result_users->fetch_assoc();
		$name 			= $row_users['name'];
		$role 			= $row_users['role'];
?>
</head>
<body>
<div class='top_navigation_bar'>
	<div class='col-lg-4 col-md-5 col-sm-6 col-xs-8'>
		<a href='../human_resource/user_dashboard' style='text-decoration:none;display:inline-block'>
			<img src='../universal/images/agungelektrindo_header.png' style='height:50px;'>
		</a>
	</div>
	<div class='col-lg-2 col-md-4 col-sm-4 col-xs-4 col-lg-offset-6 col-md-offset-3 col-sm-offset-1 col-xs-offset-0' style='text-align:right'>
		<h3 style='font-family:Bebasneue'><?= $name ?> 
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
		<i class="fa fa-file-o" aria-hidden="true"></i>
		Purchase Order
	</button>
	<div class="dropdown-container">
		<a href="purchase_order_create_dashboard">
			<p>Create a PO</p>
		</a>
<?php
	if($role == 'superadmin'){
?>
		<a href="purchase_order_edit_dashboard">
			<p>Edit a PO</p>
		</a>
		<a href="purchase_order_close_dashboard">
			<p>Close a PO</p>
		</a>
<?php
	}
?>
		<a href='archive_view'>
			<p>Archives</p>
		</a>
	</div>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-briefcase" aria-hidden="true"></i>
		Supplier
	</button>
	<div class="dropdown-container">
		<a href="supplier_add_dashboard">
			<p>Add supplier</p>
		</a>
<?php
	if($role == 'superadmin'){
?>
		<a href="supplier_edit_dashboard">
			<p>Edit supplier</p>
		</a>
<?php
	};
?>
	</div>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-list" aria-hidden="true"></i>
		Item list
	</button>
	<div class="dropdown-container">
		<a href="item_add_dashboard">
			<p>Add item list</p>
		</a>
		<a href="item_edit_dashboard">
			<p>Edit item list</p>
		</a>
		<a href="item_add_class_dashboard">
			<p>Item list category</p>
		</a>
	</div>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-undo" aria-hidden="true"></i>
		Return
	</button>
	<div class="dropdown-container">
		<a href="return_dashboard">
			<p>Create Return</p>
		</a>
		<a href="return_confirm_dashboard">
			<p>Confirm Return</p>
		</a>
	</div>
	<a href='report_dashboard'>
		<button class='btn-badge' style='text-decoration:none'>
			<i class="fa fa-file-text" aria-hidden="true"></i>
			Purchase Report
		</button>
	</a>
	<hr>
	<a href='purchasing' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Purchasing Department
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
	}
?>