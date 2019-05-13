<?php
	include('purchasingheader.php');
	//showing all the items that are going to be closed//
	if(empty($_POST['po_id'])){
		header('location:purchasing.php');
	} else {
		$po_id = $_POST['po_id'];
	}
	$sql_initial = "SELECT name,supplier_id FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_initial = $conn->query($sql_initial);
	$initial = $result_initial->fetch_assoc();
	
	$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $initial['supplier_id'] . "'";
	$result_supplier = $conn->query($sql_supplier);
	$supplier = $result_supplier->fetch_assoc();
?>
<div class='main'>
	<div class='container'>
		<h2>Purchase order data</h2>
		<p><strong>Supplier :</strong> <?= $supplier['name'] ?></p>
		<p><strong>PO number:</strong> <?= $initial['name'] ?></p>
	</div>
	<table class='table'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Pending quantity</th>
		</tr>
<?php
	$sql = "SELECT * FROM purchaseorder_received WHERE purchaseorder_id = '" . $po_id . "' AND status = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
		<tr>
			<td><?= $row['reference']; ?></td>
			<td><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $row['reference'] . "' LIMIT 1";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td><?php
				$sql_order = "SELECT quantity FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "' AND reference = '" . $row['reference'] . "' LIMIT 1";
				$result_order = $conn->query($sql_order);
				$row_order = $result_order->fetch_assoc();
				echo ($row_order['quantity'] - $row['quantity']);
			?></td>
		</tr>
<?php
	}
?>
	</table>
	<form action='close_purchaseorder.php' method='POST' id='closepo'>
		<input type='hidden' value='<?= $po_id ?>' name='po_id'>
		<br>
		<button type='button' class='btn btn-default' onclick='confirm()'>Close Purchase Order</button>
	</form>
</div>
<script>
	function confirm(){
		$('.main').css('opacity', 0.2);
		$('#confirmation').fadeIn();
	}
</script>
<style>
	#confirmation{
		position:absolute;
		top:30%;
		left:50%;
		display:none;
		z-index:150;
	}
	.btn-daniel{
		background-color:transparent;
		border:2px solid #0000ff;
		transition:0.3s all ease;
	}
	.btn-daniel:hover{
		background-color:rgba(26,26,255,0.5);
	}
</style>
<div id='confirmation'>
	<div class='container'>
		<h4><strong>Are you sure to close this purchase order</strong></h4>
		<p><b>Please note</b> that this action is cannot be undone</p>
		<button type='button' class='btn btn-daniel' onclick='submitform()'>
			Yes I am sure
		</button>
		<button type='button' class='btn btn-default' onclick='back()'>
			Check again
		</button>
	</div>
</div>
<script>
	function submitform(){
		$('#closepo').submit();
	}
	function back(){
		$('#confirmation').fadeOut();
		$('.main').css('opacity',1);
	}
</script>