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
	$sql_user = "SELECT * FROM otorisasi WHERE user_id = '" . $_SESSION['user_id'] . "' AND department_id = '2'";
	$result_user = $conn->query($sql_user);
	if(mysqli_num_rows($result_user) == 0){
		header('location:../landing_page.php');
		die();
	} else {
		$sql_users = "SELECT name,role FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
		$result_users = $conn->query($sql_users);
		while($row_users = $result_users->fetch_assoc()){
			$user_name = $row_users['name'];
			$role = $row_users['role'];
		}
?>
</head>
<body>
<div class="sidenav">
	<div class='row'>
		<div class='col-md-6'>
			<img src='../human_resource/images/users/users.png' style='width:100%; border-radius:50%'>
		</div>
		<div class='col-md-6' style='color:white'>
			<strong>Welcome</strong>
			<p><?= $user_name ?></p>
		</div>
	</div>				
	<hr>
	<style>
		.btn-badge{
			background-color:transparent;
			color:white;
			width:100%;
			text-align:left;
		}
		.dropdown-container {
			display: none;
			background-color: #262626;
			padding-left: 8px;
			line-height:2.5;
		}
	</style>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-file-o" aria-hidden="true"></i>
		Purchase Order
	</button>
	<div class="dropdown-container">
		<a href="createpurchaseorder_dashboard.php">Create a PO<span class="badge"></a>
		<br>
<?php
	if($role == 'superadmin'){
?>
		<a href="editpurchaseorder_dashboard.php">Edit a PO</a>
		<br>
		<a href="close_purchaseorder_dashboard.php">Close PO</a>
<?php
	}
?>
	</div>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-briefcase" aria-hidden="true"></i>
		Supplier
	</button>
	<div class="dropdown-container">
		<a href="addsupplier_dashboard.php">
			<p>Add supplier</p>
		</a>
<?php
	if($role == 'superadmin'){
?>
		<a href="editsupplier_dashboard.php">
			<p>Edit supplier</p>
		</a>
<?php
	};
?>
	</div>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-list" aria-hidden="true"></i>
		Item list
	</button>
	<div class="dropdown-container">
		<a href="additem_dashboard.php">
			<p>Add item list</p>
		</a>
		<a href="edititem_dashboard.php">
			<p>Edit item list</p>
		</a>
	</div>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-truck" aria-hidden="true"></i>
		Delivery Address
	</button>
	<div class="dropdown-container">
		<a href="adddeliveryaddress_dashboard.php">
			<p>Add delivery address</p>
		</a>
		<a href="editdeliveryaddress_dashboard.php">
			<p>Edit delivery address</p>
		</a>
	</div>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-undo" aria-hidden="true"></i>
		Return
	</button>
	<div class="dropdown-container">
		<a href="purchasing_return_dashboard.php">
			<p>Create Purchasing Return</p>
		</a>
		<a href="return_confirm_dashboard.php">
			<p>Confirm Purchasing Return</p>
		</a>
	</div>
	</a>
	<hr>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<a href='../human_resource/user_dashboard.php' style='color:white;text-decoration:none'>
			<i class="fa fa-home" aria-hidden="true"></i>
			Back to home
		</a>
	</button>
	<a href='../codes/logout.php'>
		<button type='button' class='btn btn-badge' style='color:white'>
		<i class="fa fa-sign-out" aria-hidden="true"></i>
		Log Out
		</button>
	</a>
	<hr>
	<a href='purchasing.php' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Purchasing Department
	</a>
	<script>
	var dropdown = document.getElementsByClassName("dropdown-btn");
	var i;

	for (i = 0; i < dropdown.length; i++) {
		dropdown[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var dropdownContent = this.nextElementSibling;
			if (dropdownContent.style.display === "block") {
				dropdownContent.style.display = "none";
			} else {
			dropdownContent.style.display = "block";
			}
		});
	};
	</script>
</div>
<?php
	}
?>