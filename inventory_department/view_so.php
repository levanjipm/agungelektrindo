<?php
	include('../codes/connect.php');
	$id 					= $_POST['id'];
	$sql_initial 			= "SELECT customer_id,name,note FROM code_salesorder WHERE id = '" . $id . "'";
	$result_initial 		= $conn->query($sql_initial);
	$initial 				= $result_initial->fetch_assoc();
		
	$note					= $initial['note'];
	
	if($initial['customer_id'] == 0){
		$sql_customer 		= "SELECT retail_name, retail_address, retail_city FROM code_salesorder WHERE id = '" . $id . "'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		$customer_name		= $customer['retail_name'];
		$customer_address	= $customer['retail_address'];
		$customer_city		= $customer['retail_city'];
	} else {
		$sql_customer		= "SELECT name, address, city FROM customer WHERE id = '" . $initial['customer_id'] . "'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
	}
		
?>
	<label>Sales order</label>
	<p style='font-family:museo'><?= $initial['name'] ?></p>
	<label>Customer</label>
	<p style='font-family:museo'><strong><?= $customer_name ?></strong></p>
	<p><?= $customer_address ?></p>
	<p><?= $customer_city ?></p>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Quantity</th>
			<th>Sent</th>
		</tr>
<?php
	$sql = "SELECT sales_order.reference, sales_order.quantity, sales_order.sent_quantity, sales_order.status 
			FROM sales_order
			WHERE sales_order.so_id = '" . $id . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		if($row['status'] == 1){
?>
		<tr class='success'>
<?php
		} else {
?>
		<tr>
<?php
		}
?>
			<td><?= $row['reference']; ?></td>
			<td><?= $row['quantity']; ?></td>
			<td><?= $row['sent_quantity']; ?></td>
		</tr>
<?php
	}
?>
	</table>
	<label>Note</label>
	<p><?= $note ?></p>
	<label>Delivery order</label>
<?php
	$sql_delivery_order		= "SELECT id, date, name FROM code_delivery_order WHERE so_id = '$id'";
	$result_delivery_order	= $conn->query($sql_delivery_order);
	if(mysqli_num_rows($result_delivery_order) > 0){
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
		</tr>
<?php
	while($do 		= $result_delivery_order->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($do['date'])) ?></td>
			<td><a href='do_archive.php?id=<?= $do['id'] ?>' style='color:#333'><?= $do['name']; ?></a></td>
		</tr>
<?php
	}
?>
	</table>
<?php
	} else {
?>
	<p style='font-family:museo'>There is no history of delivering this sales order</p>
<?php
	}
?>
	<button type='button' class='button_success_dark' onclick='send(<?= $id ?>)'><i class='fa fa-long-arrow-right'></i></button>
	<form action='delivery_order_create' id='delivery_order_form' method='POST'>
		<input type='hidden' value='<?= $id ?>' name='id'>
	</form>
	<script>
		function send(n){
			$('#delivery_order_form').submit();
		}
	</script>