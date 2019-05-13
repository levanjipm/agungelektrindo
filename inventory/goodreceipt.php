<?php
	include('inventoryheader.php');
	if (empty($_POST['po'])){
		header('location:goodreceipt_dashboard.php');
	} else{
	$date = $_POST['date'];
	//If there was no purchase from the purchasing department, redirect to initial//
	$po_id = $_POST['po'];
	//Get supplier name//
	$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $_POST['supplier'] . "'";
	$result_supplier = $conn->query($sql_supplier);
	while($row_supplier = $result_supplier->fetch_assoc()){
		$supplier_name = $row_supplier['name'];
	}
	//Get purchaseorder unique name from database//
	$sql_po = "SELECT name FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_po = $conn->query($sql_po);
	while($row_po = $result_po->fetch_assoc()){
		$po_name = $row_po['name'];
	}
?>
<div class="main" style="padding:20px">
	<div style="text-align:center">
		<h2><b><?= $supplier_name ?></b></h2>
		<h3><?= $po_name ?></h2>
	</div>
	<br><br>
<?php
	$sql = "SELECT purchaseorder.reference, purchaseorder.purchaseorder_id,purchaseorder_received.id, purchaseorder.quantity, purchaseorder_received.quantity AS received, purchaseorder_received.status, purchaseorder.id 
	FROM purchaseorder_received INNER JOIN purchaseorder ON purchaseorder_received.id = purchaseorder.id WHERE purchaseorder_received.status = '0' AND purchaseorder.purchaseorder_id = '" . $po_id . "'";
	$result = $conn->query($sql);
?>
<form action="goodreceipt_validation.php" method="POST" id="myForm">
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4">
			<label>Document number</label>
			<input type="text" name="document" class="form-control" id="document">
		</div>
	</div>
	<br><br>
	<table class="table">
		<thead>
			<th style="width:30%">Item name</th>
			<th style="width:10%">Ordered</th>
			<th style="width:10%">Received</th>
			<th style="width:20%">Item Received</th>
		</thead>
		<tbody>
<?php
	$x = 1;
	while($row = $result->fetch_assoc()) {
?>
			<tr>
				<td><?= $row['reference'] ?>
				</td>
				<td><?= $row['quantity']; ?></td>
				<td><?= $row['received']; ?></td>
				<td>
					<input type="hidden" name="date" value="<?= $date ?>">
					<input type="hidden" name="id<?= $x?>" value="<?= $row['id']?>">
					<input class="form-control" type="number" name="qty_receive<?= $x?>" id="qty_receive<?= $x?>" max="<?= $row['quantity'] -$row['received']?>" min='0' value='0'>
				</td>
				<?php
	$x++;
	}
				?>
			</tr>
		</tbody>
	</table>
	<div class="row">
		<input type="hidden" value="<?= $_POST['po'] ?>" name="po">
		<input type="hidden" value="<?= $x ?>" name="x">
		<button type="button" class="btn btn-primary" onclick="calculate()">Calculate</button>
	</div>
</form>
</div>
<script>
function calculate(){
	var res = 'true';
	var total_receive = 0;
	$('input[id^=qty_receive]').each(function(){
		var maximum = parseInt($(this).attr('max'));
		var receive = parseInt($(this).val());
		total_receive = parseInt(total_receive + receive);
		if(maximum - receive < 0){
			res = 'false';
			return false;
		} else if(receive < 0){
			res = 'false';
			alert('Cannot insert minus values!');
			return false;
		} else if($.isNumeric(receive) == false){
			res = 'false';
			alert('Insert correct value!');
			return false;
		} else{
			return true;
		}
	});
	if($('#document').val() == ''){
		alert('Cannot proceed, please check document number');
	} else if($.isNumeric(total_receive) == true && total_receive == 0){
		alert('Cannot insert blank document!');
		return false;
	} else if($.isNumeric(total_receive) == false){
		return false;
	} else if(res == 'false'){
		alert('Check your input');
	} else {
		$('#myForm').submit();
	}

};	
</script>
<?php
	}
?>