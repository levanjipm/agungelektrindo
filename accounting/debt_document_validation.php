<?php
	include('accountingheader.php');
	$supplier_id = $_POST['supplier'];
	$date = $_POST['date'];
	$x = $_POST['x'];
	//Checking the document//
	$check_invoice = 1;
	$check_po = 1;
	$i = 1;
	for($i = 1; $i < $x; $i++){
		$document = $_POST['document' . $i];
		if($_POST['final' . $i] != 0){
			$sql = "SELECT isinvoiced,po_id FROM code_goodreceipt WHERE id = '" . $document . "'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			if($row['isinvoiced'] == 1){
				$check_invoice++;
				break;
			}
			if($i == 1){
				$po_id = $row['po_id'];
			} else {
				if($po_id == $row['po_id']){
				} else {
					$check_po++;
					break;
				}
			}
		} else {
			$jumlah_invoice++;
		}
	}
	if($check_invoice > 1 || $check_po > 1){
		header('location:debt_document_dashboard.php');
	}
	$sql_po = "SELECT taxing FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_po = $conn->query($sql_po);
	$po = $result_po->fetch_assoc();
	$taxing=  $po['taxing'];
	//if it exist, then show the items//
?>
<script src='../universal/Numeral-js-master/numeral.js'></script>
<script src='../universal/jquery/jquery.inputmask.bundle.js'></script>
<div class='main'>
	<form action='debt_document_input.php' method='POST' id='debt_form'>
	<input type='hidden' value='<?= $supplier_id ?>' name='supplier'>
	<input type='hidden' value='<?= $date ?>' name='date'>
	<label>Input invoice number</label>
	<input type='text' class='form-control' name='invoice_doc' id='inv'>
<?php
	if($taxing == 1){
?>
	<label>Input tax document number</label>
	<input type='text' class='form-control' name='tax_doc' id='fp'>
<?php
	}
?>
	<table class='table'>
		<tr>
			<th style='width:50%'>Item name</th>
			<th style='width:10%'>Quantity</th>
			<th>Price</th>
		</tr>
<?php
	$i = 1;
	$b = 1;
	for($i = 1; $i < $x; $i++){
		$document = $_POST['document' . $i];
		if($_POST['final' . $i] == 1){
			$sql_upper = "SELECT id FROM code_goodreceipt WHERE id = '" . $document . "'";
			$result_upper = $conn->query($sql_upper);
			$upper = $result_upper->fetch_assoc();
?>
		<input type='hidden' value='<?= $document ?>' name='gr<?= $i ?>'>
<?php
			$sql_general = "SELECT purchaseorder.reference,purchaseorder.price_list,purchaseorder.discount,purchaseorder.unitprice, 
			goodreceipt.id,goodreceipt.quantity FROM goodreceipt 
			INNER JOIN purchaseorder 
			ON purchaseorder.id = goodreceipt.received_id 
			WHERE goodreceipt.gr_id = '" . $upper['id'] . "'";
			$result_general = $conn->query($sql_general);
			while($general = $result_general->fetch_assoc()){
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $general['reference'] . "'";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
?>
		<tr>
			<td><?= $general['reference'] . " - " . $item['description'] ?></td>
			<td>
				<?= $general['quantity'] ?>
				<input type='hidden' value='<?= $general['quantity'] ?>' name='quantity<?= $b ?>'>
				<input type='hidden' value='<?= $general['id'] ?>' name='id<?= $b ?>'>
			</td>
			<td>
				<button type='button' style='background-color:transparent;border:none' onclick='show(<?= $b ?>)' id='button-<?= $b ?>'>Rp. <?= number_format($general['unitprice'],2) ?></button>
				<input type='number' value='<?= $general['unitprice'] ?>' id='input<?= $b ?>' style='display:none' onfocusout='hide(<?= $b ?>)' class='form-control' name='input<?= $b ?>'>
			</td>			
		</tr>
<?php
		$b++;
			}
		}	
	}
?>
	</table>
	<input type='hidden' value='<?= $x ?>' name='x'>
	<input type='hidden' value='<?= $b ?>' name='b'>
	</form>
	<button type='button' class='btn btn-default' onclick='hitungin()'>Calculate</button>
<script>
	$("#fp").inputmask("999.999.99-99999999");
	function show(n){
		$('#input' + n).show();
		$('#input' + n).focus();
		$('#button-' + n).hide();
	}
	function hide(n){
		$('#input' + n).hide();
		$('#button-' + n).text('Rp. ' + numeral($('#input' + n).val()).format('0,0.00'));
		$('#button-' + n).show();
	}
	function hitungin(){
		if($('#inv').val() == ''){
			alert('Insert correct document number!');
			return false;
		} else if(<?= $taxing ?> == 1 && $('#fp').val() == ''){
			alert('Please insert correct tax document number');
			return false;
		} else {
			$('#debt_form').submit();
		}
	}
</script>			