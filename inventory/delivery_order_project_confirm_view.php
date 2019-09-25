<?php
	include('../codes/connect.php');
	$delivery_order_id		= $_POST['delivery_order_id'];
	$sql_project			= "SELECT name, project_id FROM project_delivery_order WHERE id = '$delivery_order_id'";
	$result_project			= $conn->query($sql_project);
	$project				= $result_project->fetch_assoc();
	
	$project_id				= $project['project_id'];
	$delivery_order_name	= $project['name'];
	
	$sql_code_project		= "SELECT project_name, customer_id FROM code_project WHERE id = '$project_id'";
	$result_code_project	= $conn->query($sql_code_project);
	$code_project			= $result_code_project->fetch_assoc();
	
	$customer_id			= $code_project['customer_id'];
	
	$sql_customer			= "SELECT name FROM customer WHERE id = '$customer_id'";
	$result_customer		= $conn->query($sql_customer);
	$customer				= $result_customer->fetch_assoc();
	
	$customer_name			= $customer['name'];
	
	$project_name			= $code_project['project_name'];
?>
	<h2 style='font-family:bebasneue'><?= $delivery_order_name ?></h2>
	<p><?= $customer_name ?></p>
	<label>Project</label>
	<p><?= $project_name ?></p>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
	$sql_detail				= "SELECT reference, quantity FROM project WHERE project_do_id = '$delivery_order_id'";
	$result_detail			= $conn->query($sql_detail);
	while($detail			= $result_detail->fetch_assoc()){
		$reference			= $detail['reference'];
		$quantity			= $detail['quantity'];
		$sql_item			= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item		= $conn->query($sql_item);
		$item				= $result_item->fetch_assoc();
		
		$item_description	= $item['description'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $item_description ?></td>
			<td><?= $quantity ?></td>
		</tr>
<?php
	}
?>
	</table>
	<button type='button' class='button_success_dark'>Confirm</button>