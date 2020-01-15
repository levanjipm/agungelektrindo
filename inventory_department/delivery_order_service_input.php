<?php
	include('../codes/connect.php');
?>
<script src='../universal/Jquery/jquery-3.3.0.min.js'></script>
<?php
	$date 				= $_POST['service_date_send'];
	$sales_order_id 	= $_POST['id'];
	$guid				= $_POST['guid'];
	
	$sql_check			= "SELECT id FROM code_delivery_order WHERE guid = '$guid'";
	$result_check		= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) == 0){
	
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
	
	$sql_get_code_salesorder 			= "SELECT * FROM code_salesorder WHERE id = '" . $sales_order_id . "'";
	$result_get_code_salesorder			= $conn->query($sql_get_code_salesorder);
	$code 								= $result_get_code_salesorder->fetch_assoc();
	
	$taxing 							= $code['taxing'];
	$customer_id 						= $code['customer_id'];
	
	$sql_number 						= "SELECT number FROM code_delivery_order 
											WHERE MONTH(date) = MONTH('" . $date . "') AND YEAR(date) = YEAR('" . $date . "') AND number > '0'
											AND isdelete = '0' AND company = 'AE' ORDER BY number ASC LIMIT 1";
	$results 							= $conn->query($sql_number);
	$number								= $results->fetch_assoc();
	$first_number						= $number['number'];
	
	
	$sql_number 						= "SELECT number FROM code_delivery_order 
											WHERE MONTH(date) = MONTH('" . $date . "') AND YEAR(date) = YEAR('" . $date . "') AND number > '0'
											AND isdelete = '0' AND company = 'AE' ORDER BY number";
	$result_number						= $conn->query($sql_number);
	
	if (mysqli_num_rows($result_number) > 0 && $first_number == 1){
		$i 			= 1;
		while($row_do = $result_number->fetch_assoc()){
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
	
	$do_number_preview 	= "SJ-AE-" . str_pad($nomor,2,"0",STR_PAD_LEFT) . $tax_preview . "." . date("d",strtotime($date)). "-" . $month. "-" . date("y",strtotime($date));
	$sql 				= "INSERT INTO code_delivery_order (date,number,tax,name,customer_id,so_id, guid)
							VALUES ('$date','$nomor','$taxing','$do_number_preview','$customer_id','$sales_order_id', '$guid')";
	$result 			= $conn->query($sql);
	
	$sql_get_id			= "SELECT id FROM code_delivery_order WHERE guid = '$guid'";
	$result_get_id		= $conn->query($sql_get_id);
	$get				= $result_get_id->fetch_assoc();
	
	$delivery_order_id	= $get['id'];
	
	$quantity_array 	= $_POST['quantity'];
	foreach($quantity_array as $quantity){
		$key 			= key($quantity_array);
		$sql_get 		= "SELECT done,quantity FROM service_sales_order WHERE id = '" . $key . "'";
		$result_get 	= $conn->query($sql_get);
		$get 			= $result_get->fetch_assoc();
		$ordered 		= $get['quantity'];
		$done 			= $get['done'];
		$sql_insert 	= "INSERT INTO service_delivery_order (service_sales_order_id,quantity,do_id)
							VALUES ('$key','$quantity','$delivery_order_id')";
		$conn->query($sql_insert);
		
		if($quantity	== $ordered - $done){
			$new_done	= $quantity + $done;
			$sql_update	= "UPDATE service_sales_order SET done = '$new_done', isdone = '1' WHERE id = '$key'";
			$conn->query($sql_update);
		} else {
			$new_done	= $quantity + $done;
			$sql_update	= "UPDATE service_sales_order SET done = '$new_done' WHERE id = '$key'";
			$conn->query($sql_update);
		}
		
		next($quantity_array);
	}
?>
	<body>
	<form method="POST" id="delivery_order_print_form" action="delivery_order_service_print" target="_blank">
		<input type="hidden" name="id" value="<?= $delivery_order_id?>">
	</form>
	</body>
	<script>
		$(document).ready(function () {
			$('#delivery_order_print_form').submit();
		});
	</script>
<?php
	}
?>
	<script>
		setTimeout(function(){
			window.location.href='/agungelektrindo/inventory_department/delivery_order_create_dashboard';
		},100);
	</script>