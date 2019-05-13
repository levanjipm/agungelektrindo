<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php
	//editing purchase order, first get the item now//
	include('../codes/connect.php');
	$x = $_POST['x'] - 1;
	//Get the purchase order ID to be query//
	$po_id = $_POST['po_id'];
	$promo_code = $_POST['promo_code'];
	$top = $_POST['top'];
	$taxing = $_POST['taxing'];
	$i = 1;
	$grand_total = 0;
	for ($i = 1; $i <= $x; $i++){
		$reference = $_POST['ref' . $i];
		$quantity = (float) $_POST['qty' . $i];
		echo $quantity;
		$pl = (float) $_POST['pl' . $i];
		$discount = (float) $_POST['discount' . $i];
		$unitprice = (float) $pl * (100 - $discount) / 100;
		$totalprice = (float) $unitprice * $quantity;
		//If the reference in the input is empty, delete from purchaseorder and purcahaseorder_received//
		if($reference !== ''){
			//If the reference already writter in the database, do not write again//
			$sql_get = "SELECT * FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "' AND reference = '" . $reference . "'";
			$result_get = $conn->query($sql_get);
			//Case where the item is not written yet//
			if(mysqli_num_rows($result_get) == 0){
				$sql_input = "INSERT INTO purchaseorder (reference,price_list,discount,unitprice,quantity,totalprice,purchaseorder_id)
				VALUES ('$reference','$pl','$discount','$unitprice','$quantity','$totalprice','$po_id')";
				$result_input = $conn->query($sql_input);
				$sql_input_receive = "INSERT INTO purchaseorder_received (reference,purchaseorder_id,quantity,status)
				VALUES('$reference','$po_id','0','0')";
				$result_input_receive = $conn->query($sql_input_receive);
			//Case where the is it already written//
			} else{
				if($quantity == '0'){
					$sql_check = "SELECT * FROM purchaseorder_received WHERE purchaseorder_id = '" . $po_id . "' AND reference = '" . $reference . "'";
					$result_check = $conn->query($sql_check);
					while($row_check = $result_check->fetch_assoc()){
						$quantity_received = $row_check['quantity'];
					}
					if($quantity_received > 0){
					} else {
						$sql_delete = "DELETE FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "' AND reference = '" . $reference . "'";
						$sql_delete_received = "DELETE FROM purchaseorder_received WHERE purchaseorder_id = '" . $po_id . "' AND reference = '" . $reference . "'";
						$result_delete = $conn->query($sql_delete);
						$result_delete_received = $conn->query($sql_delete_received);
					}
				} else{					
					//Get the quantity of ordered items before//
					$sql_get_ordered = "SELECT quantity FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "' AND reference = '" . $reference . "'";
					$result_get_ordered = $conn->query($sql_get_ordered);
					while($row_get_ordered = $result_get_ordered->fetch_assoc()){
						$quantity_ordered = $row_get_ordered['quantity'];
					}
					if ($quantity > $quantity_ordered){
						//Update the status to not finished if corresponding items added//
						$sql_update = "UPDATE purchaseorder SET price_list = '" . $pl . "', discount = '" . $discount . "', 
						unitprice = '" . $unitprice . "' , quantity = '" . $quantity . "', totalprice = '" . $totalprice . "', status = '0'
						WHERE purchaseorder_id = '" . $po_id . "' AND reference = '" . $reference . "'";
						$result_update = $conn->query($sql_update);
					} else if($quantity == $quantity_ordered){
						//Do not update status if it is already completed//
						$sql_update = "UPDATE purchaseorder SET price_list = '" . $pl . "', discount = '" . $discount . "', 
						unitprice = '" . $unitprice . "' , quantity = '" . $quantity . "', totalprice = '" . $totalprice . "'
						WHERE purchaseorder_id = '" . $po_id . "' AND reference = '" . $reference . "'";
						$result_update = $conn->query($sql_update);
					} else {
					}
				}
			}
		}
	$grand_total = $grand_total + $totalprice;
	}
	if($taxing == 1){
		$vat = (float)($grand_total / 1.1);
	} else {
		$vat = (float)($grand_total);
	}
	$tax = (float)($grand_total - $vat);
	$sql_final = "UPDATE code_purchaseorder SET top = '" . $top . "', value_before_tax = '" . $vat . "', tax = '" . $tax . "', total = '" . $grand_total . "', 
	promo_code = '" . $promo_code . "' WHERE id = '" . $po_id . "'";
	$result_final = $conn->query($sql_final);
?>
	<form action="createpurchaseorder_print.php" method="POST" id="edit_po" target="_blank">
		<input type="hidden" value="<?= $po_id ?>" name="id">
	</form>
	<script>
		$(document).ready(function () {
			window.setTimeout(function () {
				$('#edit_po').submit();

			}, 125);
			window.setTimeout("location = ('purchasing.php');",150);
		});
	</script>