<?php
	include('../codes/connect.php');
	$sales_order_id	= $_POST['sales_order_id'];
	$sql_code		= "SELECT date, customer_id, retail_name, po_number FROM code_salesorder WHERE id = '" . $sales_order_id . "'";
	$result_code	= $conn->query($sql_code);
	$code			= $result_code->fetch_assoc();
	
	if($code['customer_id'] == 0){
		$customer_name		= $code['retail_name'];
	} else {
		$sql_customer		= "SELECT name FROM customer WHERE id = '" . $code['customer_id'] . "'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
	}
?>
	<h2 style='font-family:bebasneue'><?= $customer_name ?></h2>
	<label>PO Number</label>
	<p><?= $code['po_number'] ?></p>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Pending quantity</th>
		</tr>
<?php
	$sql			= "SELECT * FROM sales_order WHERE so_id = '$sales_order_id'";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$reference	= $row['reference'];
		$quantity	= $row['quantity'];
		$pending	= $row['quantity'] - $row['sent_quantity'];
		$sql_item	= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item	= $conn->query($sql_item);
		$item			= $result_item->fetch_assoc();
		
		$description	= $item['description'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity,0) ?></td>
			<td><?= number_format($pending,0) ?></td>
		</tr>
<?php
	}
?>
	</table>
	<button type='button' class='button_danger_dark' onclick='view_pending_sales_order()'>Back</button>