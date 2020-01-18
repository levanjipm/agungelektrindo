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
	$sql			= "SELECT id FROM project_delivery_order WHERE name LIKE '%$term%'
						UNION (SELECT project_delivery_order.id FROM project_delivery_order 
							JOIN code_project ON project_delivery_order.project_id = code_project.id
							JOIN customer ON code_project.customer_id = customer.id
							WHERE customer.name LIKE '%$term%' OR customer.pic LIKE '%$term%' OR customer.city LIKE '%$term%' OR customer.address LIKE '%$term%')
						UNION (SELECT project.project_do_id as id FROM project 
							JOIN itemlist ON project.reference = itemlist.reference
							JOIN project_delivery_order ON project.project_do_id = project_delivery_order.id
							WHERE project.reference LIKE '%$term%' OR itemlist.description LIKE '%$term%')";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$delivery_order_id		= $row['id'];
		$sql_delivery_order		= "SELECT project_delivery_order.date, project_delivery_order.name, code_project.customer_id FROM code_project 
									JOIN project_delivery_order ON code_project.id = project_delivery_order.project_id
									WHERE project_delivery_order.id = '$delivery_order_id'";
		$result_delivery_order	= $conn->query($sql_delivery_order);
		$delivery_order			= $result_delivery_order->fetch_assoc();
		
		$do_name				= $delivery_order['name'];
		$do_date				= $delivery_order['date'];
		$customer_id			= $delivery_order['customer_id'];
		
		$sql_customer			= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
		$result_customer		= $conn->query($sql_customer);
		$customer				= $result_customer->fetch_assoc();
		
		$customer_name			= $customer['name'];
		$customer_address		= $customer['address'];
		$customer_city			= $customer['city'];
		
		$sql_status				= "SELECT id FROM stock_value_out WHERE customer_id = '$customer_id' AND document = '$do_name'";
		$result_status			= $conn->query($sql_status);
		$status					= mysqli_num_rows($result_status);
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
	<form action='delivery_order_project_delete_validate' id='delivery_order_delete_form' method='POST'>
		<input type='hidden' id='delivery_order_id' name='id'>
	</form>
	<script>
		function delete_delivery_order(n){
			$('#delivery_order_id').val(n);
			$('#delivery_order_delete_form').submit();
		}
	</script>