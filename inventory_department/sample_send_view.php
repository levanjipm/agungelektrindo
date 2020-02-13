<?php
	include('../codes/connect.php');
	$sql					= "SELECT DISTINCT(sample.code_id) as id, customer.name, customer.address, customer.city
								FROM code_sample 
								JOIN customer ON code_sample.customer_id = customer.id
								JOIN sample ON sample.code_id = code_sample.id
								WHERE code_sample.isconfirm = '1' AND sample.status = '0'";
	$result					= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
	<p style='font-family:museo'>There is no sample to send</p>
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
				<button type='button' class='button_success_dark' onclick='view_sample(<?= $sample_id ?>)'><i class="fa fa-eye" aria-hidden="true"></i></button>
			</td>
		</tr>
<?php
	}
?>
</table>
<form action='sample_send_validation' method='POST' id='send_sample_form'>
	<input type='hidden' id='sample_id' name='id'>
</form>
<script>
	function view_sample(n){
		$('#sample_id').val(n);
		$('#send_sample_form').submit();
	}
</script>
<?php
	}
?>