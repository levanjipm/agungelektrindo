<?php
	include('../codes/connect.php');
?>
<head>
	<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
	<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body style='width:100%; overflow-x:hidden'>
<?php
	$salary_id 		= $_POST['salary_period'];
	$sql_salary 	= "SELECT * FROM salary WHERE id = '$salary_id'";
	$result_salary = $conn->query($sql_salary);
	if(mysqli_num_rows($result_salary) == NULL || mysqli_num_rows($result_salary) == 0){
?>
		<script>
			window.close()
		</script>
<?php
	};
	
	$row		= $result_salary->fetch_assoc();
	$month		= date('F',mktime(0,0,0,$row['month'],1,$row['year']));
	$year		= $row['year'];
	$user_id	= $row['user_id'];
	$basic 		= $row['basic'];
	$working 	= $row['working'];
	$daily 		= $row['daily'];
	$bonus 		= $row['bonus'];
	$cut 		= $row['deduction'];
?>
<div class='main'>
	<div class='row'>
		<div class='col-xs-1' style='background-color:#eee'>
		</div>
		<div class='col-xs-10'>
			<div class='row' style='text-align:center'>
				<div class='col-xs-6 col-xs-offset-3'>
				<img src='../universal/images/Logo Agung.jpg' style='width:100%'>
					Periode <?= $month . " " . $year ?>
				</div>
			</div>
			<hr>
			<div class='row'>
				<div class='col-xs-2'>
<?php
	//create_salary_slip_validation//
	$sql_user = "SELECT * FROM users WHERE id = '" . $user_id . "'";
	$result_user = $conn->query($sql_user);
	while($row_user = $result_user->fetch_assoc()){
		$name 		= $row_user['name'];
		$address 	= $row_user['address'];
		$city 		= $row_user['city'];
		$nik 		= $row_user['NIK'];
		$role 		= $row_user['role'];
	}
?>
					<p><b>Nama :</b></p>
					<p><b>NIK : </b></p>
					<p><b>Alamat :</b></p>
					<p><b>Kota : </b></p>
					<p><b>Jabatan :</b></p>
				</div>
				<div class='col-xs-4'>
					<p><?= $name ?></p>
					<p><?= $nik ?></p>
					<p><?= $address ?></p>
					<p><?= $city ?></p>
					<p><?= $role ?></p>
				</div>
			</div>
			<br>
<?php
	while($salary = $result_salary->fetch_assoc()){
		
	}
?>
			<table class='table table-bordered' style='text-align:center'>
				<tr>
					<th style='width:20%;text-align:center'>Nomor</th>
					<th style='width:50%;text-align:center'>Keterangan</th>
					<th style='width:30%;text-align:center'>Nominal</th>
				</tr>
				<tr>
					<td>1.</td>
					<td>Gaji pokok</th>
					<td><?= 'Rp. ' . number_format($basic,2) ?></td>
				</tr>
				<tr>
					<td>2.</td>
					<td>Gaji harian</th>
					<td><?= 'Rp. ' . number_format($daily * $working,2) ?></td>
				</tr>
				<tr>
					<td>3.</td>
					<td>Bonus</th>
					<td><?= 'Rp. ' . number_format($bonus,2) ?></td>
				</tr>
				<tr>
					<td>4.</td>
					<td>Potongan</th>
					<td><?= 'Rp. ' . number_format($cut,2) ?></td>
				</tr>
				<tfoot>
					<tr>
						<td></td>
						<td>Total Penerimaan</td>
						<td><?= 'Rp. ' . number_format($basic + $daily * $working + $bonus,2) ?>
					</tr>
					<tr>
						<td></td>
						<td>Total Potongan</td>
						<td><?= 'Rp. ' . number_format($cut); ?>
					</tr>
					<tr>
						<td style='border:none;background-color:white'></td>
						<td>Total</td>
						<td><?= 'Rp. ' . number_format($basic + $daily * $working + $bonus - $cut,2) ?></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class='col-xs-1' style='background-color:#eee'>
		</div>
	</div>
</div>
	<div class="row" style="background-color:#333;padding:30px">
		<div class="col-sm-2 offset-sm-5">
			<button class="btn btn-primary hidden-print" type="button" id="print" onclick="printing()">Print</button>
		</div>
	</div>
</div>
<script>
function printing(){
	window.print();
}
</script>
</div>