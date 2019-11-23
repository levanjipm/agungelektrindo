<?php
	include('../codes/connect.php');
	session_start();
	$user_id 		= $_SESSION['user_id'];
	$seller 		= $_POST['seller'];
	$customer 		= $_POST['customer'];
	$date 			= $_POST['date'];
	$po_number 		= $_POST['po_number'];
	$tax 			= $_POST['tax'];
	$guid			= $_POST['guid'];
	
	if($tax == 2){
		$tax = 0;
	}
	
	$sql_check		= "SELECT COUNT(id) AS count_id FROM code_salesorder WHERE guid = '$guid'";
	$result_check	= $conn->query($sql_check);
	$check			= $result_check->fetch_assoc();
	
	if($check['count_id'] != 0){
?>
	<script>
		window.history.back();
	</script>
<?php
	} else {
	
		$descriptions 	= $_POST['descriptions'];
		$prices 		= $_POST['prices'];
		$quantities 	= $_POST['quantities'];
		
		$sql_select 	= "SELECT COUNT(*) AS jumlah_sebelumnya FROM code_salesorder 
						WHERE MONTH(date) = '" . date('m',strtotime($date)) . "' AND YEAR(date) = '" . date('Y',strtotime($date)) . "'";
		
		$result_select = $conn->query($sql_select);
		if($result_select){
			$select = $result_select->fetch_assoc();
			$jumlah = $select['jumlah_sebelumnya'];
		} else {
			$jumlah = 0;
		}
		
		$jumlah++;
		
		$so_number = "" . date("y",strtotime($date)) . date("m",strtotime($date)) . "-SO-" . str_pad($jumlah,3,"0",STR_PAD_LEFT);
		
		$sql_insert = "INSERT into code_salesorder (name,created_by,date,po_number,taxing,customer_id,delivery_id,value,label,type,seller,guid)
					VALUES ('$so_number','$user_id','$date','$po_number','$tax','$customer','','0','','SRVC','$seller','$guid')";
		$result_insert = $conn->query($sql_insert);
		
		//Get the id that just got in//
		$sql_get = "SELECT id FROM code_salesorder ORDER BY id DESC LIMIT 1";
		$result_get = $conn->query($sql_get);
		$get = $result_get->fetch_assoc();
		
		$last_so_id = $get['id'];
		$total = 0;
		foreach($descriptions as $description){
			$key = array_search($description, $descriptions);
			$quantity = $quantities[$key];
			$price = $prices[$key];
			$sql = "INSERT INTO service_sales_order (description,quantity,unitprice,so_id)
			VALUES ('$description','$quantity','$price','$last_so_id')";
			$conn->query($sql);
			$total = $total + $price * $quantity;
			
			next($descriptions);
		}
		$sql_update = "UPDATE code_salesorder SET value = '" . $total . "' WHERE guid = '$guid'";
		$conn->query($sql_update);
		
		// header('location:sales.php');
	}
?>