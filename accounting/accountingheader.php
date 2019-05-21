<!DOCTYPE html>
<html lang="en">
<head>
<title>Accounting Department</title>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel='stylesheet' href='accountingstyle.css'>
<?php
include('../codes/connect.php');
session_start();
if(empty($_SESSION['user_id'])){
	header('location:../landing_page.php');
}
$sql = "SELECT name,role FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$user_name = $row['name'];
$role = $row['role'];
$sql_otorisasi = "SELECT * FROM otorisasi WHERE user_id = '" . $_SESSION['user_id'] . "' AND department_id = '4'";
$result_otorisasi = $conn->query($sql_otorisasi);
if(mysqli_num_rows($result_otorisasi) > 0){
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
		Sales Invoice
	</button>
	<div class="dropdown-container">
		<a href="invoiceexist_dashboard.php">Create an invoice<span class="badge"></a>
		<br>
<?php
	if ($role == 'superadmin'){
?>
		<a href="edit_invoice_dashboard.php">Edit an invoice</a>
		<br>
		<a href="confirm_invoice_dashboard.php">Confirm an invoice</a>
<?php
	}
?>
	</div>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-calendar" aria-hidden="true"></i>
		Purchase Invoice
	</button>	
	<div class="dropdown-container">
		<a href="debt_document_dashboard.php">
			<p>Input debt document</p>
		</a>
		<a href="waiting_for_billing.php">
			<p>Pending bills</p>
		</a>
	</div>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-undo" aria-hidden="true"></i>
		Journals
	</button>
	<div class="dropdown-container">
		<a href="sales_journal.php">
			<p>Sales journal</p>
		</a>
		<a href="#">
			<p>Purchasing journal</p>
		</a>
		<a href="stock_value_dashboard.php">
			<p>Stock value</p>
		</a>
	</div>
	<a href='receivable_dashboard.php'>
		<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-file-o" aria-hidden="true"></i>
			Receivables
		</button>
	</a>
	<a href='payable_dashboard.php'>
		<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-file-o" aria-hidden="true"></i>
			Payable
		</button>
	</a>
	<a href='assign_bank_dashboard.php'>
		<button type='button' class='btn btn-badge'>
			<i class="fa fa-university" aria-hidden="true"></i>
			Bank
		</button>
	</a>
	<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-undo" aria-hidden="true"></i>
		Return
	</button>
	<div class="dropdown-container">
		<a href="sales_return_dashboard.php">
			<p>Sales return</p>
		</a>
		<a href="#">
			<p>Purchasing return</p>
		</a>
	</div>
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
	<a href='accounting.php' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Accounting Department
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
	}
	</script>
</div>
<?php
} else{
	header('location:../landing_page.php');
};
?>