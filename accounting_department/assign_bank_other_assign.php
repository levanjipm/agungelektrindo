<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Assign bank as other</title>
</head>
<?php
	$transaction_id		= $_POST['id'];
	$sql 				= "SELECT * FROM code_bank WHERE id = '$transaction_id'";
	$result 			= $conn->query($sql);
	$row 				= $result->fetch_assoc();
	
	$description		= $row['description'];
	$transaction_date	= $row['date'];
	$transaction_value	= $row['value'];
	
	$opponent_id = $row['bank_opponent_id'];
	$opponent_type = $row['label'];
	
	if($opponent_type == 'CUSTOMER'){
		$database = 'customer';
	} else if($opponent_type == 'SUPPLIER'){
		$database = 'supplier';
	} else if($opponent_type == 'OTHER'){
		$database = 'bank_account_other';
	};
	
	$sql_selector 		= "SELECT name FROM " . $database . " WHERE id = '" . $opponent_id . "'";
	$result_selector 	= $conn->query($sql_selector);
	$selector 			= $result_selector->fetch_assoc();
	
	$name				= $selector['name'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank</h2>
	<p style='font-family:museo'>Assign bank as other</p>
	<hr>
	<label>Transaction data</label>
	<p style='font-family:museo'><?= $selector['name'] ?></p>
	<p style='font-family:museo'><?= date('d M Y',strtotime($transaction_date)) ?></p>
	<p style='font-family:museo'>Rp. <?= number_format($transaction_value,2) ?></p>
	<hr>
	<form action='assign_bank_other_input.php' method='POST' id='input_form'>
		<input type='hidden' value='<?= $transaction_id ?>' name='id' readonly>
		<hr>
		<table class='table table-hover'>
			<tr>
				<td>Value</td>
				<td>Rp. <?= number_format($transaction_value,2) ?></td>
			</tr>
			<tr>
				<td>Assigned as</td>
				<td><?php
					$sql = "SELECT name,major_id FROM petty_cash_classification WHERE id = '" . $_POST['type'] . "'";
					$result = $conn->query($sql);
					$row = $result->fetch_assoc();
					$new_major = 0;
					if($row['major_id'] == 0){
					} else {
						$sql_head = "SELECT name FROM petty_cash_classification WHERE id = '" . $row['major_id'] . "'";
						$result_head = $conn->query($sql_head);
						$new_major = $row['major_id'];
					}
					$sql_major = "SELECT name FROM petty_cash_classification WHERE id = '" . $new_major . "'";
					$result_major = $conn->query($sql_major);
					$major = $result_major->fetch_assoc();
					echo $row['name'] . ' - ' . $major['name'];
				?>
				<input type='hidden' value='<?= $_POST['type'] ?>' name='type'>
				</td>
			</tr>
			<tr>
				<td>Other information</td>
				<td>
					<?= mysqli_real_escape_string($conn,$_POST['keterangan']) ?>
					<input type='hidden' value='<?= mysqli_real_escape_string($conn,$_POST['keterangan']) ?>' name='keterangan' readonly>
				</td>
			</tr>
		</table>
		<br>
		<button type='button' class='button_default_dark' id='assign_other'>Assign</button>
	</form>
</div>
<script>
	$('#assign_other').click(function(){
		$('#input_form').submit();
	});
</script>
