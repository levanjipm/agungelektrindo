<?php
	include('../codes/connect.php');
	$do_id = $_POST['do_id'];
	$price = $_POST['price'];
	
	$sql_update = "UPDATE code_delivery_order SET isinvoiced = '1' WHERE id = '" . $do_id . "'";
	$result_update = $conn->query($sql_update);
	
	$sql_code = "SELECT name, date, customer_id FROM code_delivery_order WHERE id = '" .$do_id . "'";
	$result_code = $conn->query($sql_code);
	$code = $result_code->fetch_assoc();
	
	$customer_id = $code['customer_id'];
	$date = $code['date'];
	$name = $code['name'];
	
	$sql_service = "SELECT service_sales_order.description, service_delivery_order.service_sales_order_id, service_delivery_order.quantity, service_sales_order.unitprice
	FROM service_delivery_order 
	JOIN service_sales_order ON service_sales_order.id = service_delivery_order.service_sales_order_id
	WHERE service_delivery_order.do_id = '" . $do_id . "'";
	$result_service = $conn->query($sql_service);
	while($service = $result_service->fetch_assoc()){
		$quantity = $service['quantity'];
		$unitprice = $service['unitprice'];
		$value+= $quantity * $unitprice;
	}
	
	$fu_name = 'FU-AE-' . substr($name,6,100);
	
	$sql_insert = "INSERT INTO invoices (date,do_id,name,value,ongkir) VALUES
	('$date','$do_id','$fu_name','$price','0')";
	$result_insert = $conn->query($sql_insert);
	
	header('location:accounting.php');
?>