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
$sql 		= "SELECT isactive,name,role FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
$result 	= $conn->query($sql);
$row 		= $result->fetch_assoc();
$name 		= $row['name'];
$role 		= $row['role'];
$isactive 		= $row['isactive'];

$sql_otorisasi = "SELECT * FROM authorization WHERE user_id = '" . $_SESSION['user_id'] . "' AND department_id = '4'";
$result_otorisasi = $conn->query($sql_otorisasi);
if(mysqli_num_rows($result_otorisasi) > 0 && $isactive == 1){
?>
</head>
<body>
<div class='top_navigation_bar'>
	<div class='col-lg-4 col-md-5 col-sm-6 col-xs-8'>
		<a href='../human_resource/user_dashboard' style='text-decoration:none'>
			<img src='../universal/images/agungelektrindo_header.png' style='height:50px;'>
		</a>
	</div>
	<div class='col-lg-2 col-md-3 col-sm-4 col-xs-4 col-lg-offset-6 col-md-offset-4 col-sm-offset-2 col-xs-offset-0' style='text-align:right'>
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
		<br>
<?php
	}
?>
		<a href='invoice_archive.php'>Archives</a>
	</div>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-calendar" aria-hidden="true"></i>
		Purchase Invoice
	</button>	
	<div class="dropdown-container">
		<a href="debt_document_dashboard">
			<p>Input debt document</p>
		</a>
		<a href="confirm_purchases_dashboard">
			<p>Confirm document</p>
		</a>
		<a href="waiting_for_billing">
			<p>Pending bills</p>
		</a>
		<a href='purchase_archive'>
			<p>Archives</p>
		</a>
<?php
	if($role == 'superadmin'){
?>
		<a href='random_debt_document'>
			<p>Input random</p>
		</a>
<?php
	}
?>
	</div>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-code" aria-hidden="true"></i>
		Counter Bill
	</button>
	<div class="dropdown-container">
		<a href="counter_bill_dashboard">
			<p>Create counter bill</p>
		</a>
		<a href="view_counter_bill">
			<p>View counter bill</p>
		</a>
	</div>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-bookmark" aria-hidden="true"></i>
		Journals
	</button>
	<div class="dropdown-container">
		<a href="sales_journal">
			<p>Sales journal</p>
		</a>
		<a href="purchasing_journal">
			<p>Purchasing journal</p>
		</a>
		<a href="stock_value_dashboard">
			<p>Stock value</p>
		</a>
	</div>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-credit-card-alt" aria-hidden="true"></i>
		Receivable
	</button>
	<div class="dropdown-container">
		<a href='receivable_dashboard'>
			<p>Dashboard</p>
		</a>
		<a href='receivable_report_customer'>
			<p>Report</p>
		</a>
	</div>
	<a href='payable_dashboard'>
		<button type='button' class='btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-credit-card" aria-hidden="true"></i>
			Payable
		</button>
	</a>
	<a href='assign_bank_dashboard'>
		<button type='button' class='btn-badge'>
			<i class="fa fa-university" aria-hidden="true"></i>
			Bank
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
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-random" aria-hidden="true"></i>
		Random Invoice
	</button>
	<div class="dropdown-container">
		<a href="build_proforma_invoice_dashboard.php">
			<p><i>Proforma Invoice</i></p>
		</a>
		<a href="down_payment_dashboard.php">
			<p><i>DP Invoice</i></p>
		</a>
		<a href='random_invoice_archive.php'>
			<p>Archives</p>
		</a>
	</div>
	<a href='income_statement_dashboard'>
		<button type='button' class='btn-badge'>
			<i class="fa fa-book" aria-hidden="true"></i>
			Income statement
		</button>
	</a>
	<hr>
	<a href='accounting.php' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Accounting Department
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