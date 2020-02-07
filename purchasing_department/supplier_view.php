<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
	
	$supplier_id			= $_GET['id'];
	$sql_supplier			= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier		= $conn->query($sql_supplier);
	$supplier				= $result_supplier->fetch_assoc();
	
	if(empty($_GET['id']) || mysqli_num_rows($result_supplier) == 0){
?>
<script>
	window.location.href='/agungelektrindo/inventory';
</script>
<?php
	}
	
	$supplier_name			= $supplier['name'];
	$supplier_address		= $supplier['address'];
	$supplier_city			= $supplier['city'];
	
	$sql					= "SELECT SUM(value) as value FROM purchases
								WHERE isdone = '0' AND supplier_id = '$supplier_id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
	
	$purchases				= $row['value'];
	
	$difference				= 0;
	$n						= 0;
	$sql					= "SELECT purchases.date, MAX(payable.date) as payment FROM purchases
								JOIN payable ON purchases.id = payable.purchase_id
								WHERE purchases.supplier_id = '$supplier_id' AND purchases.isdone = '1'
								GROUP BY payable.purchase_id";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		$date				= $row['date'];
		$payment_date		= $row['payment'];
		
		$difference			+= strtotime($payment_date) - strtotime($date);
		$n++;
	}
	
	$difference_in_days		= $difference / (60 * 60 * 24 * $n);
?>
<head>
	<title>View <?= $supplier_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Supplier</h2>
	<p style='font-family:museo'>Supplier data</p>
	<hr>
	<div class='row'>
		<div class='col-sm-6 col-xs-12'>
			<label>Name</label>
			<p style='font-family:museo'><?= $supplier_name ?></p>
			<p style='font-family:museo'><?= $supplier_address ?></p>
			<p style='font-family:museo'><?= $supplier_city ?></p>
			
			<label>Remaining debt</label>
			<p style='font-family:museo'>Rp. <?= number_format($purchases,2) ?></p>
			
			<label>Average payment</label>
			<p style='font-family:museo'><?= number_format($difference_in_days,2) ?> days</p>
			
			<label>History of purchase</label>
			<div id='purchasing_chart'></div>
		</div>
		<div class='col-sm-6 col-xs-12'>
			<label>Frequent item</label>
			<table class='table table-bordered'>
				<tr>
					<th>Reference</th>
					<th>Description</th>
					<th>Monthly demand</th>
				</tr>
<?php
	$sql_delivery_order		= "SELECT MIN(date) as minimum_date, MAX(date) as maximum_date FROM code_purchaseorder WHERE supplier_id = '$supplier_id'";
	$result_delivery_order	= $conn->query($sql_delivery_order);
	$row_delivery_order		= $result_delivery_order->fetch_assoc();
	
	$min_date				= strtotime($row_delivery_order['minimum_date']);
	$max_date				= strtotime($row_delivery_order['maximum_date']);
	
	$date_difference		= abs(($max_date - $min_date) / (60*60*24*30));
	
	$sql_detail				= "SELECT purchaseorder.reference, SUM(purchaseorder.quantity) as quantity, itemlist.description FROM code_purchaseorder
								INNER JOIN purchaseorder ON code_purchaseorder.id = purchaseorder.purchaseorder_id
								JOIN itemlist ON purchaseorder.reference = itemlist.reference
								WHERE code_purchaseorder.supplier_id = '$supplier_id' GROUP BY purchaseorder.reference ORDER BY quantity DESC LIMIT 8";
	$result_detail			= $conn->query($sql_detail);
	while($detail			= $result_detail->fetch_assoc()){
	
		$reference				= $detail['reference'];
		$quantity				= $detail['quantity'];
		$description			= $detail['description'];
		if($date_difference		< 1){
			$average_quantity	= $quantity;
		} else {
			$average_quantity	= $quantity / $date_difference;
		}	
?>
				<tr>
					<td><?= $reference ?></td>
					<td><?= $description ?></td>
					<td><?= number_format($average_quantity,2) ?></td>
				</tr>
<?php
	}
?>
			</table>
			<label>Last transaction</label>
			<table class='table table-bordered'>
				<tr>
					<th>Date</th>
					<th>Name</th>
				</tr>
<?php
	$sql_delivery_order			= "SELECT document, date FROM code_goodreceipt WHERE supplier_id = '$supplier_id' ORDER BY date DESC LIMIT 5";
	$result_delivery_order		= $conn->query($sql_delivery_order);
	while($delivery_order		= $result_delivery_order->fetch_assoc()){
	$do_name					= $delivery_order['document'];
	$do_date					= $delivery_order['date'];
?>
				<tr>
					<td><?= date('d M Y',strtotime($do_date)) ?></td>
					<td><?= $do_name ?></td>
				</tr>
<?php
	}
?>
			</table>
		</div>
	</div>
</div>
<script>
	$.ajax({
		url:'supplier_view_chart.php',
		data:{
			supplier_id:<?= $supplier_id ?>
		},
		success:function(response){
			$('#purchasing_chart').html(response);
		}
	});
</script>