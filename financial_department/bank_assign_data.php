<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
?>
<head>
	<title>Assign bank data</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank</h2>
	<p style='font-family:museo'>Assign empty bank data</p>
	<hr>
<?php
	$sql_check		= "SELECT * FROM code_bank WHERE label IS NULL";
	$result_check	= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) > 0){
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Value</th>
		</tr>
<?php
		while($row		= $result_check->fetch_assoc()){
			$date		= $row['date'];
			$value		= $row['value'];
			$id			= $row['id'];
?>
	<tr>
		<td><?= date('d M Y',strtotime($date)) ?></td>
		<td>Rp. <?= number_format($value,2) ?></td>
		<td><button type='button' class='button_success_dark' onclick='edit_bank_data(<?= $id ?>)'><i class='fa fa-pencil'></i></button></td>
	</tr>
<?php
		}
?>
	</table>
	<form action='bank_assign_validate' method='POST' id='bank_form'>
		<input type='hidden' id='bank_id' name='id'>
	</form>
	<script>
		function edit_bank_data(n){
			$('#bank_id').val(n);
			$('#bank_form').submit();
		}
	</script>
<?php
	} else {
?>
	<p style='font-family:museo'>There is no bank data to assign</p>
<?php
	}
?>
</div>