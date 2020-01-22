<?php
	include ($_SERVER['DOCUMENT_ROOT'] . "/agungelektrindo/codes/connect.php");
	
	session_start();
	$created_by 	= $_SESSION['user_id'];
	$so_date 		= $_POST['today'];
	$customer_top	= $_POST['customer_top'];
	$customer 		= $_POST['customer'];
	$guid	 		= $_POST['guid'];
	$po_number 		= mysqli_real_escape_string($conn,$_POST['purchaseordernumber']);
	$taxing 		= $_POST['taxing'];
	$note			= mysqli_real_escape_string($conn,$_POST['sales_order_note']);
	
	$sql_check		= "SELECT id FROM code_salesorder WHERE guid = '$guid'";
	$result_check	= $conn->query($sql_check);
	
	if(mysqli_num_rows($result_check) == 0){
		
	$sql 			= "SELECT COUNT(*) AS jumlah FROM code_salesorder WHERE MONTH(date) = MONTH('" . $so_date . "') 
					AND YEAR(date) = YEAR('" . $so_date . "')";
	$result = $conn->query($sql);
	
	if($result){	
		$row = $result->fetch_assoc();
		$jumlah = $row['jumlah'];
	} else {
		$jumlah = 0;
	}
	
	$jumlah++;
		
	$so_number 				= "" . date("y",strtotime($so_date)) . date("m",strtotime($so_date)) . "-SO-" . str_pad($jumlah,3,"0",STR_PAD_LEFT);
	
	if($customer 			!= NULL){
		$sql 				= "INSERT INTO code_salesorder (name,created_by,date,po_number,taxing,customer_id,note,top,guid) 
							VALUES ('$so_number','$created_by','$so_date','$po_number','$taxing','$customer','$note','$customer_top','$guid')";	
	} else {
		$name 				= mysqli_real_escape_string($conn,$_POST['retail_name']);
		$address 			= mysqli_real_escape_string($conn,$_POST['retail_address']);
		$city 				= mysqli_real_escape_string($conn,$_POST['retail_city']);
		$phone 				= mysqli_real_escape_string($conn,$_POST['retail_phone']);
		
		$sql 				= "INSERT INTO code_salesorder (name,created_by,date,po_number,taxing,retail_name,retail_address,retail_city,retail_phone,note,top,guid) 
							VALUES ('$so_number','$created_by','$so_date','$po_number','$taxing','$name','$address','$city','$phone','$note','$customer_top','$guid')";
	}
	
	$result					= $conn->query($sql);

	$sql_so					= "SELECT id FROM code_salesorder WHERE guid = '" . $guid . "'"; 
	$result_so				= $conn->query($sql_so);	
	$sales_order			= $result_so->fetch_assoc();
	$so_id					= $sales_order['id'];
	
	$reference_array		= $_POST['reference'];
	$quantity_array			= $_POST['quantity'];
	$value_after_tax_array	= $_POST['value_after_tax'];
	$price_list_array		= $_POST['price_list'];
	
	foreach($reference_array as $reference){
		$key				= key($reference_array);
		$quantity			= $quantity_array[$key];
		$value_after_tax	= $value_after_tax_array[$key];
		$price_list			= $price_list_array[$key];
		
		$discount			= 100 * (1 - ($value_after_tax / $price_list));
		
		$sql				= "INSERT INTO sales_order (reference, price, discount, price_list, quantity, so_id)
								VALUES ('$reference', '$value_after_tax', '$discount', '$price_list', '$quantity', '$so_id')";
		$conn->query($sql);
		
		next($reference_array);
	}
	
	$directory	 			= getcwd() . DIRECTORY_SEPARATOR;
	$target_dir				= $directory . "/sales_order_images/";
	$target_file 			= $target_dir . basename($_FILES["purchase_order_file"]["name"]);
	$imageFileType 			= strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$file_name 				= $target_dir . $guid . "." . $imageFileType;

	if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == 'pdf' ) {
		if (move_uploaded_file($_FILES['purchase_order_file']['tmp_name'], $file_name)) {
			$sql_update		= "UPDATE code_salesorder SET document_type = '$imageFileType' WHERE guid = '$guid'";
			$conn->query($sql_update);
		}
	}
	}
	
	header('location:/agungelektrindo/sales');
?>