<?php
	include ("../codes/connect.php");
	session_start();
	$created_by = $_SESSION['user_id'];
	
	print_r($_POST);
	
	$so_date = $_POST['today'];
	$customer = $_POST['customer'];
	$po_number = mysqli_real_escape_string($conn,$_POST['purchaseordernumber']);
	$taxing = $_POST['taxing'];
	
	$sql = " SELECT COUNT(*) AS jumlah FROM code_salesorder WHERE MONTH(date) = MONTH('" . $so_date . "') 
	AND YEAR(date) = YEAR('" . $so_date . "')";
	$result = $conn->query($sql);
	if($result){	
		$row = $result->fetch_assoc();
	   $jumlah = $row['jumlah'];
	} else {
		$jumlah = 0;
	}
	$jumlah++;
	
	$sales_order_value = 0;
	
	foreach($reference_array as $reference){
		$key = key($reference_array);
		$quantity 			= $quantity_array[$key];
		$value_after_tax 	= $value_after_tax_array[$key];
		$total_price		= $value_after_tax * $quantity;
		$sales_order_value	+= $total_price;
		
		next($reference_array);
	}
	
	$so_number = "" . date("y",strtotime($so_date)) . date("m",strtotime($so_date)) . "-SO-" . str_pad($jumlah,3,"0",STR_PAD_LEFT);
	if($customer != 0){
		$sql = "INSERT INTO code_salesorder (name,created_by,date,po_number,taxing,customer_id,value) 
		VALUES ('$so_number','$created_by','$so_date','$po_number','$taxing','$customer','$sales_order_value')";	
	} else {
		$name 		= mysqli_real_escape_string($conn,$_POST['retail_name']);
		$address 	= mysqli_real_escape_string($conn,$_POST['retail_address']);
		$city 		= mysqli_real_escape_string($conn,$_POST['retail_city']);
		$phone 		= mysqli_real_escape_string($conn,$_POST['retail_phone']);
		
		$sql = "INSERT INTO code_salesorder (name,created_by,date,po_number,taxing,customer_id,value,retail_name,retail_address,retail_city,retail_phone) 
		VALUES ('$so_number','$created_by','$so_date','$po_number','$taxing','0','$value','$name','$address','$city','$phone')";
	}
	$conn->query($sql);

	$sql_so			= "SELECT id FROM code_salesorder WHERE name = '" . $so_number . "'"; 
	$result_so		= $conn->query($sql_so);	
	$sales_order	= $result_so->fetch_assoc();
	$so_id			= $sales_order['id'];
	
	$reference_array		= $_POST['reference'];
	$quantity_array			= $_POST['quantity'];
	$value_after_tax_array	= $_POST['value_after_tax'];
	$price_list_array		= $_POST['price_list'];
	
	foreach($reference_array as $reference){
		$key = key($reference_array);
		$quantity 			= $quantity_array[$key];
		$value_after_tax 	= $value_after_tax_array[$key];
		$price_list			= $price_list_array[$key];
		$total_price		= $value_after_tax * $quantity;
		$discount			= $value_after_tax * $price_list;
		
		$sql 				= "INSERT INTO sales_order (reference,price,discount,price_list,quantity,so_id) 
							VALUES ('$reference','$value_after_tax','$discount','$price_list','$quantity','$so_id')";
		$conn->query($sql);
		
		next($reference_array);
	}
	header('location:sales.php');
?>