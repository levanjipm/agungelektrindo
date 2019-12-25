<?php
	include('../codes/connect.php');
	$delivery_order_id			= $_POST['delivery_order_id'];
	$sql						= "SELECT * FROM project_delivery_order WHERE id = '$delivery_order_id'";
	$result						= $conn->query($sql);
	$row						= $result->fetch_assoc();
	$delivery_order_name		= $row['name'];
	$delivery_order_date		= $row['date'];
?>
	<h2 style='font-family:bebasneue'><?= $delivery_order_name ?></h2>
	<p style='font-family:museo'><?= date('d M Y',strtotime($delivery_order_date)) ?></p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
	$sql						= "SELECT project.reference, project.quantity, itemlist.description FROM project 
									JOIN itemlist ON project.reference = itemlist.reference
									WHERE project.project_do_id = '$delivery_order_id'";
	$result						= $conn->query($sql);
	while($row					= $result->fetch_assoc()){
		$reference				= $row['reference'];
		$description			= $row['description'];
		$quantity				= $row['quantity'];
?>
		<tr>	
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity) ?></td>
		</tr>
<?php
	}
?>
	</table>