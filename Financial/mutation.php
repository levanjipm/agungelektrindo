<?php
	include('../codes/connect.php');	
	$start_date 		= $_POST['start_date'];
	$end_date 			= $_POST['end_date'];
	
	$sql_debit_balance		= "SELECT SUM(value) AS initial_debit_balance FROM code_bank WHERE date < '" . $start_date . "' AND transaction = '1' AND major_id ='0'";
	$result_debit_balance	= $conn->query($sql_debit_balance);
	$debit	 				= $result_debit_balance->fetch_assoc();

	$sql_credit_balance		= "SELECT SUM(value) AS initial_credit_balance FROM code_bank WHERE date < '" . $start_date . "' AND transaction = '2' AND major_id ='0'";
	$result_credit_balance	= $conn->query($sql_credit_balance);
	$credit 				= $result_credit_balance->fetch_assoc();
	
	$saldo_awal = $credit['initial_credit_balance'] - $debit['initial_debit_balance'];
	
?>
	<br>
	<label>Initial balance</label>
	<p>Rp. <?= number_format($saldo_awal,2) ?></p>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Opponent</th>
			<th>Opponent_type</th>
			<th>Value</th>		
			<th>Balance</th>
		</tr>
<?php
	$sql_table 		= "SELECT id,bank_opponent_id,label,value,transaction,date FROM code_bank WHERE date >= '" . $start_date . "' AND date <= '" . $end_date . "' AND major_id = '0' ORDER BY date ASC, id ASC";
	$result_table 	= $conn->query($sql_table);
	while($table 	= $result_table->fetch_assoc()){
		$label 		= $table['label'];
		if($label == 'CUSTOMER'){
			$table_from_label = 'customer';
		} else if($label == 'SUPPLIER'){
			$table_from_label = 'supplier';
		} else {
			$table_from_label = 'bank_account_other';
		}
		
		$sql_opponent 		= "SELECT name FROM " . $table_from_label . " WHERE id = '" . $table['bank_opponent_id'] . "'";
		$result_opponent 	= $conn->query($sql_opponent);
		$opponent 			= $result_opponent->fetch_assoc();
		
		$opponent_name		= $opponent['name'];
		
		$date = $table['date'];
		$saldo_awal = $table['transaction'] == '1' ? $saldo_awal - $table['value'] : $saldo_awal + $table['value'];
		if($table['transaction'] == 1){
			$trans = 'DB';
			echo ('<tr class="warning">');
		} else {
			$trans = 'CR';
			echo ('<tr class="success">');
		}
		?>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td><?= $opponent_name ?></td>
			<td><?= $label ?></td>
			<td><?= number_format($table['value'],2) . "  " . $trans ?></td>
			<td>Rp. <?= number_format($saldo_awal,2) ?></td>
		</tr>
<?php
	}
?>
	</table>
	<label>Final Balance</label>
	<p>Rp. <?= number_format($saldo_awal,2) ?></p>