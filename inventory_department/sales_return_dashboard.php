<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Sales Return</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Sales return</p>
	<hr>
<?php
	$sql_code		= "SELECT DISTINCT(return_id) FROM sales_return WHERE isdone = '0'";
	$result_code	= $conn->query($sql_code);
	if(mysqli_num_rows($result_code) == 0){
		echo ('There are no available document');
	} else {
?>
	<table class='table table-bordered'>
		<tr>
			<th>Submission Date</th>
			<th>Customer</th>
			<th>Delivery Order</th>
			<th></th>
		</tr>
<?php
		while($code				= $result_code->fetch_assoc()){
			$return_id			= $code['return_id'];
			$sql				= "SELECT do_id, submission_date FROM code_sales_return WHERE id = '$return_id'";
			$result				= $conn->query($sql);
			$row				= $result->fetch_assoc();
			
			$delivery_order_id	= $row['do_id'];
			$submit_date		= $row['submission_date'];
			
			$sql_do				= "SELECT name, customer_id FROM code_delivery_order WHERE id = '$delivery_order_id'";
			$result_do			= $conn->query($sql_do);
			$do					= $result_do->fetch_assoc();
			
			$customer_id		= $do['customer_id'];
			$do_name			= $do['name'];
			
			$sql_customer 		= "SELECT name FROM customer WHERE id = '$customer_id'";
			$result_customer 	= $conn->query($sql_customer);
			$customer 			= $result_customer->fetch_assoc();
			
			$customer_name		= $customer['name'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($submit_date)) ?></td>
			<td><?= $customer_name ?></td>
			<td><?= $do_name ?></td>
			<td><button class='button_success_dark' onclick='submit(<?= $return_id ?>)'><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
				<form action='sales_return_validation' method='POST' id='form<?= $return_id ?>'>
					<input type='hidden' value='<?= $return_id ?>' name='id'>
				</form>
			</td>
		</tr>
<?php
		}
	}
?>
	</table>
</div>
<script>
	function submit(n){
		$('#form' + n).submit();
	}
</script>