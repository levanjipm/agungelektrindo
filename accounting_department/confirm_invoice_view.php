<?php
	include('../codes/connect.php');
	
	$sql_invoice = "SELECT invoices.id,invoices.date, invoices.name, code_delivery_order.customer_id FROM invoices 
					JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
					WHERE invoices.isconfirm = '0' AND code_delivery_order.company = 'AE'";
	$result_invoice = $conn->query($sql_invoice);
	if(mysqli_num_rows($result_invoice) > 0){
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Invoice name</th>
			<th>Customer</th>
			<th></th>
		</tr>
<?php
	
	while($row_invoice = $result_invoice->fetch_assoc()){
		$invoice_id			= $row_invoice['id'];
		$customer_id 		= $row_invoice['customer_id'];
		$invoice_date		= $row_invoice['date'];
		$invoice_name		= $row_invoice['name'];
		
		$sql_customer	 	= "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($invoice_date)); ?></td>
			<td><?= $invoice_name ?></td>
			<td><?= $customer_name ?></td>
			<td>
				<button type='button' class='button_default_dark' onclick='confirming(<?= $invoice_id ?>)'><i class='fa fa-check-square-o'></i></button>
			</td>
		</tr>
<?php
	}
?>
	</table>
<script>
	function confirming(n){
		$.ajax({
			url:'confirm_invoice',
			data:{
				invoice_id:n
			},
			type:'POST',
			success:function(response){
				$('#confirm_invoice_wrapper .full_screen_box').html(response);
				$('#confirm_invoice_wrapper').fadeIn();
			}
		});
	}
</script>
<?php
	} else {
?>
	<p style='font-family:museo'>There is no invoice to be confirmed</p>
<?php
	}
?>
</div>