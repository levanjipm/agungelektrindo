<?php
	include('../codes/connect.php');
	$date = $_POST['service_date_send'];
	$sales_order_id = $_POST['id'];
	
	switch (date('m',strtotime($date))) {
	case "01" :
		$month = 'I';
		break;
	case "02" :
		$month = 'II';
		break;
	case "03" :
		$month = 'III';
		break;
	case "04" :
		$month = 'IV';
		break;
	case "05" :
		$month = 'V';
		break;
	case "06" :
		$month = 'VI';
		break;
	case "07" :
		$month = 'VII';
		break;
	case "08" :
		$month = 'VIII';
		break;
	case "09" :
		$month = 'IX';
		break;
	case "10" :
		$month = 'X';
		break;
	case "11" :
		$month = 'XI';
		break;
	case "12" :
		$month = 'XII';
		break;		
	}
	
	$sql_get_code_salesorder = "SELECT * FROM code_salesorder WHERE id = '" . $sales_order_id . "'";
	$result_get_code_salesorder = $conn->query($sql_get_code_salesorder);
	$code = $result_get_code_salesorder->fetch_assoc();
	
	$taxing = $code['taxing'];
	$customer_id = $code['customer_id'];
	
	$sql_number = "SELECT * FROM code_delivery_order 
	WHERE MONTH(date) = MONTH('" . $date . "') AND YEAR(date) = YEAR('" . $date . "') 
	AND isdelete = '0' ORDER BY number ASC";
	$results = $conn->query($sql_number);
	if ($results->num_rows > 0){
		$i = 1;
		while($row_do = $results->fetch_assoc()){
			if ($i == $row_do['number']){
				$i++;
				$nomor = $i;
			} else {
				break;
			}
		}
	} else {
		$nomor = 1;
	};
	if ($taxing){
		$tax_preview = 'P';
	} else {
		$tax_preview = 'N';
	};
	$do_number_preview = "SJ-AE-" . str_pad($nomor,2,"0",STR_PAD_LEFT) . $tax_preview . "." . date("d",strtotime($date)). "-" . $month. "-" . date("y",strtotime($date));
	$sql = "INSERT INTO code_delivery_order (date,number,tax,name,customer_id,so_id)
	VALUES ('$date','$nomor','$taxing','$do_number_preview','$customer_id','$sales_order_id')";
	$result = $conn->query($sql);
	
	$sql_get_last_id = "SELECT id FROM code_delivery_order WHERE name = '" . $do_number_preview . "'";
	$result_get_last_id = $conn->query($sql_get_last_id);
	$last_id = $result_get_last_id->fetch_assoc();
	
	$last_do_id = $last_id = $last_id['id'];
	
	$quantity_array = $_POST['quantity'];
	foreach($quantity_array as $quantity){
		$key = key($quantity_array);
		$sql_get = "SELECT done,quantity FROM service_sales_order WHERE id = '" . $key . "'";
		$result_get = $conn->query($sql_get);
		$get = $result_get->fetch_assoc();
		
		$ordered = $get['quantity'];
		$done = $get['done'];
		$sql_insert = "INSERT INTO service_delivery_order (service_sales_order_id,quantity,do_id)
		VALUES ('$key','$quantity','$last_do_id')";
		$result_insert = $conn->query($sql_insert);
		next($quantity_array);
	}
	header('location:do_choose.php');
?>