<?php
	include('inventoryheader.php');
?>
<div class='main'>
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
			<td><?= $sample['id'] ?></td>
		</tr>
<?php
	}
?>
</div>