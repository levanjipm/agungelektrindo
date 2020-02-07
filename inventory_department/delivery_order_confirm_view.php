<?php
	include('../codes/connect.php');
	$sql 		= "SELECT * FROM code_delivery_order WHERE isdelete = '0' AND sent = '0' AND company = 'AE'";
	$results 	= $conn->query($sql);
	if ($results->num_rows > 0){
		while($row_do = $results->fetch_assoc()){
			$sql_sales_order 		= "SELECT type FROM code_salesorder WHERE id = '" . $row_do['so_id'] . "'";
			$result_sales_order 	= $conn->query($sql_sales_order);
			$sales_order 			= $result_sales_order ->fetch_assoc();
			$type 					= $sales_order['type'];
			
			$project_id 			= $row_do['project_id'];
			$customer_id 			= $row_do['customer_id'];
			if($customer_id != 0){
				$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
				$result_customer 	= $conn->query($sql_customer);
				$row_customer 		= $result_customer->fetch_assoc();
				$customer_name 		= $row_customer['name'];
			} else {
				$sql 				= "SELECT code_salesorder.retail_address, code_salesorder.retail_name, code_salesorder.retail_phone, code_salesorder.retail_phone
									FROM code_salesorder
									JOIN code_delivery_order ON code_salesorder.id = code_delivery_order.so_id
									WHERE code_delivery_order.id = '" . $row_do['id'] . "'";
				$result 			= $conn->query($sql);
				$customer 			= $result->fetch_assoc();
				$customer_name 		= $customer['retail_name'];
			}
?>
		<div class='col-sm-2 col-xs-3'>
			<h1 style='font-size:4em;text-align:center'><i class="fa fa-file-text-o" aria-hidden="true"></i></h1>
			<br>
			<p style="text-align:center"><?= $row_do['name'];?></p>
			<p style="text-align:center"><b><?= $customer_name?></b></p>	
			<p style="text-align:center">
				<button class='button_success_dark' onclick='view_delivery_order(<?= $row_do['id'] ?>)'><i class="fa fa-check" aria-hidden="true"></i></button>
			</p>
		</div>
<?php
		}
	} else {
?>
	<p style='font-family:museo'>There are no delivery order need to be approved</p>
<?php
	}
?>