<?php
include('accountingheader.php');
if(empty($_POST['id'])){
	header('localtion:accounting.php');
}
	$bank_id = $_POST['id'];
	$sql_bank = "SELECT * FROM code_bank WHERE id = '" . $bank_id . "'";
	$result_bank = $conn->query($sql_bank);
	$bank = $result_bank->fetch_assoc();
	$transaction = $bank['transaction'];
	$date = $bank['date'];
	$value = $bank['value'];
	$lawan = $bank['name'];
?>
<script src='../universal/Numeral-js-master/src/numeral.js'></script>
<div class='main'>
	<div class='container'>
	<h2>Rp. <span id='rupiah'><?= number_format($value,2) ?></span></h2>
	<input type='hidden' value='<?= $value ?>' id='value_now' readonly>
	</div>
	<form action='assign_bank_input.php' method='POST' id='myForm'>
	<input type='hidden' value='<?= $date ?>' name='date' readonly>
	<table class='table table-hover'>
		<tr>
			<th>Date</th>
			<th>Invoice number</th>
			<th>Value</th>
			<td></td>
			<td>Remaining</td>
		</tr>
<?php
	if($transaction == 1){
		$sql_supplier = "SELECT id FROM supplier WHERE name = '" . $lawan . "'";
		$result_supplier = $conn->query($sql_supplier);
		$supplier = $result_supplier->fetch_assoc();
		$sql_invoice = "SELECT * FROM purchases WHERE supplier_id = '" . $supplier['id'] . "'";
		$result_invoice = $conn->query($sql_invoice);
		$i = 1;
		while($invoices = $result_invoice->fetch_assoc()){
?>
		<tr>
			<input type='hidden' value='<?= $invoices['id'] ?>' name='id<?= $i ?>'>
			<td><?= $invoices['date'] ?></td>
			<td><?= $invoices['name']; ?></td>
			<td><?= number_format(($invoices['value']),2) ?></td>
			<td>
				<div class="checkbox">
					<label><input type="checkbox" id="check-<?= $i ?>" onchange="add(<?= $i ?>)" name='check<?= $i ?>'></label>
				</div>
				<input type='hidden' value='<?= $invoices['value'] ?>' id='angka<?= $i ?>' readonly>
			</td>
			<td>
				Rp. <span id='remain-<?= $i ?>'><?= number_format(($invoices['value']),2) ?></span>
				<input type='hidden' value='<?= $invoices['value'] ?>' id='remaining-<?= $i ?>' name='remaining<?= $i ?>' readonly>
			</td>
		</tr>
<?php
		}
	} else {
		$sql_customer = "SELECT id FROM customer WHERE name = '" . $lawan . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
		
		$sql_invoice = "SELECT * FROM invoices WHERE customer_id = '" . $customer['id'] . "' AND isdone = '0' ";
		$result_invoice = $conn->query($sql_invoice);
		$i = 1;
		while($invoices = $result_invoice->fetch_assoc()){
?>
		<tr>
			<input type='hidden' value='<?= $invoices['id'] ?>' name='id<?= $i ?>'>
			<td><?= $invoices['date'] ?></td>
			<td><?= $invoices['name']; ?></td>
			<td><?= number_format(($invoices['value'] + $invoices['ongkir']),2) ?></td>
			<td>
				<div class="checkbox">
					<label><input type="checkbox" id="check-<?= $i ?>" onchange="add(<?= $i ?>)" name='check<?= $i ?>'></label>
				</div>
				<input type='hidden' value='<?= $invoices['value'] + $invoices['ongkir'] ?>' id='angka<?= $i ?>' readonly>
			</td>
			<td>
				Rp. <span id='remain-<?= $i ?>'><?= number_format(($invoices['value'] + $invoices['ongkir']),2) ?></span>
				<input type='hidden' value='<?= ($invoices['value'] + $invoices['ongkir']) ?>' id='remaining-<?= $i ?>' name='remaining<?= $i ?>' readonly>
			</td>
		</tr>
<?php
		$i++;
		}
		
	}
?>
	</table>
	
<input type='hidden' name='tt' value='<?= $i ?>' readonly>
<input type='hidden' name='bank_id' value='<?= $bank_id ?>' readonly>
<button type='button' class='btn btn-default' onclick='validate()'>Submit</button>
</form>
</div>
<script>
	function add(n){
		if($('#check-' + n).prop('checked')){
			var pengurang = parseInt($('#angka' + n).val());
			var value_now = parseInt($('#value_now').val());
			if($('#value_now').val() > pengurang){
				$('#remain-' + n).html(numeral(0).format(0,0.00));
				$('#remaining-' + n).val(0);
				$('#value_now').val(value_now - pengurang);
				$('#rupiah').html(numeral($('#value_now').val()).format(0,0.00));
			} else {
				$('#remain-' + n).html(numeral(pengurang - value_now).format(0,0.00));
				$('#remaining-' + n).val(pengurang - value_now);
				$('#value_now').val(0);	
				$('#rupiah').html(numeral($('#value_now').val()).format(0,0.00));
			}
			if($('#value_now').val() == 0){
				$("input:checkbox:not(:checked)").attr('disabled',true);
				$('input[type=checkbox]').prop('checked').attr('disabled',false);
			} else {
				$('input[type=checkbox]').prop('checked').attr('disabled',false);
			}
		} else {
			var pengurang = parseInt($('#angka' + n).val());
			var value_now = parseInt($('#value_now').val());
			var remaining = parseInt($('#remaining-' + n).val());
			$('#value_now').val(value_now + pengurang - remaining);
			$('#rupiah').html(numeral($('#value_now').val()).format(0,0.00));
			$('#remain-' + n).html(numeral(pengurang).format(0,0.00));
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