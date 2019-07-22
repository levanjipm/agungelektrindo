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
	$value = $_POST['total_so'];
	$po_number = mysqli_real_escape_string($conn,$_POST['purchaseordernumber']);
	$taxing = $_POST['taxing'];
	$x = $_POST['jumlah_barang'];
	
	if($customer != 0){
		$delivery_id = $_POST['delivery_address'];
		$sql = "INSERT INTO code_salesorder (name,created_by,date,po_number,taxing,customer_id,delivery_id,value) 
		VALUES ('$so_number','$user_id','$so_date','$po_number','$taxing','$customer','$delivery_id','$value')";	
	} else {
		$name = mysqli_real_escape_string($conn,$_POST['retail_name']);
		$address = mysqli_real_escape_string($conn,$_POST['retail_address']);
		$city = mysqli_real_escape_string($conn,$_POST['retail_city']);
		$phone = mysqli_real_escape_string($conn,$_POST['retail_phone']);
		
		$sql = "INSERT INTO code_salesorder (name,created_by,date,po_number,taxing,customer_id,delivery_id,value,retail_name,retail_address,retail_city,retail_phone) 
		VALUES ('$so_number','$user_id','$so_date','$po_number','$taxing','$customer','','$value','$name','$address','$city','$phone')";
	}
	
	$conn->query($sql);
	$i = 1;
	$sql_so= "SELECT * FROM code_salesorder WHERE name = '" . $so_number . "'"; 
	$result_so = $conn->query($sql_so);	
	$so = $result_so->fetch_assoc();
	$so_id = $so['id'];
	
	for ($i = 1; $i <= $x; $i++){
		$ref = $_POST["ref" . $i ];
		$vat = $_POST["vat" . $i ];
		$disc = $_POST["disc" . $i ];
		$qty = $_POST["qty" . $i ];
		$pl = $_POST["pl" . $i ];

		$sql = "INSERT INTO sales_order (reference,price,discount,price_list,quantity,so_id) VALUES ('$ref','$vat','$disc','$pl','$qty','$so_id')";
		$conn->query($sql);
		
		$sql = "INSERT INTO sales_order_sent (reference,so_id) VALUES ('$ref','$so_id')";
		$result = $conn->query($sql);
	} 
?>
<script>
$(document).ready(function () {
	window.setTimeout("location = ('sales.php');",150);
});
</script>