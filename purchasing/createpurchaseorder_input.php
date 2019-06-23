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
	$po_number = $_POST['po_number'];
	$vendor_id = $_POST['vendor'];
	$top = $_POST['top'];
	$date = $_POST['po_date'];
	$address = $_POST['address'];
	$tax = $_POST['taxing'];
	$total = $_POST['total'];
	$code_promo = $_POST['code_promo'];
	$sql = "INSERT INTO code_purchaseorder (name,supplier_id,date,top,value,taxing,delivery_id,promo_code,created_by) 
	VALUES ('$po_number','$vendor_id','$date','$top','$total','$tax','$address','$code_promo','$_SESSION[user_id]')";
	echo $sql;
	$result = $conn->query($sql);
	
	$x = $_POST['jumlah_barang'];
	$i = 1;
	$sql_first= "SELECT id FROM code_purchaseorder WHERE name = '" . $po_number . "'"; 
	$result = $conn->query($sql_first);	
	while($row = $result->fetch_assoc()){
		$po_id =  $row['id'];
	}
	for ($i = 1; $i <= $x; $i++){
		$item = $_POST["item" . $i ];
		$price = $_POST["price" . $i ];
		$disc = $_POST["discount" . $i ];
		$qty = $_POST["quantity" . $i ];
		$netprice = $_POST["netprice" . $i ];
		$totprice = $_POST["totprice" . $i];
		
		$sql_second = "INSERT INTO purchaseorder (reference,price_list,discount,unitprice,quantity,totalprice,purchaseorder_id) 
		VALUES ('$item','$price','$disc','$netprice','$qty','$totprice','$po_id')";
		$result = $conn->query($sql_second);
		$sql_pending = "INSERT INTO purchaseorder_received (purchaseorder_id,reference,quantity,status) VALUES ('$po_id','$item','0','0')";
		$result = $conn->query($sql_pending);
	}
?>
<body>
<form method="POST" id="po_id" action="createpurchaseorder_print.php" target="_blank">
	<input type='hidden' name="id" value="<?= $po_id?>">
</form>
<div class="loader"></div>
<div class="row" id="text-holder">
	<h4 id="text" style="text-align:center">Inputting database</h4>
</div>
</body>
<style>
.loader {
	position:absolute;
	border: 16px solid #f3f3f3; /* Light grey */
	border-top: 16px solid #3498db; /* Blue */
	border-radius: 50%;
	width: 120px;
	height: 120px;
	animation: spin 2s linear infinite;
	left:50%;
	top:10%;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

#text-holder {
	position:absolute;
	top:40%;
	left:50%;
	text-align:center;
}
</style>
<script>
$(document).ready(function () {
    window.setTimeout(function () {
		$('#text').html('Creating print format');
	}, 100);
});
$(document).ready(function () {
    window.setTimeout(function () {
		$('#po_id').submit();

	}, 125);
	window.setTimeout("location = ('purchasing.php');",150);
});
</script>
<?php
	}
?>