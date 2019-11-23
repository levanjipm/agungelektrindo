<?php
	include('../codes/connect.php');
?>
	<h2 style='font-family:bebasneue'>On Delivery Process</h2>
	<table class='table table-bordered'>
		<tr>
			<th>Customer</th>
			<th>DO Number</th>
			<th></th>
		</tr>
<?php
	$sql_on_delivery		= "SELECT * FROM code_delivery_order WHERE sent = '0' AND date = CURDATE()";
	$result_on_delivery		= $conn->query($sql_on_delivery);
	while($on_delivery		= $result_on_delivery->fetch_assoc()){
		$do_name			= $on_delivery['name'];
		$customer_id		= $on_delivery['customer_id'];
		
		$sql_customer		= "SELECT * FROM customer WHERE id = '$customer_id'";
		$result_customer	= $conn->query($sql_cusomter);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
?>
		<tr>
			<td>
				<h3 style='font-family:bebasneue'><?= $customer_name ?></h3>
				<p><?= $customer_address ?></p>
			</td>
			<td>
				<p><?= $do_name ?></p>
			</td>
		</tr>
<?php	
	}
?>
	</table>
				