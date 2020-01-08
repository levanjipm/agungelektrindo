<?php
	include('../codes/connect.php');
	$month 					= $_POST['month'];
	$year 					= $_POST['year'];
	
	$sql_invoice 			= "SELECT id, value, name, date, faktur, supplier_id FROM purchases
								WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "' AND isconfirm = '1'";
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
		
		$supplier_id		= $invoice['supplier_id'];
		
		$sql_supplier		= "SELECT name FROM supplier WHERE id = '$supplier_id'";
		$result_supplier	= $conn->query($sql_supplier);
		$supplier			= $result_supplier->fetch_assoc();
		
		$supplier_name		= $supplier['name'];	
?>
	<tr>
		<td><?= date('d M Y',strtotime($invoice_date)); ?></td>
		<td><?= $faktur_text ?></td>
		<td><?= $invoice_name ?></td>
		<td><?= $supplier_name ?></td>
		<td>Rp. <?= number_format($invoice_value,2) ?></td>
		<td>
			<button class='button_success_dark' onclick='submit_form_edit(<?= $invoice_id ?>)'>
				<i class="fa fa-pencil" aria-hidden="true"></i>
			</button>
		</td>
	</tr>
	
<?php
	}
?>