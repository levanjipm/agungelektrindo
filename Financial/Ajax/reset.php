<?php
	include('../../codes/connect.php');	
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
			<th>Client</th>
			<th>Input Value</th>
			<th></th>
			<th></th>
		</tr>
<?php
	$sql_table = "SELECT id,name,value,transaction,date FROM code_bank WHERE date >= '" . $start_date . "' AND date <= '" . $end_date . "' AND isdelete = '1'";
	$result_table = $conn->query($sql_table);
	while($table = $result_table->fetch_assoc()){
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
			<td><?= $table['name'] ?></td>
			<td><?= number_format($table['value'],2) . "  " . $trans ?></td>
			<td><button type='button' class='btn btn-danger'>Reset transaction</button></td>
			<td><button type='button' class='btn btn-default'>+</button></td>
		</tr>		
<?php
		}
	}
?>
	</table>
	<p><strong>Saldo akhir:</strong>Rp. <?= number_format($saldo_awal,2) ?></p>