<?php
	include('inventoryheader.php');
	if (empty($_POST['po'])){
		header('location:goodreceipt_dashboard.php');
	}
	
	$date = $_POST['date'];
	//If there was no purchase from the purchasing department, redirect to initial//
	$po_id = $_POST['po'];
	//Get supplier name//
	$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $_POST['supplier'] . "'";
	$result_supplier = $conn->query($sql_supplier);
	$row_supplier = $result_supplier->fetch_assoc();
	$supplier_name = $row_supplier['name'];
	//Get purchaseorder unique name from database//
	$sql_po = "SELECT name FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_po = $conn->query($sql_po);
	$row_po = $result_po->fetch_assoc();
	$po_name = $row_po['name'];
	
	$x = 1;
?>
<style>
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
	}
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
		box-shadow: 3px 4px 3px 4px #ddd;
	}
	.btn-delete{
		background-color:#2bf076;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
</style>
<div class="main" style="padding:20px">
	<h2 style='font-family:bebasneue'>Good Receipt</h2>
	<p>Input good receipt</p>
	<hr>
	<h4><?= $supplier_name ?></h4>
	<p><?= $po_name ?></p>
	<br><br>
<?php
	$sql = "SELECT purchaseorder.reference, purchaseorder.purchaseorder_id,purchaseorder_received.id, purchaseorder.quantity, purchaseorder_received.quantity AS received, purchaseorder_received.status, purchaseorder.id 
	FROM purchaseorder_received INNER JOIN purchaseorder ON purchaseorder_received.id = purchaseorder.id WHERE purchaseorder_received.status = '0' AND purchaseorder.purchaseorder_id = '" . $po_id . "'";
	$result = $conn->query($sql);
?>
	<form action="goodreceipt_validation.php" method="POST" id="goodreceipt_form">
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
<?php
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
			</tr>
				<?php
					$x++;
	}
				?>	
		</table>
		<div class="row">
			<input type="hidden" value="<?= $_POST['po'] ?>" name="po">
			<input type="hidden" value="<?= $x ?>" name="x">
			<button type="button" class="btn btn-default" onclick='calculate()'>Calculate</button>
		</div>
		<div class='notification_large' style='display:none'>
			<div class='notification_box'>
				<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
				<h2 style='font-family:bebasneue'>Are you sure to confirm this good receipt?</h2>
				<br>
				<button type='button' class='btn btn-back'>Back</button>
				<button type='button' class='btn btn-delete'>Confirm</button>
			</div>
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
		$('.notification_large').fadeIn();
	}

};
$('.btn-back').click(function(){
	$('.notification_large').fadeOut();
});
$('.btn-delete').click(function(){
	$('#goodreceipt_form').submit();
});		
</script>