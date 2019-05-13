<?php
	//Confirming return dashboard//
	include('salesheader.php');
?>
	<div class='main'>
		<table class='table'>
			<tr>
				<th>Delivery order date</th>
				<th>Delivery order number</th>
				<th>Submission date</th>
				<th>Customer</th>
				<th>Reason</th>
				<th></th>
				<th></th>
			</tr>				
<?php
	$sql_return = "SELECT * FROM code_sales_return WHERE isconfirm = '0'";
	$result_return = $conn->query($sql_return);
	while($row_return = $result_return->fetch_assoc()){
?>
			<tr>
				<td><?php
					$do_id = $row_return['do_id'];
					$sql_do = "SELECT name,date FROM code_delivery_order WHERE id = '" . $do_id . "'";
					$result_do = $conn->query($sql_do);
					while($row_do = $result_do->fetch_assoc()){
						$do_name = $row_do['name'];
						$do_date = $row_do['date'];
					}
					echo (date('d M Y',strtotime($do_date)))
				?></td>
				<td><?= $do_name ?></td>
				<td><?= date('d M Y',strtotime($row_return['submission_date'])) ?></td>
				<td><?php
					$sql_customer = "SELECT name FROM customer WHERE id = '" . $row_return['customer_id'] . "'";
					$result_customer = $conn->query($sql_customer);
					while($row_customer = $result_customer->fetch_assoc()){
						echo $row_customer['name'];
					}
				?></td>
				<td><?php
					if($row_return['reason'] != 5){
						$sql_reason = "SELECT name FROM reason WHERE id = '" . $row_return['reason'] . "'";
						$result_reason = $conn->query($sql_reason);
						while($row_reason = $result_reason->fetch_assoc()){
							echo $row_reason['name'];
						}
					} else {
					}
				?></td>
				<td>
					<button type='button' class='btn btn-primary' onclick='confirm_return(<?= $row_return['id'] ?>)'>Confirm</button>
					<form id='confirm_form<?= $row_return['id'] ?>' action='action_return.php' method='POST'>
						<input type='hidden' value='<?= $row_return['id'] ?>' name='return_id'>
						<input type='hidden' value='1' name='status'>
					</form>
				</td>
				<td>
					<button type='button' class='btn btn-danger' onclick='cancel_return(<?= $row_return['id'] ?>)'>Cancel</button>
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
	