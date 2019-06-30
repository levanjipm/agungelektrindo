<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<?php
	include('../codes/connect.php');
	
	session_start();
	$user_id = $_SESSION['user_id'];
	
	$q_date = $_POST['today'];
	$dp = $_POST['dp'];
	$lunas = $_POST['lunas'];
	$terms = $_POST['terms'];
	$total = $_POST['total'];
	
	if (date('m',strtotime($q_date)) == '01'){
		$month = 'I';
	} else if(date('m',strtotime($q_date)) == '02'){
		$month = 'II';
	} else if(date('m',strtotime($q_date)) == '03'){
		$month = 'III';
	} else if(date('m',strtotime($q_date)) == '04'){
		$month = 'IV';
	} else if(date('m',strtotime($q_date)) == '05'){
		$month = 'V';
	} else if(date('m',strtotime($q_date)) == '06'){
		$month = 'VI';
	} else if(date('m',strtotime($q_date)) == '07'){
		$month = 'VII';
	} else if(date('m',strtotime($q_date)) == '08'){
		$month = 'VIII';
	} else if(date('m',strtotime($q_date)) == '09'){
		$month = 'IX';
	} else if (date('m',strtotime($q_date)) == '10'){
		$month = 'X';
	} else if(date('m',strtotime($q_date)) == '11'){
		$month = 'XI';
	} else {
		$month = 'XII';
	};
	
	$sql = " SELECT COUNT(*) AS jumlah FROM code_quotation WHERE MONTH(date) = MONTH('" . $q_date . "') 
	AND YEAR(date) = YEAR('" . $q_date . "')";
	$result = $conn->query($sql);
	if($result){	
			while($row = $result->fetch_assoc()) { 
			   $jumlah = $row['jumlah'];
			}
		} else {
			$jumlah = 0;
		}
	$jumlah++;
	$q_number = "Q-AE-" . str_pad($jumlah,2,"0",STR_PAD_LEFT) . "." . date("d",strtotime($q_date)). "-" . $month. "-" . date("y",strtotime($q_date));
	$customer = $_POST['customer'];
	$comment = $conn->real_escape_string($_POST['comment']);
	
	$sql_insert = "INSERT INTO code_quotation (name,customer_id,date,value,payment_id,down_payment,repayment,note,created_by) 
	VALUES ('$q_number','$customer','$q_date','$total','$terms','$dp','$lunas','$comment','$user_id')";
	$r = $conn->query($sql_insert);
	$x = $_POST['jumlah_barang'];

	$i = 1;
	$sql_first= "SELECT id FROM code_quotation WHERE name = '" . $q_number . "'"; 
	$result = $conn->query($sql_first);	
	$rows = $result->fetch_assoc();
	$quotation_id = $rows['id'];
	for ($i = 1; $i <= $x; $i++){
		$item = $_POST["item" . $i ];
		$price = $_POST["price" . $i ];
		$discount = $_POST["disc" . $i ];
		$netprice = $_POST["netprice" . $i ];
		$quantity = $_POST["qty" . $i ];
		$totprice = $_POST["totprice" . $i ];

		$sql_second = "INSERT INTO quotation (reference,price_list,discount,net_price,quantity,total_price,quotation_code) 
		VALUES ('$item','$price','$discount','$netprice','$quantity','$totprice','$quotation_id')";
		$result = $conn->query($sql_second);
	};
?>
<body>
<form method="POST" id="po_id" action="createquotation_print.php" target="_blank">
	<input type='hidden' name="id" value="<?= $quotation_id?>">
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
	}, 125);
});
$(document).ready(function () {
    window.setTimeout(function () {
		$('#po_id').submit();

	}, 250);
	window.setTimeout("location = ('sales.php');",260);
});
</script>