<?php
	include('../codes/connect.php');
?>
	<h2 style='font-family:bebasneue'>Pending Sales Order</h2>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Customer</th>
			<th>PO Number</th>
		</tr>
<?php
	$sql		= "SELECT DISTINCT(so_id) FROM sales_order WHERE status = '0'";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
		$sql_code	= "SELECT date, customer_id, retail_name, po_number FROM code_salesorder WHERE id = '" . $row['so_id'] . "'";
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
		<tr>
			<td><?= date('d M Y',strtotime($code['date'])) ?></td>
			<td><?= $customer_name ?></td>
			<td><?= $code['po_number'] ?></td>
			<td><button type='button' class='button_success_dark' onclick='view_sales_order_detail(<?= $row['so_id'] ?>)'>View</button></td>
		</tr>
<?php
	}
?>
	</table>