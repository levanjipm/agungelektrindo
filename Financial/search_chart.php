<?php
	include('../codes/connect.php');
	$month = $_POST['month'];
	$year = $_POST['year'];
	$pengeluaran = 0;
	if($_POST['filter'] == 0){
		$sql_check = "SELECT COUNT(id) AS jumlah FROM petty_cash WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'";
		$result_check = $conn->query($sql_check);
		$check = $result_check->fetch_assoc();
		$checking = $check['jumlah'];
	} else {
		$sql_check = "SELECT COUNT(id) AS jumlah FROM petty_cash WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'
		AND class = '" . $_POST['filter'] . "'";
		$result_check = $conn->query($sql_check);
		$check = $result_check->fetch_assoc();
		$checking = $check['jumlah'];
			$sql_kelas = "SELECT * FROM petty_cash_classification WHERE major_id = '" . $_POST['filter'] . "'";
			$result_kelas = $conn->query($sql_kelas);	
			while($kelas = $result_kelas->fetch_assoc()){
				$sql_sub = "SELECT COUNT(id) AS jumlah FROM petty_cash WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'
				AND class = '" . $kelas['id'] . "'";
				$result_sub = $conn->query($sql_sub);
				$sub = $result_sub->fetch_assoc();
				$checking = $checking + $sub['jumlah'];
			}
	}
	if($month == 0 && $year != 0){
?>
<style>
	.box{
		margin-bottom:0px;
	}
</style>
<div class='row'>
<?php
		$sql_maximum = "SELECT MAX(value) AS maximum FROM petty_cash WHERE YEAR(date) = '" . $year . "' GROUP BY MONTH(date)";
		$result_maximum = $conn->query($sql_maximum);
		$max = $result_maximum->fetch_assoc();
		$maximum_value = $max['maximum'];
		$x = 1;
		for($x = 1;$x <= 12; $x++){
?>
<?php
			
			
			
			$sql_chart = "SELECT SUM(value) AS pengeluaran FROM petty_cash WHERE MONTH(date) = '" . $x . "' AND YEAR(date) = '" . $year . "'";
			$result_chart = $conn->query($sql_chart);
			while($chart = $result_chart->fetch_assoc()){
?>
	<div class='col-sm-1' style='height:<?= $chart['pengeluaran'] * 40 / $maximum_value ?>px;background-color:green;position:relative;bottom:0;left:auto;margin-left:2px;display:inline-flex'></div>
<?php
			}
		}
?>
</div>
<?php
	} else if($month != 0 && $year !=0){
		$jumlah_hari = cal_days_in_month (CAL_GREGORIAN,$month,$year);
	}
?>