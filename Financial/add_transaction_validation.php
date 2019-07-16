<?php
	include('financialheader.php');
	if(empty($_POST['date']) || empty($_POST['value']) || empty($_POST['lawan'])){
?>
	<script>
		window.history.back();
	</script>
<?php
	}
	$date = $_POST['date'];
	$value = $_POST['value'];
	$lawan = mysqli_real_escape_string($conn,$_POST['lawan']);
	$transaction = $_POST['transaction'];
	$description = mysqli_real_escape_string($conn,$_POST['description']);
	
	if($transaction == 1){
		$trans = 'Debit - ';
	} else if($transaction == 2){
		$trans = 'Credit + ';
	}
	
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-10 col-sm-offset-1'>
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
					<td><?= $lawan ?></td>
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
				<input type='hidden' value='<?= $date ?>' name='date'>
				<input type='hidden' value='<?= $value ?>' name='value'>
				<input type='hidden' value='<?= $lawan ?>' name='opponent'>
				<input type='hidden'value='<?= $transaction ?>' name='transaction'>
				<input type='hidden'value='<?= $transaction ?>' name='transaction'>
				<input type='hidden'value='<?= $description ?>' name='description'>
				<button type='button' class='btn btn-default' id='add_transaction_form_button'>Submit</button>
			</form>
		</div>
	</div>
</div>
<script>
	$('#add_transaction_form_button').click(function(){
		$('#add_transaction_form').submit();
	});
</script>