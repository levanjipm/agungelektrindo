<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
	
	$supplier_id		= $_GET['id'];
	$sql_supplier		= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier	= $conn->query($sql_supplier);
	$supplier			= $result_supplier->fetch_assoc();
	
	$supplier_name		= $supplier['name'];
	$supplier_address	= $supplier['address'];
	$supplier_city		= $supplier['city'];
?>
<head>
	<title>Create payment</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Create payment</h2>
	<p style='font-family:museo'><?= $supplier_name	?></p>	
	<p style='font-family:museo'><?= $supplier_address ?></p>	
	<p style='font-family:museo'><?= $supplier_city ?></p>
	
	<label>To be paid</label>
	<p style='font-family:museo' id='payment'>Rp. 0.00</p>
	<input type='hidden' value='0' id='payment_value'>
	
	<table class='table table-bordered'>
		<tr>
			<th>Invoice date</th>
			<th>Overdue date</th>
			<th>Invoice name</th>
			<th>Tax document</th>
			<th>Value</th>
		</tr>
<?php
	$sql				= "SELECT * FROM purchases WHERE isdone = '0' AND supplier_id = '$supplier_id' ORDER BY date ASC";
	$result				= $conn->query($sql);
	while($row			= $result->fetch_assoc()){
		$id				= $row['id'];
		$date			= $row['date'];
		$value			= $row['value'];
		$faktur			= $row['faktur'];
		$name			= $row['name'];
		
		$sql_gr			= "SELECT code_purchaseorder.top FROM code_purchaseorder
							JOIN code_goodreceipt ON code_goodreceipt.po_id = code_purchaseorder.id
							WHERE invoice_id = '$id'";
		$result_gr		= $conn->query($sql_gr);
		$gr				= $result_gr->fetch_assoc();
		$top			= $gr['top'];
		
		if($top			== ''){
			$overdue_date	= date('Y-m-d', strtotime("+7 day", strtotime($date)));
		} else {
			$overdue_date	= date('Y-m-d', strtotime("+" . $top . " day", strtotime($date)));
			
		}
		
		$sql_payable	= "SELECT SUM(value) as paid FROM payable WHERE purchase_id = '$id'";
		$result_payable	= $conn->query($sql_payable);
		$row_payable	= $result_payable->fetch_assoc();
		
		$payable		= $row_payable['paid'];
?>
		<tr>
			<td><?= date('d M Y', strtotime($date)) ?></td>
			<td <?php if($overdue_date < date('Y-m-d')){ echo "class='danger'"; } else { echo "class='success'"; }; ?>><?= date('d M Y',strtotime($overdue_date)) ?></td>
			<td><?= $name ?></td>
			<td><?= $faktur ?></td>
			<td>Rp. <?= number_format($value - $payable,2) ?></td>
			<td><input type='checkbox' id='checkbox-<?= $id ?>' value='<?= $value ?>' onchange='update_payment(<?= $id ?>)'></td>
		</tr>	
<?php
	}
?>
	</table>
</div>
<script>
	function update_payment(n){
		if($('#checkbox-' + n).prop( "checked" )){
			var initial_payment = parseFloat($('#payment_value').val());
			var this_value		= parseFloat($('#checkbox-' + n).val());
			
			var final_value		= initial_payment + this_value;
			$('#payment_value').val(final_value);
			$('#payment').text('Rp. ' + numeral(final_value).format('0,0.00'));
		} else {
			var initial_payment = parseFloat($('#payment_value').val());
			var this_value		= parseFloat($('#checkbox-' + n).val());
			
			var final_value		= initial_payment - this_value;
			$('#payment_value').val(final_value);
			$('#payment').text('Rp. ' + numeral(final_value).format('0,0.00'));
		}
	};
</script>