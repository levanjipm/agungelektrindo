<?php
	include('../codes/connect.php');
	$term			= mysqli_real_escape_string($conn, $_GET['term']);
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Customer</th>
		</tr>
<?php	
	$sql			= "SELECT id FROM code_delivery_order WHERE name LIKE '%$term%' AND code_delivery_order.isinvoiced = '0'
						UNION (SELECT code_delivery_order.id FROM code_delivery_order 
							JOIN customer ON code_delivery_order.customer_id = customer.id
							WHERE customer.name LIKE '%$term%' OR customer.pic LIKE '%$term%' OR customer.city LIKE '%$term%' OR customer.address LIKE '%$term%'
							AND code_delivery_order.isinvoiced = '0')
						UNION (SELECT code_delivery_order.id FROM code_delivery_order
							JOIN code_salesorder ON code_delivery_order.so_id = code_salesorder.id
							WHERE code_salesorder.retail_name LIKE '%$term%'  OR code_salesorder.retail_address LIKE '%$term%' OR code_salesorder.retail_city LIKE '%$term%' OR code_salesorder.name LIKE '%$term%' OR code_salesorder.po_number LIKE '%$term%' AND code_delivery_order.isinvoiced = '0')
						UNION (SELECT delivery_order.do_id as id FROM delivery_order 
							JOIN itemlist ON delivery_order.reference = itemlist.reference
							JOIN code_delivery_order ON delivery_order.do_id = code_delivery_order.id
							WHERE delivery_order.reference LIKE '%$term%' OR itemlist.description LIKE '%$term%' AND code_delivery_order.isinvoiced = '0')";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$delivery_order_id		= $row['id'];
		$sql_delivery_order		= "SELECT name, date, customer_id FROM code_delivery_order WHERE id = '$delivery_order_id'";
		$result_delivery_order	= $conn->query($sql_delivery_order);
		$delivery_order			= $result_delivery_order->fetch_assoc();
		
		$do_name				= $delivery_order['name'];
		$do_date				= $delivery_order['date'];
		$customer_id			= $delivery_order['customer_id'];
		
		if($customer_id			== 0 || $customer_id == NULL){
			$sql_customer		= "SELECT code_salesorder.retail_name, code_salesorder.retail_address, code_salesorder.retail_city
									FROM code_salesorder
									JOIN code_delivery_order ON code_delivery_order.so_id = code_salesorder.id
									WHERE code_delivery_order.id = '$delivery_order_id'";
			$result_customer	= $conn->query($sql_customer);
			$customer			= $result_customer->fetch_assoc();
			
			$customer_name			= $customer['retail_name'];
			$customer_address		= $customer['retail_address'];
			$customer_city			= $customer['retail_city'];
		} else {
			$sql_customer			= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
			$result_customer		= $conn->query($sql_customer);
			$customer				= $result_customer->fetch_assoc();
			
			$customer_name			= $customer['name'];
			$customer_address		= $customer['address'];
			$customer_city			= $customer['city'];
		}
		
		$sql_status					= "SELECT id FROM stock_value_out WHERE customer_id = '$customer_id' AND document = '$do_name'";
		$result_status				= $conn->query($sql_status);
		$status						= mysqli_num_rows($result_status);
		
		$sql_return					= "SELECT * FROM code_sales_return WHERE do_id = '$delivery_order_id'";
		$result_return				= $conn->query($sql_return);
		$status						+= mysqli_num_rows($result_return);
?>
		<tr>
			<td><?= date('d M Y',strtotime($do_date)) ?></td>
			<td><?= $do_name ?></td>
			<td>
				<p style='font-family:museo'><?= $customer_name ?></p>
				<p style='font-family:museo'><?= $customer_address ?></p>
				<p style='font-family:museo'><?= $customer_city ?></p>
			</td>
			<td>
<?php
	if($status	> 0){
?>
				<button type='button' class='button_success_dark' onclick='delete_delivery_order(<?= $delivery_order_id ?>)'><i class='fa fa-trash'></i></button>
<?php
	}
?>
			</td>
		</tr>
<?php
	}
?>
	</table>
	<form action='delivery_order_delete_validate' id='delivery_order_delete_form' method='POST'>
		<input type='hidden' id='delivery_order_id' name='id'>
	</form>
	<script>
		function delete_delivery_order(n){
			$('#delivery_order_id').val(n);
			$('#delivery_order_delete_form').submit();
		}
	</script>