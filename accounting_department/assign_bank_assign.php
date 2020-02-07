<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	if(empty($_POST['id'])){
?>
<script>
	window.location.href='/agungelektrindo/accounting';
</script>
<?php
	}
	$bank_id 		= $_POST['id'];
	$sql_bank 		= "SELECT * FROM code_bank WHERE id = '" . $bank_id . "'";
	$result_bank 	= $conn->query($sql_bank);
	$bank 			= $result_bank->fetch_assoc();

	$transaction 	= $bank['transaction'];
	$date 			= $bank['date'];
	$value 			= $bank['value'];
	$opponent_id 	= $bank['bank_opponent_id'];
	$opponent_type 	= $bank['label'];

	if($opponent_type == 'CUSTOMER'){
		$database = 'customer';
	} else if($opponent_type == 'SUPPLIER'){
		$database = 'supplier';
	} else if($opponent_type == 'OTHER'){
		$database = 'bank_account_other';
	};

	$sql_selector 		= "SELECT name FROM " . $database . " WHERE id = '" . $opponent_id . "'";
	$result_selector 	= $conn->query($sql_selector);
	$selector 			= $result_selector->fetch_assoc();
	
	$selector_name		= $selector['name'];
?>
<head>
	<title>Assign bank data</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank</h2>
	<p style='font-family:museo'>Assign bank data</p>
	<hr>
	<label>Transaction data</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>
	<p style='font-family:museo'><?= $selector_name . ' (' . $database . ')' ?></h2>
	<p>Rp. <span id='rupiah'><?= number_format($value,2) ?></span></p>
	<input type='hidden' value='<?= $value ?>' id='value_now' readonly>
	<form action='assign_bank_input' method='POST' id='myForm'>
	<input type='hidden' value='<?= $date ?>' name='date' readonly>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Invoice number</th>
			<th>Value</th>
			<th>Action</th>
			<th>Remaining</th>
		</tr>
