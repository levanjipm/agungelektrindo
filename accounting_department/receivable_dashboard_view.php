<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	
	$customer_id			= $_GET['id'];
	$sql_customer 			= "SELECT name,address,city FROM customer WHERE id = '$customer_id'";
	$result_customer 		= $conn->query($sql_customer);
	$customer 				= $result_customer->fetch_assoc();
		
	$customer_name			= $customer['name'];
	$customer_address		= $customer['address'];
	$customer_city			= $customer['city'];
?>
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<label>Unpaid invoice</label>
	<p id='unpaid_invoice_total'></p>
	<br>
<?php
	$total_unpaid			= 0;
	$sql_invoice_detail 	= "SELECT invoices.id, invoices.date, invoices.name AS invoice_name, invoices.value, invoices.ongkir 
								FROM invoices
								JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
								WHERE code_delivery_order.customer_id = '$customer_id' AND invoices.isdone = '0'";
	$result_invoice_detail 	= $conn->query($sql_invoice_detail);
	if(mysqli_num_rows($result_invoice_detail) == 0){
?>
	<p style='font-family:museo'>There is no unpaid invoice</p>
<?php
	} else {
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Invoice number</th>
			<th>Value</th>
		</tr>
<?php
	while($invoice_detail 	= $result_invoice_detail->fetch_assoc()){
		 $sql_receivable	= "SELECT SUM(value) AS paid FROM receivable WHERE invoice_id = '" . $invoice_detail['id'] . "'";
		 $result_receivable	= $conn->query($sql_receivable);
		 $receivable		= $result_receivable->fetch_assoc();
		 $paid				= $receivable['paid'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($invoice_detail['date'])) ?></td>
			<td><?= $invoice_detail['invoice_name'] ?></td>
			<td>Rp. <?= number_format($invoice_detail['value'] + $invoice_detail['ongkir'] - $paid,2) ?></td>
		</tr>
<?php
		$total_unpaid		+= $invoice_detail['value'] + $invoice_detail['ongkir'] - $paid;
	}
?>
	</table>
	
	<a href='customer_view.php?id=<?= $customer_id ?>' style='text-decoration:none'>
		<button class='button_success_dark'><i class='fa fa-eye'></i></button>
	</a>
</div>
<?php
	}
?>
<script>
	$(document).ready(function(){
		$('#unpaid_invoice_total').html('Rp. ' + numeral(<?= $total_unpaid ?>).format('0,0.00'));
	});
</script>