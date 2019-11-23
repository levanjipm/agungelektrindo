<?php
	//Confirming return dashboard//
	include('salesheader.php');
?>
	<div class='main'>
		<h2 style='font-family:bebasneue'>Sales return</h2>
		<p>Confirm sales return</p>
		<hr>
		<table class='table table-bordered'>
			<tr>
				<th>Delivery order date</th>
				<th>Delivery order number</th>
				<th>Submission date</th>
				<th>Customer</th>
				<th>Reason</th>
				<th colspan='2'></th>
			</tr>				
<?php
	$sql_return = "SELECT * FROM code_sales_return WHERE isconfirm = '0'";
	$result_return = $conn->query($sql_return);
	while($row_return = $result_return->fetch_assoc()){
		$do_id 		= $row_return['do_id'];
		$sql_do 	= "SELECT name,date FROM code_delivery_order WHERE id = '" . $do_id . "'";
		$result_do 	= $conn->query($sql_do);
		
		$row_do 	= $result_do->fetch_assoc();

		$do_name 	= $row_do['name'];
		$do_date 	= $row_do['date'];
		
		$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $row_return['customer_id'] . "'";
		$result_customer 	= $conn->query($sql_customer);
		$row_customer 		= $result_customer->fetch_assoc();
		
		$customer_name		= $row_customer['name'];
		
		if($row_return['reason'] != 5){
			$sql_reason 		= "SELECT name FROM reason WHERE id = '" . $row_return['reason'] . "'";
			$result_reason 		= $conn->query($sql_reason);
			$row_reason 		= $result_reason->fetch_assoc();
			
			$reason				= $row_reason['name'];
		} else {
			$reason				= '';
		}
?>
			<tr>
				<td><?= (date('d M Y',strtotime($do_date))) ?></td>
				<td><?= $do_name ?></td>
				<td><?= date('d M Y',strtotime($row_return['submission_date'])) ?></td>
				<td><?= $customer_name ?></td>
				<td><?= $reason	?></td>
				<td>
					<button type='button' class='button_default_dark' onclick='confirm_return(<?= $row_return['id'] ?>)'>Confirm</button>
					<form id='confirm_form<?= $row_return['id'] ?>' action='action_return.php' method='POST'>
						<input type='hidden' value='<?= $row_return['id'] ?>' name='return_id'>
						<input type='hidden' value='1' name='status'>
					</form>
				</td>
				<td>
					<button type='button' class='button_danger_dark' onclick='cancel_return(<?= $row_return['id'] ?>)'>Cancel</button>
					<form id='cancel_form<?= $row_return['id'] ?>' action='action_return.php' method='POST'>
						<input type='hidden' value='<?= $row_return['id'] ?>' name='return_id'>
						<input type='hidden' value='0' name='status'>
					</form>
				</td>
			</tr>
<?php
	}
?>
		</table>
<script>
	function confirm_return(n){
		$('#confirm_form' + n).submit();
	}
	function cancel_return(n){
		$('#cancel_form' + n).submit();
	}
</script>
	