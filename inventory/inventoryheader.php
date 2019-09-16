<head>
<title>Inventory Department</title>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="inventorystyle.css">
<?php
	include("../codes/connect.php");
	session_start();
	if($_SESSION['user_id'] === NULL){
		header('location:../landing_page.php');
	}
	$sql_user 		= "SELECT name,role FROM users WHERE id = " . $_SESSION['user_id'];
	$result_user 	= $conn->query($sql_user);
	$row_user 		= $result_user->fetch_assoc();
	$role 			= $row_user['role'];
	$name 			= $row_user['name'];
	if(mysqli_num_rows($result_user) == 0){
		header('location:../landing_page.php');
	}
	$sql_otorisasi = "SELECT * FROM authorization WHERE user_id = '" . $_SESSION['user_id'] . "' AND department_id = '3'";
	$otorisasi = $conn->query($sql_otorisasi);
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
		Delivery Order
	</button>
	<div class="dropdown-container">
		<a href="do_choose.php">Create a DO<span class="badge"></a>
		<br>
		<a href="edit_delivery_order_dashboard.php">Edit a DO</a>
		<br>
		<a href="confirm_do_dashboard.php">Confirm DO</a>
		<br>
		<a href='view_do_archive.php'>
			Archives
		</a>
	</div>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-file-o" aria-hidden="true"></i>
		Goods Receipt
	</button>
	<div class="dropdown-container">
		<a href="goodreceipt_dashboard.php">
			<p>Create good receipt</p>
		</a>
<?php
	$sql_badge_2 		= "SELECT COUNT(*) AS jumlah FROM code_goodreceipt WHERE isconfirm = '0'";
	$result_badge_2 	= $conn->query($sql_badge_2);
	$row_badge_2 		= $result_badge_2->fetch_assoc();
	$badge_2 			= $row_badge_2['jumlah'];
?>
		<a href="goodreceipt_confirm_dashboard.php">
			Confirm GR<span class="badge"><?= $badge_2 ?></span>
		</a>
		<br>
		<a href='view_gr_archive.php'>
			Archives
		</a>
	</div>
<?php
	if($role == 'superadmin'){
?>
	
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-calendar" aria-hidden="true"></i>
		Add an event
	</button>	
	<div class="dropdown-container">
		<a href="add_event_dashboard.php">
			Add event
		</a>
		<br>
		<a href='confirm_event_dashboard.php'>
			Confirm event
		</a>
	</div>
<?php
	}
?>
	<a href="check_stock.php">
		<button type='button' class='btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-archive" aria-hidden="true"></i>
			Check stock
		</button>
	</a>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-building" aria-hidden="true"></i>
		Project
	</button>
	<div class="dropdown-container">
		<a href="project_do_dashboard.php">
			<button type='button' class='btn-badge' style='color:white'>
				Create DO
			</button>
		</a>
		<a href="confirm_do_dashboard_project.php">
			<button type='button' class='btn-badge' style='color:white'>
				Confirm DO
			</button>
		</a>
		<a href="set_project_done_dashboard.php">
			<button type='button' class='btn-badge' style='color:white'>
				Set done
			</button>
		</a>
	</div>
	<a href="sample_dashboard.php">
		<button type='button' class='btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-flask" aria-hidden="true"></i>
			Samples
		</button>
	</a>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-undo" aria-hidden="true"></i>
		Return
	</button>
	<div class="dropdown-container">
		<a href="sales_return_dashboard.php">
			<p>Sales return</p>
		</a>
		<a href="purchasing_return_dashboard.php">
			<p>Purchasing return</p>
		</a>
	</div>
	<hr>
	<a href='inventory.php' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Inventory Department
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
