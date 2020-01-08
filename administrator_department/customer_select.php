<?php
	include('../codes/connect.php');
	if(empty($_POST['opponent'])){
		$opponent		= '';
	} else {
		$opponent			= $_POST['opponent'];
	}
?>
	<select class='form-control' id='transaction_select_to'  name='transaction_select_to'>
		<option value='0'>Retail purchase</option>
<?php
	$sql_customer			= "SELECT id,name,city FROM customer ORDER BY name ASC";
	$result_customer		= $conn->query($sql_customer);
	while($customer			= $result_customer->fetch_assoc()){
		$customer_id		= $customer['id'];
		$customer_name		= $customer['name'];
		$customer_address	= $customer['city'];
?>
		<option value='<?= $customer_id ?>' <?php if($customer_id == $opponent){ echo 'selected'; } ?>><?= $customer_name ?></option>
<?php
	}
?>
	</select>