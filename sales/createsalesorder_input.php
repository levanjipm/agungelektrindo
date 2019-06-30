<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<?php
	include ("../codes/connect.php");
	session_start();
	$user_id = $_SESSION['user_id'];
	$so_number = $_POST['so_number'];
	$so_date = $_POST['today'];
	$customer = $_POST['customer'];
	$delivery_id = $_POST['delivery_address'];
	$value = $_POST['total_so'];
	$po_number = $_POST['purchaseordernumber'];
	$taxing = $_POST['taxing'];
	
	$sql_insert = "INSERT INTO code_salesorder (name,created_by,date,po_number,taxing,customer_id,delivery_id,value) 
	VALUES ('$so_number','$user_id','$so_date','$po_number','$taxing','$customer','$delivery_id','$value')";	
	$r = $conn->query($sql_insert);	
	$x = $_POST['jumlah_barang'];

	$i = 1;
	$sql_first= "SELECT * FROM code_salesorder WHERE name = '" . $so_number . "'"; 
	$result = $conn->query($sql_first);	
	while($rows = $result->fetch_assoc()){
		$so_id = $rows['id'];
	}
	for ($i = 1; $i <= $x; $i++){
		$ref = $_POST["ref" . $i ];
		$vat = $_POST["vat" . $i ];
		$disc = $_POST["disc" . $i ];
		$qty = $_POST["qty" . $i ];
		$pl = $_POST["pl" . $i ];

	$sql_second = "INSERT INTO sales_order (reference,price,discount,price_list,quantity,so_id) VALUES ('$ref','$vat','$disc','$pl','$qty','$so_id')";
	$result = $conn->query($sql_second);
	$sql_third = "INSERT INTO sales_order_sent (reference,so_id) VALUES ('$ref','$so_id')";
	$result = $conn->query($sql_third);
	} 
?>
<script>
$(document).ready(function () {
	window.setTimeout("location = ('sales.php');",150);
});
</script>