<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/head.php');
	session_start();
	$created_by = $_SESSION['user_id'];
	
	$guid					= $_POST['guid'];
	$delivery_order_date	= $_POST['delivery_order_date'];
	$customer_id			= $_POST['customer_id'];
	$taxing 				= $_POST['tax'];
	$so_id					= $_POST['id'];
	$quantity_array			= $_POST['quantity'];
	
	$sql					= "SELECT id FROM code_delivery_order WHERE guid = '$guid'";
	$result					= $conn->query($sql);
	if(mysqli_num_rows($result) == 0 && $delivery_order_date != ''){
	
		switch (date('m',strtotime($delivery_order_date))) {
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
	
		$sql_number 	= "SELECT number FROM code_delivery_order 
							WHERE MONTH(date) = MONTH('$delivery_order_date') AND YEAR(date) = YEAR('$delivery_order_date') AND number > '0'
							AND isdelete = '0' AND company = 'AE' ORDER BY number ASC LIMIT 1";
		$results 		= $conn->query($sql_number);
		$number			= $results->fetch_assoc();
		$first_number	= $number['number'];
		
		$sql_number 	= "SELECT number FROM code_delivery_order 
							WHERE MONTH(date) = MONTH('$delivery_order_date') AND YEAR(date) = YEAR('$delivery_order_date') AND number > '0'
							AND isdelete = '0' AND company = 'AE' ORDER BY number ASC";
		$results 		= $conn->query($sql_number);
		if (mysqli_num_rows($results) > 0 && $first_number == 1){
			$i 			= 1;
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
	
		if ($taxing == 1){
			$tax_preview = 'P';
		} else {
			$tax_preview = 'N';
		};
	
		$do_name 		= "SJ-AE-" . str_pad($nomor,2,"0",STR_PAD_LEFT) . $tax_preview . "." . date("d",strtotime($delivery_order_date)). "-" . $month. "-" . date("y",strtotime($delivery_order_date));
		
		echo $do_name;
		if($customer_id	!= 0){
			$sql_insert 	= "INSERT INTO code_delivery_order (date,number,tax,name,customer_id,so_id,created_by,created_date,guid) 
								VALUES ('$delivery_order_date','$nomor','$taxing','$do_name','$customer_id','$so_id','$created_by',CURDATE(),'$guid')";
		} else {
			$sql_insert 	= "INSERT INTO code_delivery_order (date,number,tax,name,so_id,created_by,created_date,guid) 
								VALUES ('$delivery_order_date','$nomor','$taxing','$do_name','$so_id','$created_by',CURDATE(),'$guid')";
		}
		
		$result				= $conn->query($sql_insert);	
		if($result){
			$sql_get_id			= "SELECT id FROM code_delivery_order WHERE guid = '$guid'";
			$result_get_id		= $conn->query($sql_get_id);
			$get_id				= $result_get_id->fetch_assoc();
			
			$do_id				= $get_id['id'];
			
			foreach($quantity_array as $quantity){
				$key 					= key($quantity_array);
				$sql					= "SELECT reference, price, sent_quantity, quantity FROM sales_order WHERE id = '$key'";
				$result					= $conn->query($sql);
				$row					= $result->fetch_assoc();
				
				$ordered_quantity		= $row['quantity'];
				$sent_quantity_before	= $row['sent_quantity'];
				$reference				= $row['reference'];
				$price					= $row['price'];
				if($quantity != '' && $quantity > 0){
					$sql_insert_delivery_order 		= "INSERT INTO delivery_order (reference,quantity,do_id,billed_price) VALUES ('$reference','$quantity','$do_id','$price')";
					$conn->query($sql_insert_delivery_order);
					
					$sent_quantity_updated			= $sent_quantity_before + $quantity;
					
					$sql_update 					= "UPDATE sales_order SET sent_quantity = '$sent_quantity_updated' WHERE id = '$key'";
					$conn->query($sql_update);
					
					if($sent_quantity_updated == $ordered_quantity){
						$sql_update					= "UPDATE sales_order SET status = '1' WHERE id = '$key'";
						$conn->query($sql_update);
					}
				}
				
				next($quantity_array);
			};
?>
	<form method='POST' id='delivery_order_form' action='delivery_order_print' target="_blank">
		<input type="hidden" name="id" value="<?= $do_id?>">
	</form>
	</body>
	<script>
		$(document).ready(function () {
			window.setTimeout(function () {
				$('#delivery_order_form').submit();
			}, 400);
			window.setTimeout("location = ('/agungelektrindo/inventory');",500);
		});
	</script>
<?php
		} else {
?>
	<script>
		window.location.href='/agungelektrindo/inventory';
	</script>
<?php
		}
	}
?>