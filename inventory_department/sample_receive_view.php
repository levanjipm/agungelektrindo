<?php
	include('../codes/connect.php');
	$sql					= "SELECT code_sample_delivery_order.name, code_sample_delivery_order.date, customer.name as customer_name, customer.address, customer.city, code_sample_delivery_order.id
								FROM code_sample_delivery_order 
								JOIN code_sample ON code_sample.id = code_sample_delivery_order.code_sample
								JOIN customer ON code_sample.customer_id = customer.id
								WHERE code_sample_delivery_order.isreturned = '0'";
	$result					= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
	<p style='font-family:museo'>There is no sample to receive</p>
<?php
	} else {
?>
<table class='table table-bordered'>
	<thead>
		<tr>
			<th>Customer</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php
	
	while($row				= $result->fetch_assoc()){
		$delivery_order_name	= $row['name'];
		$delivery_order_date	= $row['date'];
		$customer_name			= $row['customer_name'];
		$customer_address		= $row['address'];
		$customer_city			= $row['city'];
		$delivery_order_id		= $row['id'];
?>
		<tr>
			<td>
				<p><?= $customer_name ?></p>
				<p><?= $customer_address ?></p>
				<p><?= $customer_city ?></p>
			</td>
			<td>
				<button type='button' class='button_success_dark' onclick='receive_sample(<?= $delivery_order_id ?>)'><i class="fa fa-eye" aria-hidden="true"></i></button>
			</td>
		</tr>
<?php
	}
?>
</table>
<form action='sample_receive_validation' method='POST' id='receive_sample_form'>
	<input type='hidden' id='sample_id' name='id'>
</form>
<script>
	function receive_sample(n){
		$('#sample_id').val(n);
		$('#receive_sample_form').submit();
	}
</script>
<?php
	}
?>