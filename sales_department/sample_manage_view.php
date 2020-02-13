<?php
	include('../codes/connect.php');
	$id					= $_GET['id'];
	$sql				= "SELECT customer.name, customer.address, customer.city, code_sample.date
							FROM code_sample
							JOIN customer ON code_sample.customer_id = customer.id
							WHERE code_sample.id = '$id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	$customer_name		= $row['name'];
	$customer_address	= $row['address'];
	$customer_city		= $row['city'];
	$date				= $row['date'];
	
	$sql				= "SELECT sample.reference, itemlist.description, sample.quantity, sample.sent
							FROM sample
							JOIN itemlist ON sample.reference = itemlist.reference
							WHERE sample.code_id = '$id'";
	$result				= $conn->query($sql);
?>
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Pending</th>
		</tr>
<?php
	while($row	= $result->fetch_assoc()){
		$reference			= $row['reference'];
		$description		= $row['description'];
		$quantity			= $row['quantity'];
		$sent				= $row['sent'];
		
		$pending			= $quantity - $sent;
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity) ?></td>
			<td><?= number_format($pending) ?></td>
		</tr>
<?php
	}
?>
	</table>
	<form action='sample_manage' method='POST'>
		<input type='hidden' value='<?= $id ?>' name='id'>
		<button type='submit' class='button_success_dark' title='Edit sample data'><i class='fa fa-pencil'></i></button>
	</form>