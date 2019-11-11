<?php
	include('financialheader.php');
	if(empty($_POST['date']) || empty($_POST['value']) || empty($_POST['lawan'])){
?>
	<script>
		// window.history.back();
	</script>
<?php
	}
	
	$date 						= $_POST['date'];
	$value 						= $_POST['value'];
	$transaction_type			= $_POST['transaction'];
	$transaction_to				= $_POST['transaction_to'];
	
	if($transaction_to			== 'customer'){
		$database				= 'customer';
	} else if($transaction_to	== 'supplier'){
		$database				= 'supplier';
	} else if($transaction_to	== 'other'){
		$database				= 'bank_account_other';
	}
	
	$transaction_id				= $_POST['transaction_select_to'];
	
	$sql_transaction			= "SELECT name FROM " . $database . " WHERE id = '$transaction_id'";
	$result_transaction			= $conn->query($sql_transaction);
	$transaction				= $result_transaction->fetch_assoc();

	$name						= $transaction['name'];
	
	$description 				= mysqli_real_escape_string($conn,$_POST['description']);
	
	if($transaction_type == 1){
		$trans = 'Debit - ';
	} else if($transaction_type == 2){
		$trans = 'Credit + ';
	}
	
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-12'>
			<h2 style='font-family:bebasneue'>Bank Account</h2>
			<p>Add transaction</p>
			<hr>
			<table class='table table-hover'>
				<tr>
					<td style='width:30%'><strong>Date</strong></td>
					<td><?= date('d M Y',strtotime($date)) ?></td>
				</tr>
				<tr>
					<td><strong>Opponent</strong></td>
					<td><?= $name ?></td>
				</tr>
<?php
	if($transaction == 2){
?>
				<tr class='success'>
<?php
	} else if($transaction == 1){
?>
				<tr class='warning'>
<?php
	}
?>
					<td><strong>Transaction</strong></td>
					<td><?= $trans ?></td>
				</tr>
				<tr>
					<td><strong>Value</strong></td>
					<td>Rp. <?= number_format($value,2) ?></td>
				</tr>
				<tr>
				<tr>
					<td><strong>Description</td>
					<td><?= $_POST['description'] ?></td>
				</tr>
			</table>
			<form method='POST' action='add_transaction_input.php' id='add_transaction_form'>
				<input type='hidden' value='<?= $date ?>' 				name='transaction_date'>
				<input type='hidden' value='<?= $value ?>' 				name='transaction_value'>
				<input type='hidden' value='<?= $transaction_type ?>' 	name='transaction_type'>
				<input type='hidden' value='<?= $transaction_to ?>' 	name='transaction_to'>
				<input type='hidden' value='<?= $transaction_id ?>' 	name='transaction_id'>
				<input type='hidden' value='<?= $description ?>'		name='transaction_description'>
				<button type='button' class='button_success_dark' id='add_transaction_form_button'>Submit</button>
			</form>
		</div>
	</div>
</div>
<script>
	$('#add_transaction_form_button').click(function(){
		$('#add_transaction_form').submit();
	});
</script>