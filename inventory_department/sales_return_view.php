<?php
	include('../codes/connect.php');
	$sql			= "SELECT id,document,code_sales_return_id FROM code_sales_return_received WHERE isconfirm = '0'";
	$result			= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
	<p style='font-family:museo'>There is no return to confirm</p>
<?php
	} else {
?>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Customer</th>
				<th>Delivery order</th>
				<th>Return document</th>
				<th>Reason</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php
		while($row				= $result->fetch_assoc()){
			$return_id			= $row['id'];
			$document			= $row['document'];
			$code_return		= $row['code_sales_return_id'];
			$sql_code_return	= "SELECT do_id, reason, other FROM code_sales_return WHERE id = '$code_return'";
			$result_code_return	= $conn->query($sql_code_return);
			$row_return			= $result_code_return->fetch_assoc();
			
			$do_id				= $row_return['do_id'];
			$reason_id			= $row_return['reason'];
			$other_reason		= $row_return['other'];
			
			if($reason_id		!= 5){
				$sql_reason			= "SELECT * FROM reason WHERE id = '$reason_id'";
				$result_reason		= $conn->query($sql_reason);
				$row_reason			= $result_reason->fetch_assoc();
				
				$reason				= $row_reason['name'];
			} else {
				$reason				= $other_reason;
			}			
			
			$sql_do				= "SELECT customer_id, name FROM code_delivery_order WHERE id = '$do_id'";
			$result_do			= $conn->query($sql_do);
			$do					= $result_do->fetch_assoc();
			
			$do_name			= $do['name'];
			$customer_id		= $do['customer_id'];
			
			$sql_customer		= "SELECT name FROM customer WHERE id = '$customer_id'";
			$result_customer	= $conn->query($sql_customer);
			$customer			= $result_customer->fetch_assoc();
			
			$customer_name		= $customer['name'];
?>
			<tr>
				<td><?= $customer_name ?></td>
				<td><?= $do_name ?></td>
				<td><?= $document ?></td>
				<td><?= $reason ?></td>
				<td>
					<button class='button_success_dark' onclick='view_sales_return(<?= $return_id ?>)'><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
				</td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>
	<form action='sales_return_confirm_validation' method='POST' id='sales_return_form'>
		<input type='hidden' id='sales_return_id' name='id'>
	</form>
	<script>
		function view_sales_return(n){
			$('#sales_return_id').val(n);
			$('#sales_return_form').submit();
		};
	</script>
<?php
	}
?>