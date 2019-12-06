<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Sales return</p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Customer name</th>
			<th>Return document</th>
			<th>Return date</th>
			<th></th>
		</tr>
<?php
	$sql					= "SELECT code_sales_return_received.id, code_sales_return_received.document, code_sales_return_received.date, code_delivery_order.customer_id
								FROM code_sales_return_received 
								JOIN code_sales_return ON code_sales_return_received.code_sales_return_id = code_sales_return.id
								JOIN code_delivery_Order ON code_sales_return.do_id = code_delivery_order.id
								WHERE code_sales_return.isconfirm = '1' AND code_sales_return_received.isdone = '0'";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		$id					= $row['id'];
		$document			= $row['document'];
		$date				= $row['date'];
		$customer_id		= $row['customer_id'];
			
		$sql_customer		= "SELECT name FROM customer WHERE id = '$customer_id'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		$customer_name		= $customer['name'];
?>
		<tr>
			<td><?= $customer_name ?></td>
			<td><?= $document ?></td>
			<td><?= date('d M Y', strtotime($date)) ?></td>
			<td><button type='button' class='button_success_dark' onclick='submit_return(<?= $id ?>)'><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button></td>
		</tr>
<?php
	}
?>
	</table>
</div>
<form action='sales_return_validation' method='POST' id='sales_return_form'>
	<input type='hidden' id='sales_return_id' name='id'>
</form>
<script>
	function submit_return(n){
		$('#sales_return_id').val(n);
		$('#sales_return_form').submit();
	}
</script>