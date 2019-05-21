<?php
	include('accountingheader.php');
?>
<div class='main'>
	<h2>Return</h2>
	<p>Sales return</p>
	<hr>
	<table class='table'>
		<tr>
			<th>Customer name</th>
			<th>DO Number</th>
			<th></th>
		</tr>
<?php
	$sql_return = "SELECT id,customer_id,do_id FROM code_sales_return WHERE isfinished = '1' AND isassign = '0'";
	$result_return = $conn->query($sql_return);
	while($return = $result_return->fetch_assoc()){
?>
		<tr>
			<td><?php
				$sql_customer = "SELECT name FROM customer WHERE id = '" . $return['customer_id'] . "'";
				$result_customer = $conn->query($sql_customer);
				$customer =  $result_customer->fetch_assoc();
				echo $customer['name'];
			?></td>
			<td><?php
				$sql_do = "SELECT name FROM code_delivery_order WHERE id = '" . $return['do_id'] . "'";
				$result_do = $conn->query($sql_do);
				$do = $result_do->fetch_assoc();
				echo $do['name'];
			?></td>
			<td>
				<button type='button' class='btn btn-default' onclick='submiting(<?= $return['id'] ?>)'>Next</button>
				<form action='sales_return_validation.php' method='POST' id='form<?= $return['id'] ?>'>
					<input type='hidden' value='<?= $return['id'] ?>' name='id'>
				</form>
			</td>
		</tr>
<?php
	}
?>
<script>
	function submiting(n){
		$('#form' + n).submit();
	}
</script>