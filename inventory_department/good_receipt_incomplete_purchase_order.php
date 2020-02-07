 <?php
	include('../codes/connect.php');
?>
	<label>Purchase order</label>
	<select class='form-control' id='purchase_order'>
<?php
	$id			= mysqli_real_escape_string($conn,$_POST['supplier_id']);
	$sql 		= "SELECT DISTINCT(purchaseorder.purchaseorder_id) as id, code_purchaseorder.name
					FROM code_purchaseorder 
					JOIN purchaseorder ON purchaseorder.purchaseorder_id = code_purchaseorder.id 
					WHERE code_purchaseorder.supplier_id= '$id' AND purchaseorder.status = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		$purchase_order_id		= $row['id'];
		$purchase_order_name	= $row['name'];
?>
		<option value='<?= $purchase_order_id ?>'><?= $purchase_order_name ?></option>
<?php
	}
?>
	</select>
