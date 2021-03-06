<?php
	include('../codes/connect.php');
	$month 					= $_POST['month'];
	$year 					= $_POST['year'];
	$pengeluaran 			= 0;
	if($_POST['filter'] 	== 0){
		$sql_balance		= "SELECT SUM(value) as expense FROM petty_cash WHERE class <> '25' AND date < '" . date('Y-m-d',mktime(0,0,0,$month, 1, $year)) . "'";
		$result_balance		= $conn->query($sql_balance);
		$balance			= $result_balance->fetch_assoc();
		
		$expense			= $balance['expense'];
		
		$sql_balance		= "SELECT SUM(value) as income FROM petty_cash WHERE class = '25' AND date  < '" . date('Y-m-d',mktime(0,0,0,$month, 1, $year)) . "'";
		$result_balance		= $conn->query($sql_balance);
		$balance			= $result_balance->fetch_assoc();
		
		$income				= $balance['income'];
		
		$balance			= $income - $expense;
		
		$sql_check 			= "SELECT COUNT(id) AS jumlah FROM petty_cash WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'";
		$result_check 		= $conn->query($sql_check);
		$check 				= $result_check->fetch_assoc();
		$checking 			= $check['jumlah'];
	} else {		
		$sql_check 			= "SELECT COUNT(id) AS jumlah FROM petty_cash WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'
								AND class = '" . $_POST['filter'] . "'";
		$result_check 		= $conn->query($sql_check);
		$check 				= $result_check->fetch_assoc();
		$checking 			= $check['jumlah'];
		$sql_kelas 			= "SELECT * FROM petty_cash_classification WHERE major_id = '" . $_POST['filter'] . "'";
		$result_kelas 		= $conn->query($sql_kelas);	
		while($kelas 		= $result_kelas->fetch_assoc()){
			$sql_sub 		= "SELECT COUNT(id) AS jumlah FROM petty_cash WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'
								AND class = '" . $kelas['id'] . "'";
			$result_sub 	= $conn->query($sql_sub);
			$sub 			= $result_sub->fetch_assoc();
			$checking 		+= $sub['jumlah'];
		}
	}
	
	if($checking != 0){
?>
	<h3 style='font-family:bebasneue'>Monthly petty cash report</h2>
	<p style='font-family:museo'><?=  date('F', mktime(0, 0, 0, $month, 10)) . " " . $year?></p>
<?php
	if($_POST['filter'] != 0){
		$sql_name 		= "SELECT name FROM petty_cash_classification WHERE id = '" . $_POST['filter'] . "'";
		$result_name 	= $conn->query($sql_name);
		$name 			= $result_name->fetch_assoc();
?>
	<p><strong>Filter by class name: </strong><?= $name['name'] ?></p>
<?php
	}
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Value</th>
			<th>Info</th>
			<th>Class</th>
			<th>Balance</th>
		</tr>
<?php
	if($_POST['filter'] == 0){
		$sql 					= "SELECT petty_cash.value, petty_cash.date, petty_cash.info, petty_cash_classification.name, petty_cash.class
									FROM petty_cash 
									JOIN petty_cash_classification ON petty_cash.class = petty_cash_classification.id
									WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'";
		$result 				= $conn->query($sql);
		while($row 				= $result->fetch_assoc()){
			$value				= $row['value'];
			$date				= $row['date'];
			$class_name			= $row['name'];
			$class_id			= $row['class'];
			$info				= $row['info'];
			if($class_id	 	== 25){
				$balance		+= $value;
?>
		<tr class='success'>
			<td><?= date('d M Y', strtotime($date)) ?></td>
			<td>Rp. <?= number_format($value,2) ?></td>
			<td></td>
			<td><?= $class_name ?></td>
			<td>Rp. <?= number_format($balance,2) ?></td>
		</tr>
<?php
			} else {
				$balance		-= $value;
?>
		<tr>
			<td><?= date('d M Y', strtotime($date)) ?></td>
			<td>Rp. <?= number_format($value,2) ?></td>
			<td><?= $info ?></td>
			<td><?= $class_name ?></td>
			<td>Rp. <?= number_format($balance,2) ?></td>
		</tr>
<?php
		$pengeluaran = $pengeluaran + $row['value'];
			}
		}  
	} else {
		$sql_initial 		= "(SELECT * FROM petty_cash_classification WHERE major_id = '" . $_POST['filter'] . "')
								UNION (SELECT * FROM petty_cash_classification WHERE id = '" . $_POST['filter'] . "') ORDER BY id ASC";
		$result_initial 	= $conn->query($sql_initial);
		while($initial 		= $result_initial->fetch_assoc()){
			$sql 			= "SELECT * FROM petty_cash WHERE class = '" . $initial['id'] . "' AND MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'";
			$result 		= $conn->query($sql);
			while($row 		= $result->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y', strtotime($row['date'])) ?></td>
			<td>Rp. <?= number_format($row['value'],2) ?></td>
			<td><?= $row['info'] ?></td>
			<td><?php
				$sql_class = "SELECT * FROM petty_cash_classification WHERE id = '" . $row['class'] . "'";
				$result_class = $conn->query($sql_class);
				$class = $result_class->fetch_assoc();
				echo $class['name']
			?></td>
			<td></td>
		</tr>
<?php
			$pengeluaran = $pengeluaran + $row['value'];
			}
		}
	}
?>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>Total Pengeluaran</td>
			<td>Rp. <?= number_format($pengeluaran,2) ?></td>
		</tr>
	</table>
	<footer>
		CV Agung Elektrindo &#9400; 2014 - <?= date('Y') ?>
		All copyrights reserved.
		Printed on <?= date('d M Y')?>, by <?= $_POST['username'] ?>
	</footer>
<?php
	}
?>