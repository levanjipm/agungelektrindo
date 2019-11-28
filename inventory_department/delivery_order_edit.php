<?php
	include('inventoryheader.php');
	if(empty($_POST['id'])){
?>
	<script>
		window.location.replace("edit_delivery_order_dashboard.php");
	</script>
<?php
	} else {
		$do_id 				= $_POST['id'];
		$sql_so 			= "SELECT so_id,name,customer_id FROM code_delivery_order WHERE id = '" . $do_id . "'";
		$result_so 			= $conn->query($sql_so);
		$row_so 			= $result_so->fetch_assoc();
		$so_id 				= $row_so['so_id'];
		$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $row_so['customer_id'] . "'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
?>
<div class="main">
	<h2 style='font-family:bebasneue'>Delivery Order</h2>
	<p>Edit delivery order</p>
	<hr>
	<h3><?= $row_so['name'];?></h3>
	<p><?php
		
		echo $customer['name'];
	?></p>
	<form method='POST' action='edit_delivery_order_validation' id='myForm'>
	<table class='table table-bordered'>
		<tr>
			<th style="width:40%">Item</th>
			<th style="width:20%">Sent item</th>
			<th style="width:20%">Quantity ordered</th>
			<th style="width:20%">Quantity to be sent</th>
		</tr>
<?php
		$sql = "SELECT * FROM sales_order WHERE so_id = '" . $so_id . "'";
		$results = $conn->query($sql);
		if($results->num_rows > 0){
			while($row 				= $results->fetch_assoc()){
				$reference			= $row['reference'];
				$quantity			= $row['quantity'];
				$sent_quantity		= $row['sent_quantity'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $sent_quantity ?></td>
			<td><?= $quantity ?></td>
			<td>
				<input type='number' class='form-control' min ='0' name='quantity<?= $tt ?>' id='quantity<?= $tt ?>'>
			</td>
		</tr>
<?php	
		}
?>
	</table>
	<br><br>
	<input type='hidden' value='<?= $do_id ?>' name='do_id'>
	<button type='button' class='button_danger_dark' onclick='check()'>Edit Delivery Order</button>
<?php
		} else {
?>
		<div class="col-lg-6 offset-lg-3" style="text-align:center">
			<p>There are no delivery order need to be approved</p>
		</div>
<?php
		};
?>
</div>
<?php
	}
?>