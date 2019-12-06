<script src='../universal/Jquery/jquery-3.3.0.min.js'></script>
<?php
	include('../codes/connect.php');
	session_start();
	$created_by 	= $_SESSION['user_id'];
	
	$date 			= $_POST['date'];
	$customer 		= $_POST['customer'];
	$other_value	= $_POST['other_value'];
	
	$sql_count 		= "SELECT COUNT(id) AS counted_invoice FROM code_proforma_invoice WHERE MONTH(date) = MONTH('$date') AND YEAR(date) = YEAR('$date')";
	$result_count 	= $conn->query($sql_count);
	$count 			= $result_count->fetch_assoc();
	
	$jumlah 		= $count['counted_invoice'];
	$guid			= $_POST['guid'];
	$jumlah++;
	
	$sql_check_guid		= "SELECT id FROM code_proforma_invoice WHERE guid = '$guid'";
	$result_check_guid	= $conn->query($sql_check_guid);
	if(mysqli_num_rows($result_check_guid) > 0){
?>
	<script>
		window.history.back();
	</script>
<?php
	} else {
		$purchaseorder_number 	= mysqli_real_escape_string($conn,$_POST['purchaseorder_number']);
		$taxing 				= $_POST['taxing'];
		$reference_array 		= $_POST['reference'];
		$price_array 			= $_POST['price'];
		$quantity_array 		= $_POST['quantity'];
		$proforma_invoice_type	= $_POST['proforma_invoice_type'];
		
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
		
		if($taxing == 1){
			$taxing_component = 'P';
		} else if($taxing == 0){
			$taxing_component = 'N';
		}
		
		$proforma_invoice_name 	= "PI-AE-" . str_pad($jumlah,2,"0",STR_PAD_LEFT) . $taxing_component . "." . date("d",strtotime($date)). "-" . $month. "-" . date("y",strtotime($date));
		$sql 					= "INSERT INTO code_proforma_invoice (date,name,taxing,customer_id,po_number,type,value,created_by,created_date,guid)
								VALUES ('$date','$proforma_invoice_name','$taxing','$customer','$purchaseorder_number','$proforma_invoice_type','$other_value','$created_by',CURDATE(),'$guid')";
		$conn->query($sql);
		
		$sql 						= "SELECT id FROM code_proforma_invoice ORDER BY id DESC LIMIT 1";
		$result 					= $conn->query($sql);
		$row 						= $result->fetch_assoc();
		$code_proforma_invoice_id 	= $row['id'];
		
		foreach($reference_array as $reference_before_escape){
			$key 			= key($reference_array);
			$reference 		= mysqli_real_escape_string($conn,$reference_before_escape);
			$quantity 		= $quantity_array[$key];
			$price 			= $price_array[$key];
			$sql 			= "INSERT INTO proforma_invoice (reference,quantity,price,code_proforma_invoice_id)
							VALUES ('$reference','$quantity','$price','$code_proforma_invoice_id')";
			$result 		= $conn->query($sql);
			next($reference_array);
		}
		if($result){
	?>
			<form action='build_proforma_invoice_print.php' method='POST' id='proforma_invoice_form' target='_blank'>
				<input type='hidden' value='<?= $code_proforma_invoice_id ?>' name='id'>
			</form>
		<script>
			$('#proforma_invoice_form').submit();
			window.location.href = 'accounting';
		</script>
<?php
		}
	}
?>