<?php
	include('../codes/connect.php');
?>
	<select class='form-control' id='transaction_select_to'  name='transaction_select_to'>
		<option value='0'>Please select a customer</option>
<?php
	$sql_customer			= "SELECT id,name,city FROM customer ORDER BY name ASC";
	$result_customer		= $conn->query($sql_customer);
	while($customer			= $result_customer->fetch_assoc()){
		$customer_id		= $customer['id'];
		$customer_name		= $customer['name'];
		$customer_address	= $customer['city'];
?>
		<option value='<?= $customer_id ?>'><?= $customer_name ?></option>
<?php
	}
?>
	</select>