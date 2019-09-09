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
	
	$reference_array	= $_POST['reference'];
	$price_array 		= $_POST['price'];
	$discount_array 	= $_POST['discount'];
	$quantity_array 	= $_POST['quantity'];
	$user_id 			= $_SESSION['user_id'];
	
	$q_date 			= $_POST['today'];
	$dp 				= $_POST['dp'];
	$lunas 				= $_POST['lunas'];
	$terms 				= $_POST['terms'];
	$add_discount 		= $_POST['add_discount'];
	$guid				= $_POST['GUID'];
	
	$sql_check_guid		= "SELECT id FROM code_quotation WHERE guid = '$guid'";
	$result_check_guid	= $conn->query($sql_check_guid);
	if(mysqli_num_rows($result_check_guid) != 0){
		header('location:sales');
	}
	
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
	
	$sql 			= " SELECT COUNT(*) AS jumlah FROM code_quotation WHERE MONTH(date) = MONTH('" . $q_date . "') 
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
	
	$sql_insert		= "INSERT INTO code_quotation (name,customer_id,date,additional_discount,payment_id,down_payment,repayment,note,created_by,guid) 
				VALUES ('$q_number','$customer','$q_date','$add_discount','$terms','$dp','$lunas','$comment','$user_id','$guid')";
	$conn->query($sql_insert);
	$sql_first= "SELECT id FROM code_quotation WHERE name = '" . $q_number . "'"; 
	$result = $conn->query($sql_first);
	$rows = $result->fetch_assoc();
	$quotation_id = $rows['id'];
	foreach($reference_array AS $reference){
		$key 				= key($reference_array);
		$reference_escaped 	= mysqli_real_escape_string($conn,$reference);
		$price 				= $price_array[$key];
		$discount 			= (float)$discount_array[$key];
		$quantity 			= $quantity_array[$key];
		$netprice			= $price * (1 - $discount * 0.01);
		$sql_second 		= "INSERT INTO quotation (reference,price_list,discount,net_price,quantity,quotation_code) 
							VALUES ('$reference_escaped','$price','$discount','$netprice','$quantity','$quotation_id')";	
		$conn->query($sql_second);
		next($reference_array);
	};
	if($result){
?>
	<form method="POST" id="po_id" action="createquotation_print.php" target="_blank">
		<input type='hidden' name="id" value="<?= $quotation_id?>">
	</form>
	<script>
	$(document).ready(function () {
		window.setTimeout(function () {
			$('#po_id').submit();
		}, 250);
		window.setTimeout("location = ('sales.php');",260);
	});
	</script>
<?php
	}
?>