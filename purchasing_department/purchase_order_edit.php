<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php
	include('../codes/connect.php');
	$purchase_order_id		= $_POST['purchase_order_id'];
	$promo_code				= mysqli_real_escape_string($conn,$_POST['promo_code']);
	$taxing					= $_POST['taxing'];
	$top					= $_POST['top'];
	
	$sql_update				= "UPDATE code_purchaseorder SET top = '$top', taxing = '$taxing', promo_code = '$promo_code' WHERE id = '$purchase_order_id'";
	$conn->query($sql_update);
	
	$reference_array		= $_POST['reference'];
	$quantity_array			= $_POST['quantity'];
	$price_list_array		= $_POST['price_list'];
	$discount_array			= $_POST['discount'];
	
	foreach($reference_array as $reference){
		$key			= key($reference_array);
		$sql			= "SELECT received_quantity FROM purchaseorder WHERE id = '$key'";
		$result			= $conn->query($sql);
		$row			= $result->fetch_assoc();
		
		$quantity_updated	= $quantity_array[$key];
		$received_quantity	= $row['received_quantity'];
		
		if($received_quantity > 0 && $quantity_updated == $received_quantity){
			$sql_update	= "UPDATE purchaseorder SET quantity = '$quantity_updated', status = '1' WHERE id = '$key'";
			
		} else if($received_quantity > 0 && $quantity_updated > $received_quantity){
			$sql_update	= "UPDATE purchaseorder SET quantity = '$quantity_updated', status = '0' WHERE id = '$key'";
			
		} else if($received_quantity == 0 && $quantity_updated > $received_quantity){
			$price_list		= $price_list_array[$key];
			$discount		= $discount_array[$key];
			$unit_price		= $price_list * (100 - $discount) * 0.01;
			
			$sql_update	= "UPDATE purchaseorder SET reference = '" . mysqli_real_escape_string($conn,$reference) . "', price_list = '$price_list', discount = '$discount', unitprice = '$unit_price', quantity = '$quantity_updated', status = '0' WHERE id = '$key'";
		} else if($received_quantity == 0 && $quantity_updated == $received_quantity){
			$price_list		= $price_list_array[$key];
			$discount		= $discount_array[$key];
			$unit_price		= $price_list * (100 - $discount) * 0.01;
			
			$sql_update	= "UPDATE purchaseorder SET reference = '" . mysqli_real_escape_string($conn,$reference) . "', price_list = '$price_list', discount = '$discount', unitprice = '$unit_price', quantity = '$quantity_updated', status = '1' WHERE id = '$key'";
		}
		
		$conn->query($sql_update);
		next($reference_array);
	}
	
	if(!empty($_POST['reference-'])){
		$reference_array		= $_POST['reference-'];
		$price_list_array		= $_POST['price_list-'];
		$discount_array			= $_POST['discount-'];
		$quantity_array			= $_POST['quantity-'];
		
		foreach($reference_array as $reference){
			$key				= key($reference_array);
			$price_list			= (float)$price_list_array[$key];
			$discount			= (float)$discount_array[$key];
			$quantity			= (int)$quantity_array[$key];
			
			$unit_price			= $price_list * (100 - $discount) * 0.01;
			
			$sql_reference		= "SELECT id FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_reference	= $conn->query($sql_reference);
			
			if(mysqli_num_rows($result_reference) > 0 && $discount <= 100 && $quantity > 0){
				$sql_insert		= "INSERT INTO purchaseorder (reference, price_list, discount, unitprice, quantity, received_quantity, status, purchaseorder_id)
								VALUES ('" . mysqli_real_escape_string($conn,$reference) . "', '$price_list','$discount', '$unit_price','$quantity','0','0','$purchase_order_id')";
				$conn->query($sql_insert);
			}
			
			next($reference_array);
		}
	}
	
	header('location:purchasing');
?>