<?php
	include("../Codes/connect.php");
	session_start();
	if($_SESSION['user_id'] == NULL){
		header('location:purchasing.php');
	} else {
?>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<style>
#heading{
	border:2px black solid;
}
</style>
<?php
	$po_number 		= mysqli_real_escape_string($conn,$_POST['po_number']);
	$vendor_id 		= mysqli_real_escape_string($conn,$_POST['vendor']);
	$top 			= mysqli_real_escape_string($conn,$_POST['top']);
	$date 			= mysqli_real_escape_string($conn,$_POST['po_date']);
	$tax 			= mysqli_real_escape_string($conn,$_POST['taxing']);
	$code_promo 	= mysqli_real_escape_string($conn,$_POST['code_promo']);
	$address_choice = mysqli_real_escape_string($conn,$_POST['address_choice']);
	$delivery_date 	= mysqli_real_escape_string($conn,$_POST['delivery_date']);
	$sent_date 		= mysqli_real_escape_string($conn,$_POST['sent_date']);
	
	$guid			= $_POST['guid'];
	
	$sql_check_guid		= "SELECT id FROM code_purchaseorder WHERE guid = '$guid'";
	$result_check_guid	= $conn->query($sql_check_guid);
	
		if(mysqli_num_rows($result_check_guid) != 0){
			header('location:purchasing');
		} else {
			if($address_choice == 1){
				if($delivery_date == 2){
					$sql = "INSERT INTO code_purchaseorder (name,supplier_id,date,top,taxing,send_date,status,promo_code,created_by,guid) 
					VALUES ('$po_number','$vendor_id','$date','$top','$tax','','','$code_promo','" . $_SESSION['user_id'] . "','$guid')";
				} else if($delivery_date == 3){
					$sql = "INSERT INTO code_purchaseorder (name,supplier_id,date,top,taxing,send_date,status,promo_code,created_by,guid) 
					VALUES ('$po_number','$vendor_id','$date','$top','$tax','','URGENT','$code_promo','" . $_SESSION['user_id'] . "','$guid')";
				} else if($delivery_date == 1){
					$sql = "INSERT INTO code_purchaseorder (name,supplier_id,date,top,taxing,send_date,status,promo_code,created_by,guid) 
					VALUES ('$po_number','$vendor_id','$date','$top','$tax','$sent_date','','$code_promo','" . $_SESSION['user_id'] . "','$guid')";
				}
			} else if($address_choice == 2){
				$dropship_name 		= mysqli_real_escape_string($conn,$_POST['dropship_name']);
				$dropship_address 	= mysqli_real_escape_string($conn,$_POST['dropship_address']);
				$dropship_city 		= mysqli_real_escape_string($conn,$_POST['dropship_city']);
				$dropship_phone 	= mysqli_real_escape_string($conn,$_POST['dropship_phone']);
				if($delivery_date == 2){
					$sql = "INSERT INTO code_purchaseorder (name,supplier_id,date,top,taxing,send_date,status,promo_code,created_by,dropship_name,dropship_address,dropship_city,dropship_phone,guid) 
					VALUES ('$po_number','$vendor_id','$date','$top','$tax','','','$code_promo','" . $_SESSION[user_id] . "','$dropship_name','$dropship_address','$dropship_city','$dropship_phone','$guid')";
				} else if($delivery_date == 3){
					$sql = "INSERT INTO code_purchaseorder (name,supplier_id,date,top,taxing,send_date,status,promo_code,created_by,dropship_name,dropship_address,dropship_city,dropship_phone,guid) 
					VALUES ('$po_number','$vendor_id','$date','$top','$tax','','URGENT','$code_promo','" . $_SESSION[user_id] . "','$dropship_name','$dropship_address','$dropship_city','$dropship_phone','$guid')";
				} else if($delivery_date == 1){
					$sql = "INSERT INTO code_purchaseorder (name,supplier_id,date,top,taxing,send_date,status,promo_code,created_by,dropship_name,dropship_address,dropship_city,dropship_phone,guid) 
					VALUES ('$po_number','$vendor_id','$date','$top','$tax','$sent_date','','$code_promo','" . $_SESSION[user_id] . "','$dropship_name','$dropship_address','$dropship_city','$dropship_phone','$guid')";
				}
			}	
			$conn->query($sql);
			
			$sql_first	= "SELECT id FROM code_purchaseorder WHERE name = '" . $po_number . "'"; 
			$result 	= $conn->query($sql_first);	
			$row 		= $result->fetch_assoc();
			$po_id 		=  $row['id'];
			
			$reference_array 	= $_POST['reference'];
			$price_array		= $_POST['price'];
			$discount_array		= $_POST['discount'];
			$quantity_array		= $_POST['quantity'];
			
			foreach($reference_array as $reference){
				$key		= key($reference_array);
				$price		= $price_array[$key];
				$discount	= $discount_array[$key];
				$quantity	= $quantity_array[$key];
				
				$net_price	= $price * (100 - $discount) * 0.01;
				
				$sql = "INSERT INTO purchaseorder (reference,price_list,discount,unitprice,quantity,purchaseorder_id) VALUES
						('$reference','$price','$discount','$net_price','$quantity','$po_id')";
				$conn->query($sql);
				
				next($reference_array);
			}
?>
<body>
	<form method="POST" id="po_id" action="purchase_order_create_print" target="_blank">
		<input type='hidden' name="id" value="<?= $po_id?>">
	</form>
	<script>
		$(document).ready(function () {
			window.setTimeout(function () {
				$('#po_id').submit();

			}, 125);
			window.setTimeout("location = ('purchasing');",150);
		});
	</script>
</body>
<?php
		}
	}
?>