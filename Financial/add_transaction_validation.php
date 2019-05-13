<?php
	include('financialheader.php');
	if(empty($_POST['date']) || empty($_POST['value']) || empty($_POST['lawan'])){
		header('location:add_transaction_dashboard.php');	
	} else {
		$date = $_POST['date'];
		$value = $_POST['value'];
		$lawan = $_POST['lawan'];
		$transaction = $_POST['transaction'];
	}
	if($transaction == 1){
		$trans = 'Debit - ';
	} else if($transaction == 2){
		$trans = 'Credit + ';
	}
?>
<div class='main'>
	<div class='container'>
		<h2>Input Transaction</h2>
		<hr>
	</div>
	<div class='row'>
		<table class='table table-condensed'>
			<tr>
				<th>Date</th>
				<td><?= date('d M Y',strtotime($date)) ?></td>
			</tr>
			<tr>
				<th>Opponent</th>
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
				<th>Transaction</th>
				<td><?= $trans ?></td>
			</tr>
			<tr>
				<th>Value</th>
				<td>Rp. <?= number_format($value,2) ?></td>
			</tr>
		</table>
	</div>
	<form method='POST' action='add_transaction_input.php'>
		<input type='hidden' value='<?= $date ?>' name='date'>
		<input type='hidden' value='<?= $value ?>' name='value'>
		<input type='hidden' value='<?= $lawan ?>' name='lawan'>
		<input type='hidden'value='<?= $transaction ?>' name='transaction'>
		<button type='submit' class='btn btn-default'>Submit</button>
	</form>
</div>