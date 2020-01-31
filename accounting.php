<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	
	$sql		= "SELECT id FROM code_delivery_order WHERE isinvoiced = '0' AND company = 'AE'";
	$result		= $conn->query($sql);
	$pending_invoice	= mysqli_num_rows($result);
	
	$sql		= "SELECT id FROM code_goodreceipt WHERE isinvoiced = '0'";
	$result		= $conn->query($sql);
	$pending_bills		= mysqli_num_rows($result);
	
	$sql		= "SELECT id FROM code_bank WHERE isdone = '0' AND isdelete = '0' AND label <> 'OTHER'";
	$result		= $conn->query($sql);
	$pending_bank		= mysqli_num_rows($result);
?>
<head>
	<script src='/agungelektrindo/universal/chartist/dist/chartist.min.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/chartist/dist/chartist.min.css'>
	<title>Accounting department</title>
</head>
<style>
	.ct-label {
		font-size: 10px;
		font-family:museo;
		color:#333;
	}
	
	.ct-chart{
		height:300px;
	}
	
	.box{
		padding:10px;
		background-color:#fff;
		color:#024769;
		border:3px solid #024769;
		text-align:center;
		cursor:pointer;
		width:25%;
		display:inline-block;
		margin-left:2%;
	}

	.box:hover{
		background-color:#eee;
		color:#333;
		transition:0.3s all ease;
	}

	.bar_wrapper{
		position:relative;
		background-color:#fff;
		width:100%;
		height:5px;
	}

	.bar{
		position:absolute;
		top:0;
		height:100%;
		background-color:#aaa;
		transition:0.5s all ease;
	}
</style>
<div class='main'>
	<a href='/agungelektrindo/accounting_department/build_invoice_dashboard' style='text-decoration:none'>
	<div class='box'>
		<h2><?= $pending_invoice ?></h2>
		<h5>Pending invoice</h5>
		<div class='bar_wrapper'>
			<div class='bar' id='pending_invoice_bar'></div>
		</div>
		<script>
			$(document).ready(function(){
				$('#pending_invoice_bar').animate({
					width: "<?= min(100, ($pending_invoice * 2)) ?>%"
				},300)
			});
		</script>
	</div>
	</a>
	<a href='/agungelektrindo/accounting_department/waiting_for_billing' style='text-decoration:none'>
	<div class='box'>
		<h2><?= $pending_bills ?></h2>
		<h5>Pending bills</h5>
		<div class='bar_wrapper'>
			<div class='bar' id='pending_bills_bar'></div>
		</div>
		<script>
			$(document).ready(function(){
				$('#pending_bills_bar').animate({
					width: "<?= min(100, ($pending_bills * 2)) ?>%"
				},300)
			});
		</script>
	</div>
	</a>
	<a href='/agungelektrindo/accounting_department/assign_bank_dashboard' style='text-decoration:none'>
	<div class='box'>
		<h2><?= $pending_bank ?></h2>
		<h5>Pending bank data</h5>
		<div class='bar_wrapper'>
			<div class='bar' id='pending_bank_bar'></div>
		</div>
		<script>
			$(document).ready(function(){
				$('#pending_bank_bar').animate({
					width: "<?= min(100, ($pending_bank * 2)) ?>%"
				},300)
			});
		</script>
	</div>
	</a>
	<br><br>
	<div class='row'>
		<div class='col-md-8 col-sm-8 col-xs-12'>
			<a href='/agungelektrindo/accounting_department/receivable_dashboard' style='text-decoration:none;width:100%;color:#333'>
			<div id='receivable_chart'></div>
			</a>
		</div>
	</div>
	<script>
		$.ajax({
			url:'/agungelektrindo/accounting_department/receivable_chart.php',
			success:function(response){
				$('#receivable_chart').html(response);
			}
		});
	</script>
</div>