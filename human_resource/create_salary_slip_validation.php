<?php
	include('hrheader.php');
	$bonus = $_POST['bonus'];
	$potongan = $_POST['potongan'];
	if($bonus == ''){
		$bonus = 0;
	}
	if($potongan == ''){
		$potongan = 0;
	}
	$user_id = $_POST['userid'];
	$sql_initial = "SELECT month,year FROM salary WHERE user_id = '" . $user_id . "' AND month = '" . (int)(substr($_POST['absence'],0,2)) . "'
	AND year = '" . substr($_POST['absence'],2,4) . "'";
	$result_initial = $conn->query($sql_initial);
	if(!$result_initial){
?>
	<script>
		window.location.replace("create_salary_slip_dashboard.php");
	</script>
<?php
	} else{
?>
<?php
	}
?>
	<div class='main'>
		<div class='container'>
			<div class='row'>
				<div class='col-sm-6 col-sm-offset-3' style='text-align:center'>
				<img src='../universal/images/Logo Agung.jpg' style='width:100%'>
				Periode <?= substr($_POST['absence'],0,2) . ' - ' . substr($_POST['absence'],2,4) ?>		
				</div>
			</div>
			<hr>
			<div class='row'>
				<div class='col-sm-2'>
<?php
	//create_salary_slip_validation//
	$sql_user = "SELECT * FROM users WHERE id = '" . $user_id . "'";
	$result_user = $conn->query($sql_user);
	while($row_user = $result_user->fetch_assoc()){
		$name = $row_user['name'];
		$address = $row_user['address'];
		$city = $row_user['city'];
		$nik = $row_user['NIK'];
	}
?>
					<p><b>Nama :</b></p>
					<p><b>NIK : </b></p>
					<p><b>Alamat :</b></p>
					<p><b>Kota : </b></p>
					<p><b>Jabatan :</b></p>
				</div>
				<div class='col-sm-4'>
					<p><?= $name ?></p>
					<p><?= $nik ?></p>
					<p><?= $address ?></p>
					<p><?= $city ?></p>
					<p>Staff</p>
				</div>
			</div>
			<br>
			<table class='table' style='text-align:center'>
				<tr>
					<th style='width:20%;text-align:center'>Nomor</th>
					<th style='width:50%;text-align:center'>Keterangan</th>
					<th style='width:30%;text-align:center'>Nominal</th>
				</tr>
				<tr>
					<td>1.</td>
					<td>Gaji pokok</th>
					<td><?= 'Rp. ' . number_format($_POST['basic'],2) ?></td>
				</tr>
				<tr>
					<td>2.</td>
					<td>Gaji harian</th>
					<td><?= 'Rp. ' . number_format($_POST['daily'] * $_POST['working'],2) ?></td>
				</tr>
				<tr>
					<td>3.</td>
					<td>Bonus</th>
					<td><?= 'Rp. ' . number_format($bonus,2) ?></td>
				</tr>
				<tr>
					<td>4.</td>
					<td>Potongan</th>
					<td><?= 'Rp. ' . number_format($potongan,2) ?></td>
				</tr>
				<tfoot>
					<tr>
						<td style='border:none;background-color:white'></td>
						<td>Total Penerimaan</td>
						<td><?= 'Rp. ' . number_format($_POST['basic'] + $_POST['daily'] * $_POST['working'] + $bonus,2) ?>
					</tr>
					<tr>
						<td style='border:none;background-color:white'></td>
						<td>Total Potongan</td>
						<td><?= 'Rp. ' . number_format($potongan); ?>
					</tr>
					<tr>
						<td style='border:none;background-color:white'></td>
						<td>Total</td>
						<td><?= 'Rp. ' . number_format($_POST['basic'] + $_POST['daily'] * $_POST['working'] + $bonus - $potongan,2) ?></td>
					</tr>
				</tfoot>
			</table>
			<form method="POST" action='create_salary_slip.php'>
				<input type='hidden' value='<?= $user_id ?>' name='user_id'>
				<input type='hidden' value='<?= $_POST['basic'] ?>' name='basic'>
				<input type='hidden' value='<?= $_POST['daily'] ?>' name='daily'>
				<input type='hidden' value='<?= $_POST['working'] ?>' name='working'>
				<input type='hidden' value='<?= $bonus ?>' name='bonus'>
				<input type='hidden' value='<?= $potongan ?>' name='potongan'>
				<input type='hidden' value='<?= (int)(substr($_POST['absence'],0,2)) ?>' name='bulan'>
				<input type='hidden' value='<?= substr($_POST['absence'],2,4) ?>' name='tahun'>
				<button type='submit'>Send email</button>
			</form>