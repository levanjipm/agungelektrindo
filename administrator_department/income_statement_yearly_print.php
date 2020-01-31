<?php
	include('../codes/connect.php');
	$year		= mysqli_real_escape_string($conn,$_GET['year']);
	$sql		= "SELECT id FROM invoices WHERE YEAR(date) = $year";
	$result		= $conn->query($sql);
	$count		= mysqli_num_rows($result);
	
	if($count == 0){
		header("location:/agungelektrindo/administrator");
	}
?>
<head>
	<script src='/agungelektrindo/universal/jquery/jquery-3.3.0.min.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/bootstrap/4.1.3/css/bootstrap.min.css'>
	<script src='/agungelektrindo/universal/bootstrap/4.1.3/js/bootstrap.min.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/fontawesome/css/font-awesome.min.css'>
	<link rel='stylesheet' href='/agungelektrindo/universal/bootstrap/3.3.7/css/bootstrap.min.css'>
	<script src='/agungelektrindo/universal/jquery/jquery-ui.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/jquery/jquery-ui.css'>
	<script src='/agungelektrindo/universal/numeral/numeral.js'></script>
	<script src='/agungelektrindo/universal/jquery/jquery.inputmask.bundle.js'></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<link rel="stylesheet" href='/agungelektrindo/css/style.css'>
	<title>Annual income statement <?= $year ?></title>
</head>
<div class='row' style='background-color:#ccc;margin:0;'>
	<div class='col-sm-10 col-sm-offset-1' style='background-color:white;'>
		<h2 style='font-family:times new roman'>Annual income statement</h2>
		<hr>
		
		<h3 style='font-family:times new roman'>Sales and purchases</h3>
		<table class='table table-bordered'>
			<tr>
				<th>Month</th>
				<th>Sales</th>
				<th>Purchases</th>
			</tr>		
<?php
	$sql		= "SELECT MONTH(date) as month, SUM(value) as value FROM invoices WHERE YEAR(date) = '$year' GROUP BY MONTH(date)";
	$result		= $conn->query($sql);
	$annual_sales	= 0;
	$annual_purchase	= 0;
	while($row	= $result->fetch_assoc()){
		$month		= $row['month'];
		$value				= $row['value'];
		$sql_purchase	= "SELECT SUM(value) as value FROM purchases WHERE MONTH(date) = '$month' AND YEAR(date) = '$year'";
		$result_purchase	= $conn->query($sql_purchase);
		$purchases			= $result_purchase->fetch_assoc();
		
		$purchase_value		= $purchases['value'];

		$annual_sales		+= $value;
		$annual_purchase	+= $purchase_value;
?>
			<tr>
				<td><?= date('F Y',mktime(0,0,0,$month,1,$year)) ?></td>
				<td>Rp. <?= number_format($value,2) ?></td>
				<td>Rp. <?= number_format($purchase_value,2) ?></td>
			</tr>
<?php
	}
?>
		</table>
		
		<h3 style='font-family:times new roman'>Expense</h3>
<?php
	$sql				= "SELECT * FROM petty_cash_classification WHERE major_id = '0'";
	$result				= $conn->query($sql);
	while($row			= $result->fetch_assoc()){
		$major_id		= $row['id'];
		$sql_minor		= "SELECT * FROM petty_cash_classification WHERE major_id = '$major_id'";
		$result_minor	= $conn->query($sql_minor);
		$minor			= $result_minor->fetch_assoc();
	}
?>
	</div>
</div>