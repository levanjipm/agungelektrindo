<?php
	include('inventoryheader.php');
?>
<div class='main'>
	<h2>Sample</h2>
	<p>Send sample</p>
	<hr>
	<table class='table table-hover'>
		<tr>
			<th>Date</th>
			<th>Customer</th>
			<th></th>
		</tr>
<?php
	$sql_sample = "SELECT * FROM code_sample WHERE isconfirm = '1'";
	$result_sample = $conn->query($sql_sample);
	while($sample = $result_sample->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y', strtotime($sample['date'])) ?></td>
			<td><?php
				$sql_customer = "SELECT name FROM customer WHERE id = '" . $sample['customer_id'] . "'";
				$result_customer = $conn->query($sql_customer);
				$customer = $result_customer->fetch_assoc();
				echo $customer['name'];
			?></td>
			<td>
				<button type='button' class='btn btn-default' onclick='submit(<?= $sample['id'] ?>)'>Send sample</button>
			</td>
			<form action='sample_validation.php' method='POST' id='send_form<?= $sample['id'] ?>'>
				<input type='hidden' value='<?= $sample['id'] ?>' name='id'>
			</form>
		</tr>
<?php
	}
?>
</div>
<script>
	function submit(n){
		$('#send_form' + n).submit();
	}
</script>