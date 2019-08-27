<!DOCTYPE html>
<html lang="en">
<head>
<title>
Sales Department
</title>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<link rel="stylesheet" href="salesstyle.css">
<?php
	include("../codes/connect.php");
	session_start();
	$sql_user = "SELECT isactive,name,role,hpp FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user = $conn->query($sql_user);
	$row_user = $result_user->fetch_assoc();
	$name = $row_user['name'];
	$role = $row_user['role'];
	$hpp = $row_user['hpp'];
	$isactive = $row_user['isactive'];
	
	$sql_otorisasi = "SELECT COUNT(*) AS jumlah_otorisasi FROM authorization WHERE department_id = '1' AND user_id = '" . $_SESSION['user_id'] . "'";
	$result_otorisasi = $conn->query($sql_otorisasi);
	$otorisasi = $result_otorisasi->fetch_assoc();
	if ($otorisasi['jumlah_otorisasi'] == 1 && $isactive == 1) {
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
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-id-badge" aria-hidden="true"></i>
		Quotations
	</button>
	<div class="dropdown-container">
		<a href="createquotation_dashboard">
			<p>Create a quotation</p>
		</a>
		<a href="editquotation_dashboard">
			<p>Print or edit a quotation</p>
		</a>
	</div>
	<button class="btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-users" aria-hidden="true"></i>
		Customers
	</button>
	<div class="dropdown-container">
		<a href="addcustomer_dashboard">
			<p>Add Customer</p>
		</a>
		<a href="editcustomer_dashboard">
			<p>Edit Customer</p>
		</a>
	</div>
	<button class="btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-file-text" aria-hidden="true"></i>
		Sales Order
	</button>
	<div class="dropdown-container">
		<a href="createsalesorder_dashboard">
			<p>Create sales order</p>
		</a>
		<a href="service_sales_order_dashboard">
			<p>Services SO</p>
		</a>
		<a href="confirmsalesorder_dashboard">
			<p>Confirm sales order</p>
		</a>
		<a href="editsalesorder_dashboard">
			<p>Edit sales order</p>
		</a>
	</div>
	<a href="check_stock">
		<button type='button' class='btn-badge'>
			<i class="fa fa-archive" aria-hidden="true"></i>
			Check Stock
		</button>
	</a>
	<button class="btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-undo" aria-hidden="true"></i>
		Return
	</button>
	<div class="dropdown-container">
		<a href="return_dashboard">
			<button type='button' class='btn-badge'>
				Create return
			</button>
		</a>
<?php
	if($role == 'superadmin'){
?>	
		<a href="confirm_return_dashboard">
			<button type='button' class='btn-badge'>
				Confirm return
			</button>
		</a>
<?php
	}
?>
	</div>
	<button class="btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-building" aria-hidden="true"></i>
		Project
	</button>
	<div class="dropdown-container">
		<a href="add_project_dashboard">
			<button type='button' class='btn-badge'>
				Add project
			</button>
		</a>
		<a href="edit_project_dashboard">
			<button type='button' class='btn-badge'>
				Edit project
			</button>
		</a>
		<a href="view_project_dashboard">
			<button type='button' class='btn-badge'>
				View project
			</button>
		</a>
	</div>
	<button class="btn-badge dropdown-btn" style='color:white'>
		<i class="fa fa-clock-o" aria-hidden="true"></i>
		Samples
	</button>
	<div class="dropdown-container">
		<a href="add_sampling_dashboard">
			<button type='button' class='btn-badge'>
				Add sampling
			</button>
		</a>
		<a href="confirm_sampling_dashboard">
			<button type='button' class='btn-badge'>
				Confirm
			</button>
		</a>
	</div>
<?php
	if($hpp == 1){
?>
	<a href="check_hpp_dashboard">
		<button type='button' class='btn btn-badge'>
			<i class="fa fa-money" aria-hidden="true"></i>Check value
		</button>
	</a>
<?php
	}
?>
	<hr>
	<a href='sales.php' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Sales Department
	</a>
</div>
<?php
	} else {
		header('location:../landing_page');
	}
?>
<script>
$('.dropdown-btn').click(function(){
	if($(this).next().is(':visible')){
		$(this).css('color','white');
	} else {
		$(this).css('color','#00ccff');
	}
	$(this).next().toggle(350);
});
</script>