<?php
	include("../Codes/Connect.php")
?>
<?php
	$reference 		= mysqli_real_escape_string($conn,$_POST['reference']);
	$description 	= mysqli_real_escape_string($conn,$_POST['description']);
	$type 			= mysqli_real_escape_string($conn,$_POST['type']);
	$id 			= mysqli_real_escape_string($conn,$_POST['id']);
	
	$sql_select 	= "SELECT reference FROM itemlist WHERE id = '" . $id . "'";
	$result_select 	= $conn->query($sql_select);
	$select 		= $result_select->fetch_assoc();
	$reference_awal = $select['reference'];
	
	$sql_check		= "SELECT id FROM itemlist WHERE reference = '$reference' AND id <> '$id'";
	$result_check	= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) == 0){
		$sql 	= "UPDATE itemlist
				SET reference = '$reference', description = '$description', type = '$type'
				WHERE id='$id'";
		$result = $conn->query($sql);
		
		if($result){
			$sql = "UPDATE project SET reference = '" . $reference . "' WHERE reference = '" . $reference_awal . "'";
			$result = $conn->query($sql);
			$sql = "UPDATE purchaseorder SET reference = '" . $reference . "' WHERE reference = '" . $reference_awal . "'";
			$result = $conn->query($sql);
			$sql = "UPDATE purchaseorder_received SET reference = '" . $reference . "' WHERE reference = '" . $reference_awal . "'";
			$result = $conn->query($sql);
			$sql = "UPDATE purchase_return SET reference = '" . $reference . "' WHERE reference = '" . $reference_awal . "'";
			$result = $conn->query($sql);
			$sql = "UPDATE quotation SET reference = '" . $reference . "' WHERE reference = '" . $reference_awal . "'";
			$result = $conn->query($sql);
			$sql = "UPDATE sales_order SET reference = '" . $reference . "' WHERE reference = '" . $reference_awal . "'";
			$result = $conn->query($sql);
			$sql = "UPDATE sample SET reference = '" . $reference . "' WHERE reference = '" . $reference_awal . "'";
			$result = $conn->query($sql);
			$sql = "UPDATE stock SET reference = '" . $reference . "' WHERE reference = '" . $reference_awal . "'";
			$result = $conn->query($sql);
			$sql = "UPDATE stock_value_in SET reference = '" . $reference . "' WHERE reference = '" . $reference_awal . "'";
			$result = $conn->query($sql);
		}
	}
?>
