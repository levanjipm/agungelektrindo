<?php
	include('accountingheader.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Receivable</h2>
	<p>Create report</p>
	<hr>
	<table class='table table-hover'>
		<tr>
			<th>Customer</th>
			<th>Total receivable</th>
			<th>< 30 days</th>
			<th>30 - 45 days</th>
			<th>45 - 60 days</th>
			<th>More than 60 days</th>
			<th></th>
		</tr>
	
<?php
	$sql = "SELECT SUM(invoices.value) as total_piutang, code_delivery_order.customer_id , customer.name
	FROM invoices
	JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
	JOIN customer ON code_delivery_order.customer_id = customer.id
	WHERE invoices.isdone = '0' GROUP BY code_delivery_order.customer_id";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_30 = "SELECT SUM(invoices.value) AS less_than_30 FROM invoices
		JOIN code_delivery_order
		WHERE isdone = '0' AND date >= '" . date('Y-m-d',strtotime('-30 days')) . "'";
		$result_30 = $conn->query($sql_30);
		$row_30 = $result_30->fetch_assoc();
		
		$sql_45 = "SELECT SUM(value) AS less_than_45 FROM invoices 
		WHERE isdone = '0' AND date < '" . date('Y-m-d',strtotime('-30 days')) . "' 
		AND date > '" . date('Y-m-d',strtotime('-45 days')) . "'";
		$result_45 = $conn->query($sql_45);
		$row_45 = $result_45->fetch_assoc();
		
		$sql_60 = "SELECT SUM(value) AS less_than_60 FROM invoices 
		WHERE isdone = '0' AND date < '" . date('Y-m-d',strtotime('-45 days')) . "' 
		AND date > '" . date('Y-m-d',strtotime('-60 days')) . "'";
		$result_60 = $conn->query($sql_60);
		$row_60 = $result_60->fetch_assoc();
		
		$sql_nunggak = "SELECT SUM(value) AS nunggak FROM invoices 
		WHERE isdone = '0' AND date <= '" . date('Y-m-d',strtotime('-60 days')) . "'";
		$result_nunggak = $conn->query($sql_nunggak);
		$nunggak = $result_nunggak->fetch_assoc();
?>
		<tr>
			<td><?= $row['name'] ?></td>
			<td>Rp. <?= number_format($row['total_piutang'],2) ?></td>
		</tr>
<?php
	}
?>
</div>