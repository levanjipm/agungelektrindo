<?php
	include('inventoryheader.php');
	if(empty($_POST['id'])){
		header('location:inventory.php');
	}
	$return_id = $_POST['id'];
	$sql_code = "SELECT * FROM code_sales_return WHERE id = '" . $return_id . "'";
	$result_code = $conn->query($sql_code);
	$code = $result_code->fetch_assoc();
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Return</h2>
	<hr>
	<form method='POST' action='sales_return_input_dashboard.php'>
<?php
	$sql_customer 		= "SELECT name,address,city FROM customer WHERE id = '" . $code['customer_id'] . "'";
	$result_customer 	= $conn->query($sql_customer);
	$customer 			= $result_customer->fetch_assoc();
?>
		<h4 style='font-family:bebasneue'><?= $customer['name'] ?></h4>
		<p><?= $customer['address'] ?></p>
		<p><?= $customer['city'] ?></p>
		<label>Document number</label>
		<input type='text' class='form-control' style='width:50%'  id='document' name='document' required>
		<label>Date</label>
		<input type='date' value='<?= date('Y-m-d') ?>' name='return_date' class='form-control' style='width:50%'>
		<br>
		<table class='table table-bordered'>
			<tr>
				<th style='width:20%'>Reference</th>
				<th style='width:40%'>Description</th>
				<th style='width:15%'>Return quantity</th>
				<th style='width:15%'>Received quantity</th>
			</tr>
<?php
	$sql_return		= "SELECT sales_return.id, sales_return.delivery_order_id, delivery_order.reference, sales_return.quantity, sales_return.received FROM sales_return 
						JOIN delivery_order ON delivery_order.id = sales_return.delivery_order_id
						WHERE sales_return.return_code = '" . $return_id . "'";
	$result_return 	= $conn->query($sql_return);
	while($return 	= $result_return->fetch_assoc()){
?>
			<tr>
				<td>
					<?= $return['reference'] ?>
				</td>
				<td><?php
					$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . $return['reference'] . "'";
					$result_item 	=  $conn->query($sql_item);
					$item 			= $result_item->fetch_assoc();
					echo $item['description'];
				?></td>
				<td><?= $return['quantity'] - $return['received'] ?></td>
				<td>
					<input type='number' value='0' id='received<?= $return['id'] ?>' name='received[<?= $return['id'] ?>]' class='form-control'>
				</td>
			</tr>
<?php
	}
?>
		</table>
		<input type='hidden' value='<?= $return_id ?>' name='return_id'>
		<button type='submit' class='button_default_dark'>Next</button>
	</form>
</div>