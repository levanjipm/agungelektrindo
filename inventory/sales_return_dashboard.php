<?php
	//Sales return//
	include('inventoryheader.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p>Sales return</p>
	<hr>
<?php
	$sql_code = "SELECT id,submission_date,customer_id,do_id FROM code_sales_return WHERE isconfirm = '1' AND isdelete = '0' AND isfinished = '0'";
	$result_code = $conn->query($sql_code);
	if(mysqli_num_rows($result_code) == 0){
		echo ('There are no available document');
	} else {
?>
	<table class='table'>
		<tr>
			<th>Submission Date</th>
			<th>Customer</th>
			<th>Delivery Order</th>
			<th></th>
		</tr>
<?php
		while($code = $result_code->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($code['submission_date'])) ?></td>
			<td><?php
				$sql_customer = "SELECT name FROM customer WHERE id = '" . $code['customer_id'] . "'";
				$result_customer = $conn->query($sql_customer);
				$customer = $result_customer->fetch_assoc();
				echo $customer['name'];
			?></td>
			<td><?php
				$sql_do = 'SELECT name FROM code_delivery_order WHERE id = "' . $code['do_id'] . '"';
				$result_do = $conn->query($sql_do);
				$do = $result_do->fetch_assoc();
				echo $do['name'];
			?></td>
			<td>
				<button type='button' class='btn' onclick='submit(<?= $code['id'] ?>)'>Receive</button>
				<form action='sales_return_validation.php' method='POST' id='form<?= $code['id'] ?>'>
					<input type='hidden' value='<?= $code['id'] ?>' name='id'>
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