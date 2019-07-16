<?php
	include('../codes/connect.php');	
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$sql_initial1 = "SELECT SUM(value) AS saldo_awal_debit FROM code_bank WHERE date < '" . $start_date . "' AND transaction = '1'";
	$result_initial1 = $conn->query($sql_initial1);
	$initial1 = $result_initial1->fetch_assoc();
	$sql_initial2 = "SELECT SUM(value) AS saldo_awal_credit FROM code_bank WHERE date < '" . $start_date . "' AND transaction = '2'";
	$result_initial2 = $conn->query($sql_initial2);
	$initial2 = $result_initial2->fetch_assoc();
	
	$saldo_awal = $initial2['saldo_awal_credit'] - $initial1['saldo_awal_debit'];
	
?>
	<p><strong>Saldo awal:</strong>Rp. <?= number_format($saldo_awal,2) ?></p>
	<table class='table table-hovered'>
		<tr>
			<th>Date</th>
			<th>Opponent</th>
			<th>Opponent_type</th>
			<th>Value</th>		
			<th>Balance</th>
		</tr>
<?php
	$sql_table = "SELECT id,bank_opponent_id,label,value,transaction,date FROM code_bank WHERE date >= '" . $start_date . "' AND date <= '" . $end_date . "'";
	$result_table = $conn->query($sql_table);
	while($table = $result_table->fetch_assoc()){
		$label = $table['label'];
		if($label == 'CUSTOMER'){
			$table_from_label = 'customer';
		} else if($label == 'SUPPLIER'){
			$table_from_label = 'supplier';
		} else {
			$table_from_label = 'bank_account_other';
		}
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
			<td>
				<?php
					$sql_opponent = "SELECT * FROM " . $table_from_label . " WHERE id = '" . $table['id'] . "'";
					$result_opponent = $conn->query($sql_opponent);
					$opponent = $result_opponent->fetch_assoc();
					echo $opponent['name'];
				?>
			</td>
			<td><?= $label ?></td>
			<td><?= number_format($table['value'],2) . "  " . $trans ?></td>
			<td>Rp. <?= number_format($saldo_awal,2) ?></td>
		</tr>
<?php
	}
?>
	</table>
	<p><strong>Saldo akhir:</strong>Rp. <?= number_format($saldo_awal,2) ?></p>