<?php
	include('accountingheader.php');
	if(empty($_POST['invoice_id'])){
		header('accounting.php');
	}
	$invoice_id = $_POST['invoice_id'];
	$sql_invoice = "SELECT name,faktur FROM invoices WHERE id = '" . $invoice_id . "'";
	$result_invoice = $conn->query($sql_invoice);
	$invoice = $result_invoice->fetch_assoc();
	$faktur = $invoice['faktur'];
	$invoice_name = $invoice['name'];
?>
<div class='main'>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
	<form method='POST' action='edit_invoice.php' id='myForm'>
	<h2>Edit invoice</h2>
	<select class='form-control' id='select_method' onchange='show_auto()' name='select_method'>
		<option value='0'>Choose method of data input</option>
		<option value='1'>Edit discount</option>
		<option value='2'>Edit price</option>
	</select>
<?php
	if($faktur != ''){
?>
	<label>Faktur pajak</label>
	<input type='text' class='form-control' id='piash' name='faktur' value='<?= $faktur ?>'>
	<script>
		$("#piash").inputmask("999.999.99-99999999");
	</script>
<?php
	}
?>
	<hr>
	<table class='table'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Price List</th>
			<th>Discount</th>
			<th>Price</th>
		</tr>
<?php
	$do_name = 'SJ-AE-' . substr($invoice_name,6,100);
	$sql_code_do = "SELECT id,so_id FROM code_delivery_order WHERE name = '" . $do_name . "' LIMIT 1";
	$result_code_do = $conn->query($sql_code_do);
	$row_code_do = $result_code_do->fetch_assoc();
	$do_id = $row_code_do['id'];
	$so_id = $row_code_do['so_id'];
	$i = 1;
	$sql_do = "SELECT reference,quantity FROM delivery_order WHERE do_id = '" . $do_id . "'";
	$result_do = $conn->query($sql_do);
	while($do = $result_do->fetch_assoc()){
?>
		<tr>
			<td>
				<?= $do['reference']; ?>
				<input type='hidden' value='<?= $do['reference'] ?>' name='reference<?= $i?>'>
			</td>
			<td><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $do['reference'] . "' LIMIT 1";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td>
				<?= $do['quantity'] ?>
				<input type='hidden' value='<?= $do['quantity'] ?>' name='qty<?= $i ?>' readonly>
			</td>
			<td><?php
				$sql_invoice = "SELECT price,price_list,discount FROM sales_order WHERE so_id = '" . $so_id . "' AND reference = '" . $do['reference'] . "'";
				$result_invoice = $conn->query($sql_invoice);
				$row_invoice = $result_invoice->fetch_assoc();
				echo $row_invoice['price_list'];
			?>
			<input type='number' class='form-control' value='<?= $row_invoice['price_list']; ?>' name='pl<?= $i ?>' id='pl<?= $i ?>' style='display:none'></td>
			<td>
				<p id='hide_disc<?= $i ?>'><?= number_format($row_invoice['discount'],2) ?> %</p>
				<input type='number' class='form-control' name='discount<?= $i ?>' value='<?= $row_invoice['discount']; ?>' style='display:none' id='discount<?= $i ?>'>
			</td>
			<td>
				<p id='hide_price<?= $i ?>'><?= number_format($row_invoice['price'],2) ?></p>
				<input type='number' class='form-control' id='price<?= $i ?>' value='<?= $row_invoice['price']; ?>'  name='price<?= $i ?>'style='display:none'>
			</td>
		</tr>
<?php
	$pricelist[$i] = $row_invoice['price_list'];
	$discount[$i] = $row_invoice['discount'];
	$price[$i] = $row_invoice['price'];
	$i++;
	}
?>
	</table>
	<br><br>
	<input type='hidden' value='<?= $i ?>' name='x'>
	<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
	<button type='button' class='btn btn-primary' onclick='cek_same()'>Edit Invoice</button>
	</form>
</div>
<script>
function show_auto(){
	if($('#select_method').val() == 1){
		$('input[id^=discount]').show();
		$('p[id^=hide_disc]').hide();
		$('input[id^=price]').hide();
		$('p[id^=hide_price]').show();
	} else if($('#select_method').val() == 2){
		$('input[id^=discount]').hide();
		$('p[id^=hide_disc]').show();
		$('input[id^=price]').show();
		$('p[id^=hide_price]').hide();
	}
};
function cek_same(){
	if($('#select_method').val() == 0){
		alert("Please select method");
		return false;
		$('#select_method').focus();
	}
	var z = 1;
	var nilai = 0;
	if($('#piash').val().length != 19){
		alert('Incorrect format!');
		return false;
	}
	if($('#piash').val() == '<?= $faktur ?>'){
		nilai++;
	}
	if($('#select_method').val() == 2){
		for(z = 1; z < <?= $i ?>; z++){
			var maximum = <?= json_encode($pricelist) ?>;
			if($('#pl' + z).val() == maximum[z]){
				nilai++;
			};
		}
	} else if($('#select_method').val() == 1){
		for(z = 1; z < <?= $i ?>; z++){
			var discount = <?= json_encode($discount) ?>;
			if($($('#discount' + z).val() == discount[z]){
				nilai++;
			};
		}
	} else {
		alert('Please insert correct method');
		return false;
	};
	
	if(nilai == <?= $i ?>){
		alert('Cannot procced, there are no changes detected');
		return false;
	} else {
		$('#myForm').submit();
	}
}
</script>