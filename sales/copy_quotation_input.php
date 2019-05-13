<?php
	include('../codes/connect.php');
	$qname = $_POST['qname'];
	$customer_id = $_POST['customer_id'];
	$total = $_POST['total'];
	$terms = $_POST['terms'];
	$dp = $_POST['dp'];
	$lunas = $_POST['lunas'];
	$comment = $_POST['comment'];
	$x = $_POST['jumlah_barang'];
	$i = 1;
	$sql = "INSERT INTO code_quotation (name,customer_id,date,value,payment_id,down_payment,repayment,note)
	VALUES ('$qname','$customer_id',CURDATE(),'$total','$terms','$dp','$lunas','$comment')";
	echo $sql;
	$result = $conn->query($sql);
	$sql_get = "SELECT MAX(id) AS maximum FROM code_quotation";
	$result_get = $conn->query($sql_get);
	while($row_get = $result_get->fetch_assoc()){
		$maximum = $row_get['maximum'];
	}
	for($i = 1; $i <= $x; $i++){
	if(!empty($_POST['reference' . $i])){
		$reference = $_POST['reference' . $i];
		$price = $_POST['price' . $i];
		$discount = $_POST['discount' . $i];
		$quantity = $_POST['quantity' . $i];
		$net_price = $_POST['unitprice' . $i];
		$total_price = $_POST['totalprice' . $i];
		$sql_insert = "INSERT INTO quotation (reference,price_list,discount,net_price,quantity,total_price,quotation_code) 
		VALUES ('$reference','$price','$discount','$net_price','$quantity','$total_price','$maximum')";
		$r = $conn->query($sql_insert);			
		} else{
			$i++;
		}
	}
	header('location:sales.php');
?>