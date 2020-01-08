<?php
	include('../codes/connect.php');
	$month 					= $_POST['month'];
	$year 					= $_POST['year'];
	
	$sql_invoice 			= "SELECT invoices.id, invoices.value, invoices.ongkir, invoices.name, invoices.date, invoices.faktur,
								code_delivery_order.customer_id, code_salesorder.retail_name
								FROM invoices
								JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
								JOIN code_salesorder ON code_salesorder.id = code_delivery_order.so_id
								WHERE MONTH(invoices.date) = '" . $month . "' AND YEAR(invoices.date) = '" . $year . "' AND invoices.isconfirm = '1'";
	$result_invoice 		= $conn->query($sql_invoice);
	while($invoice 			= $result_invoice->fetch_assoc()){
		$invoice_date		= $invoice['date'];
		$invoice_id			= $invoice['id'];
		$date				= $invoice['date'];
		$faktur				= $invoice['faktur'];
		if($faktur			== '' ){
			$faktur_text	= 'Non Pajak';
		} else {
			$faktur_text	= $faktur;
		}
		
		$invoice_name		= $invoice['name'];
		$invoice_value		= $invoice['value'];
		$invoice_delivery	= $invoice['ongkir'];
		
		$customer_id		= $invoice['customer_id'];
		
		if($customer_id		== NULL){
			$customer_name	= $invoice['retail_name'];
		} else {
			$sql_customer		= "SELECT name FROM customer WHERE id = '$customer_id'";
			$result_customer	= $conn->query($sql_customer);
			$customer			= $result_customer->fetch_assoc();
			
			$customer_name		= $customer['name'];	
		}		
?>
	<tr>
		<td><?= date('d M Y',strtotime($invoice_date)); ?></td>
		<td><?= $faktur_text ?></td>
		<td><?= $invoice_name ?></td>
		<td><?= $customer_name ?></td>
		<td>Rp. <?= number_format($invoice_value + $invoice_delivery,2) ?></td>
		<td>
			<button class='button_success_dark' onclick='submit_form_edit(<?= $invoice_id ?>)'>
				<i class="fa fa-pencil" aria-hidden="true"></i>
			</button>
		</td>
	</tr>
	
<?php
	}
?>