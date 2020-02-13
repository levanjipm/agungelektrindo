<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Pending sales order</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales order</h2>
	<p style='font-family:museo'>Pending sales order</p>
	<hr>
<?php
	$sql		= "SELECT COUNT(code_salesorder.id) as count, customer.name, customer.id
					FROM sales_order
					INNER JOIN code_salesorder ON sales_order.so_id = code_salesorder.id
					JOIN customer ON code_salesorder.customer_id = customer.id
					WHERE sales_order.status = '0' GROUP BY code_salesorder.customer_id
					UNION
					SELECT COUNT(code_salesorder.id) as count, COALESCE(code_salesorder.customer_id, 'Retail'), sales_order.id FROM sales_order
					INNER JOIN code_salesorder ON sales_order.so_id = code_salesorder.id
					WHERE sales_order.status = '0' AND code_salesorder.customer_id IS NULL";
	$result		= $conn->query($sql);
	$pending	= mysqli_num_rows($result);
	if($pending	== 0){
?>
	<p style='font-family:museo'>There are no pending sales order</p>
<?php
	} else {
?>
	<table class='table table-bordered'>
		<tr>
			<th>Customer</th>
			<th>Pending sales orders</th>
			<th>Action</th>
		</tr>
<?php
		while($row	= $result->fetch_assoc()){
			$customer_id	= $row['id'];
			$customer_name	= $row['name'];
			$count			= $row['count'];
			if($count		> 0){
?>
		<tr>
			<td><?= $customer_name ?></td>
			<td><?= number_format($count) ?></td>
			<td>
<?php
	if($customer_name == 'Retail'){
?>
				<a href='sales_order_pending_customer' style='text-decoration:none'>
<?php
	} else {
?>
				<a href='sales_order_pending_customer.php?id=<?= $customer_id ?>'>
<?php
	}
?>
				<button type='button' class='button_success_dark'><i class='fa fa-eye'></i></button>
			</td>
		</tr>
<?php
			}
		}
?>
	</table>
<?php
	}
?>
</div>