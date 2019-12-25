<?php
	include('../codes/connect.php');
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
	$sql					= "SELECT code_sample.id, customer.name, customer.address, customer.city
								FROM code_sample 
								JOIN customer ON code_sample.customer_id = customer.id
								WHERE code_sample.isconfirm = '1' AND code_sample.issent = '1' AND isback = '0'";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		$sample_id			= $row['id'];
		$customer_name		= $row['name'];
		$customer_address	= $row['address'];
		$customer_city		= $row['city'];
?>
		<tr>
			<td>
				<p><?= $customer_name ?></p>
				<p><?= $customer_address ?></p>
				<p><?= $customer_city ?></p>
			</td>
			<td>
				<button type='button' class='button_success_dark' onclick='receive_sample(<?= $sample_id ?>)'><i class="fa fa-eye" aria-hidden="true"></i></button>
			</td>
		</tr>
<?php
	}
?>
</table>
<form action='sample_receive_validation' method='POST' id='sample_form'>
	<input type='hidden' id='sample_id' name='id'>
</form>
<script>
	function receive_sample(n){
		$('#sample_id').val(n);
		$('#sample_form').submit();
	}
</script>