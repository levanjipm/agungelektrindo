<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Create sales invoice</title>
</head>
<script>
	$('#sales_invoice_side').click();
	$('#build_invoice_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Invoice</h2>
	<p style='font-family:museo'>Create sales invoice</p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>DO name</th>
			<th>Customer name</th>
			<th colspan='2'></th>
		</tr>
<?php
	$sql_invoice 				= "SELECT project_id, so_id, sent, id, date, name, customer_id, project_id, id
									FROM code_delivery_order
									WHERE isinvoiced = '0' AND company = 'AE'";
	$result_invoice 			= $conn->query($sql_invoice);
	while($invoice 				= $result_invoice->fetch_assoc()){
		
		$sent					= $invoice['sent'];
		$delivery_order_id		= $invoice['id'];
		$project_id				= $invoice['project_id'];
		$delivery_order_date	= $invoice['date'];
			
		$customer_id			= $invoice['customer_id'];
		$sales_order_id			= $invoice['so_id'];
		$sql_sales_order		= "SELECT type FROM code_salesorder WHERE id = '$sales_order_id'";
		$result_sales_order		= $conn->query($sql_sales_order);
		$sales_order			= $result_sales_order->fetch_assoc();
		
		$type					= $sales_order['type'];
		
		if($customer_id == 0 || $customer_id == NULL){
			$sql_customer 			= "SELECT code_salesorder.retail_name 
										FROM code_salesorder
										JOIN code_delivery_order ON code_delivery_order.so_id = code_salesorder.id
										WHERE code_delivery_order.id = '$delivery_order_id'";
			$result_customer 		= $conn->query($sql_customer);
			$customer	 			= $result_customer->fetch_assoc();
			$customer_name			= $customer['retail_name'];
		} else {
			$sql_customer 			= "SELECT name FROM customer WHERE id = '$customer_id'";
			$result_customer 		= $conn->query($sql_customer);
			$customer 				= $result_customer->fetch_assoc();
			
			$customer_name			= $customer['name'];
		}
?>
		<tr>
			<td><?= date('d M Y',strtotime($delivery_order_date)) ?></td>
			<td><?= $invoice['name'] ?></td>
			<td><?= $customer_name ?></td>
			<td>
				<button type='button' <?php if($sent == 1){ ?> class='button_default_dark' onclick='submiting(<?= $invoice['id'] ?>)' <?php } else { ?>  class='button_danger_dark' disabled <?php } ?>>Create Invoice</button>
			</td>
			<td><?php if($project_id != NULL){ echo ('Project invoice'); ?>
				<form style="padding:0px;margin:0px;width:100%" method="POST" action='build_invoice' id='do<?= $invoice['id'] ?>'>
					<input type='hidden' value='<?= $delivery_order_id ?>' name='delivery_order_id'>
				</form>
<?php } else if($type == 'SRVC'){	echo ('Service invoice'); ?>
				<form style="padding:0px;margin:0px;width:100%" method="POST" action='build_invoice' id='do<?= $invoice['id'] ?>'>
					<input type='hidden' value='<?= $delivery_order_id ?>' name='delivery_order_id'>
				</form>
<?php } else { echo ('Goods invoice'); ?>
				<form style="padding:0px;margin:0px;width:100%" method="POST" action='build_invoice' id='do<?= $invoice['id'] ?>'>
					<input type='hidden' value='<?= $delivery_order_id ?>' name='delivery_order_id'>
				</form>
<?php } ?>
			</td>
		</tr>
<?php } ?>
	</table>
</div>
<script>
	function submiting(n){
		$('#do' + n).submit();
	}
</script>