<?php
	if($transaction == 1){
		$sql_opponent 		= "SELECT id FROM " . $database . " WHERE id = '" . $opponent_id . "'";
		$result_opponent 	= $conn->query($sql_opponent);
		$opponent 			= $result_opponent->fetch_assoc();
		
		$sql_invoice 		= "SELECT * FROM purchases WHERE supplier_id = '" . $opponent_id . "' AND isdone = '0'";
		$result_invoice 	= $conn->query($sql_invoice);
		$i = 1;
		while($invoices = $result_invoice->fetch_assoc()){
			$sql_paid 		= "SELECT SUM(value) AS paid FROM payable WHERE purchase_id = '" . $invoices['id'] . "'";
			$result_paid 	= $conn->query($sql_paid);
			$paid 			= $result_paid->fetch_assoc();
			$received 		= $paid['paid'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($invoices['date'])) ?></td>
			<td><?= $invoices['name']; ?></td>
			<td><?= number_format(($invoices['value'] - $received),2) ?></td>
			<td>
				<div class="checkbox">
					<label><input type="checkbox" id="check-<?= $i ?>" onchange="add(<?= $i ?>)" name='check[<?= $invoices['id'] ?>]'></label>
				</div>
				<input type='hidden' value='<?= $invoices['value'] - $received ?>' id='angka<?= $i ?>' readonly>
			</td>
			<td>
				Rp. <span id='remain-<?= $i ?>'><?= number_format(($invoices['value'] - $received),2) ?></span>
				<input type='hidden' value='<?= $invoices['value'] - $received ?>' id='remaining-<?= $i ?>' name='remaining[<?= $invoices['id'] ?>]' readonly>
			</td>
		</tr>
<?php
		$i++;
		}
?>
<script>
	function add(n){
		if($('#check-' + n).prop('checked')){
			var pengurang = parseFloat($('#angka' + n).val());
			var value_now = parseFloat($('#value_now').val());
			if($('#value_now').val() > pengurang){
				$('#remain-' + n).html(numeral(0).format('0,0.00'));
				$('#remaining-' + n).val(0);
				$('#value_now').val(value_now - pengurang);
				$('#rupiah').html(numeral($('#value_now').val()).format('0,0.00'));
			} else {
				$('#remain-' + n).html(numeral(pengurang - value_now).format('0,0.00'));
				$('#remaining-' + n).val(pengurang - value_now);
				$('#value_now').val(0);	
				$('#rupiah').html(numeral($('#value_now').val()).format('0,0.00'));
			}
			if($('#value_now').val() == 0){
				$("input:checkbox:not(:checked)").attr('disabled',true);
				$('input:checkbox(:checked)').attr('disabled',false);
			} else {
				$('input:checkbox(:checked)').attr('disabled',false);
			}
		} else {
			var pengurang = parseFloat($('#angka' + n).val());
			var value_now = parseFloat($('#value_now').val());
			var remaining = parseFloat($('#remaining-' + n).val());
			$('#value_now').val(value_now + pengurang - remaining);
			$('#rupiah').html(numeral($('#value_now').val()).format('0,0.00'));
			$('#remain-' + n).html(numeral(pengurang).format('0,0.00'));
			$('#remaining-' + n).val(pengurang);
			if($('#value_now').val() != 0){
				$('input[type=checkbox]').attr('disabled',false);
			}
			
		}
	}
	function validate(){
		$('#myForm').submit();
	}
</script>
<?php
	} else {
		$sql_invoice = "SELECT invoices.id, invoices.date, invoices.name, invoices.ongkir, invoices.value, code_delivery_order.customer_id
						FROM invoices 
						JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
						WHERE code_delivery_order.customer_id = '" . $opponent_id . "' AND invoices.isdone = '0' ";
		$result_invoice = $conn->query($sql_invoice);
		$i = 1;
		while($invoices = $result_invoice->fetch_assoc()){
			$sql_paid = "SELECT SUM(value) AS paid FROM receivable WHERE invoice_id = '" . $invoices['id'] . "'";
			$result_paid = $conn->query($sql_paid);
			$paid = $result_paid->fetch_assoc();
			$received = $paid['paid'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($invoices['date'])) ?></td>
			<td><?= $invoices['name']; ?></td>
			<td><?= number_format(($invoices['value'] + $invoices['ongkir'] - $received),2) ?></td>
			<td>
				<div class="checkbox">
					<label><input type="checkbox" id="check-<?= $i ?>" onchange="add(<?= $i ?>)" name='check[<?= $invoices['id'] ?>]'></label>
				</div>
				<input type='hidden' value='<?= $invoices['value'] + $invoices['ongkir'] - $received ?>' id='angka<?= $i ?>' readonly>
			</td>
			<td>
				Rp. <span id='remain-<?= $i ?>'><?= number_format(($invoices['value'] + $invoices['ongkir'] - $received),2) ?></span>
				<input type='hidden' value='<?= ($invoices['value'] + $invoices['ongkir'] - $received) ?>' id='remaining-<?= $i ?>' name='remaining[<?= $invoices['id'] ?>]' readonly>
			</td>
		</tr>
<?php
			$i++;
		}
?>
<script>
	function add(n){
		if($('#check-' + n).prop('checked')){
			var pengurang = parseFloat($('#angka' + n).val());
			var value_now = parseFloat($('#value_now').val());
			if($('#value_now').val() > pengurang){
				$('#remain-' + n).html(numeral(0).format('0,0.00'));
				$('#remaining-' + n).val(0);
				$('#value_now').val(value_now - pengurang);
				$('#rupiah').html(numeral($('#value_now').val()).format('0,0.00'));
			} else {
				$('#remain-' + n).html(numeral(pengurang - value_now).format('0,0.00'));
				$('#remaining-' + n).val(pengurang - value_now);
				$('#value_now').val(0);	
				$('#rupiah').html(numeral($('#value_now').val()).format('0,0.00'));
			}
			if($('#value_now').val() == 0){
				$("input:checkbox:not(:checked)").attr('disabled',true);
				$('input:checkbox(:checked)').attr('disabled',false);
			} else {
				$('input:checkbox(:checked)').attr('disabled',false);
			}
		} else {
			var pengurang = parseFloat($('#angka' + n).val());
			var value_now = parseFloat($('#value_now').val());
			var remaining = parseFloat($('#remaining-' + n).val());
			$('#value_now').val(value_now + pengurang - remaining);
			$('#rupiah').html(numeral($('#value_now').val()).format('0,0.00'));
			$('#remain-' + n).html(numeral(pengurang).format('0,0.00'));
			$('#remaining-' + n).val(pengurang);
			if($('#value_now').val() != 0){
				$('input[type=checkbox]').attr('disabled',false);
			}
			
		}
	}
	function validate(){
		$('#myForm').submit();
	}
</script>
<?php
	}
?>
	</table>
	
<input type='hidden' name='tt' value='<?= $i ?>' readonly>
<input type='hidden' name='bank_id' value='<?= $bank_id ?>' readonly>
<button type='button' class='button_success_dark' onclick='validate()'>Submit</button>
</form>
</div>