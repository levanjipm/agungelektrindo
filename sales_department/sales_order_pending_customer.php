<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	if(!empty($_GET['id'])){
		$customer_id			= (int) $_GET['id'];
		$sql_customer			= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
		$result_customer		= $conn->query($sql_customer);
		
		if(mysqli_num_rows($result_customer) == 0){
?>
<script>
	window.location.href='/agungelektrindo/sales';
</script>
<?php
		}
		
		$customer				= $result_customer->fetch_assoc();
		
		$customer_name			= $customer['name'];
		$customer_address		= $customer['address'];
		$customer_city			= $customer['city'];
	} else {
		$customer_name			= 'Retail';
	}
?>
<head>
	<title>Pending sales order for <?= $customer_name ?></title>
</head>
<style>
	#pending_items_print_header{
		display:none;
	}
	@media print {
		body * {
			visibility: hidden;
		}
		
		#pending_items_print_header{
			display:block;
		}
		
		#pending_items_print, #pending_items_print * {
			visibility: visible;
		}
		#pending_items_print {
			position: absolute;
			left: 0;
			top: 0;
			width:100%;
		}
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales order</h2>
	<p style='font-family:museo'>Pending sales order</p>
	<hr>
	
	<label>Customer</label>
<?php
	if(!empty($_GET['id'])){
?>
	<a href='/agungelektrindo/sales_department/customer_view.php?id=<?= $customer_id ?>' style='text-decoration:none;color:black'>
		<p style='font-family:museo'><?= $customer_name ?></p>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>
	</a>
<?php
	} else {
?>
	<p style='font-family:museo'>Retail</p>
<?php
	}
	
	$sql			= "SELECT code_salesorder.name, code_salesorder.date, code_salesorder.id
						FROM code_salesorder
						LEFT JOIN sales_order ON code_salesorder.id = sales_order.so_id
						WHERE code_salesorder.customer_id = '$customer_id' AND sales_order.status = '0'
						ORDER BY code_salesorder.date ASC";
	$result			= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
	<p style='font-family:museo'>There is no pending sales order</p>
<?php
	} else {
?>	
	<label>Sales order</label>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Action</th>
		</tr>
<?php
	while($row		= $result->fetch_assoc()){
		$sales_order_id			= $row['id'];
		$sales_order_name		= $row['name'];
		$sales_order_date		= $row['date'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($sales_order_date)) ?></td>
			<td><?= $sales_order_name ?></td>
			<td>
				<button type='button' class='button_success_dark' onclick='view_sales_order(<?= $sales_order_id ?>)'><i class='fa fa-eye'></i></button>
			</td>
		</tr>
<?php
	}
?>
	</table>
	<form action='sales_order_archive_print' target='blank' id='sales_order_form' method='POST'>
		<input type='hidden' id='sales_order_id' name='id'>
	</form>
	<script>
		function view_sales_order(n){
			$('#sales_order_id').val(n);
			$('#sales_order_form').submit();
		}
	</script>
	<label>Pending items</label> <button type='button' class='button_success_dark' onclick='window.print()'><i class='fa fa-print'></i></button>
	<div id='pending_items_print'>
	
	<div id='pending_items_print_header'>
		<label>Customer</label>
		<p style='font-family:museo'><?= $customer_name ?></p>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>
	</div>
	
	<table class='table table-bordered'>
		<tr>
			<th style='width:15%'>Reference</th>
			<th style='width:20%'>Description</th>
			<th>Quantity</th>
			<th>Sent</th>
			<th>Pending</th>
			<th>Sales order</th>
		</tr>
<?php
	$sql_pending		= "SELECT sales_order.reference, itemlist.description, code_salesorder.name, sales_order.quantity, sales_order.sent_quantity
							FROM sales_order
							INNER JOIN code_salesorder ON code_salesorder.id = sales_order.so_id
							JOIN itemlist ON sales_order.reference = itemlist.reference
							WHERE sales_order.status = '0' AND code_salesorder.customer_id = '$customer_id'";
	$result_pending		= $conn->query($sql_pending);
	while($pendings			= $result_pending->fetch_assoc()){
		$reference		= $pendings['reference'];
		$description	= $pendings['description'];
		$quantity		= $pendings['quantity'];
		$sent			= $pendings['sent_quantity'];
		$name			= $pendings['name'];
		$pending		= $quantity - $sent;
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity) ?></td>
			<td><?= number_format($sent) ?></td>
			<td><?= number_format($pending) ?></td>
			<td><?= $name ?></td>
		</tr>
<?php
	}
?>
	</table>
	</div>
<?php
	}
?>
</div>