<?php
	include('../codes/connect.php');
	$bonus 				= (int)$_POST['bonus'];
	$deduction 			= (int)$_POST['deduction'];
	$user_id 			= $_POST['user_salary'];
	$month				= $_POST['month'];
	$year				= $_POST['year'];
	$daily_wage			= (int)$_POST['daily'];
	$basic_wage			= (int)$_POST['basic'];
	
	$sql_absent			= "SELECT * FROM absentee_list WHERE user_id = '$user_id' AND MONTH(date) = '$month' AND YEAR(date) = '$year' AND isdelete = '0'";
	$result_absent		= $conn->query($sql_absent);
	
	$absentee			= mysqli_num_rows($result_absent);
	
	$received			= $basic_wage + $daily_wage * $absentee + $bonus;
	
	$sql_user 			= "SELECT * FROM users WHERE id = '" . $user_id . "'";
	$result_user 		= $conn->query($sql_user);
	$row_user 			= $result_user->fetch_assoc();
	
	$salary_name 		= $row_user['name'];
	$salary_address 	= $row_user['address'];
	$salary_city 		= $row_user['city'];
	$salary_nik 		= $row_user['NIK'];
?>
	<div class='row'>
		<div class='col-sm-6 col-sm-offset-3' style='text-align:center'>
		<img src='../universal/images/Logo Agung.jpg' style='width:100%'>
		Periode <?= $month ?> - <?= $year ?>	
		</div>
	</div>
	<hr>
	<div class='row'>
		<div class='col-sm-2'>
			<p><b>Nama :</b></p>
			<p><b>NIK : </b></p>
			<p><b>Alamat :</b></p>
			<p><b>Kota : </b></p>
			<p><b>Jabatan :</b></p>
		</div>
		<div class='col-sm-4'>
			<p><?= $salary_name 	?></p>
			<p><?= $salary_address  ?></p>
			<p><?= $salary_city 	?></p>
			<p><?= $salary_nik 	 	?></p>
			<p>Staff</p>
		</div>
	</div>
	<br>
	<table class='table table-bordered' style='text-align:center'>
		<tr>
			<th style='width:20%;text-align:center'>Nomor</th>
			<th style='width:50%;text-align:center'>Komponen</th>
			<th style='width:30%;text-align:center'>Nominal</th>
		</tr>
		<tr>
			<td>1.</td>
			<td>Gaji pokok</th>
			<td><?= 'Rp. ' . number_format($basic_wage,2) ?></td>
		</tr>
		<tr>
			<td>2.</td>
			<td>Gaji harian</th>
			<td><?= 'Rp. ' . number_format($daily_wage * $absentee,2) ?></td>
		</tr>
		<tr>
			<td>3.</td>
			<td>Bonus</th>
			<td><?= 'Rp. ' . number_format($bonus,2) ?></td>
		</tr>
		<tr>
			<td>4.</td>
			<td>Potongan</th>
			<td><?= 'Rp. ' . number_format($deduction,2) ?></td>
		</tr>
		<tfoot>
			<tr>
				<td style='border:none;background-color:white'></td>
				<td>Total Penerimaan</td>
				<td><?= 'Rp. ' . number_format($received,2) ?>
			</tr>
			<tr>
				<td style='border:none;background-color:white'></td>
				<td>Total Potongan</td>
				<td><?= 'Rp. ' . number_format($deduction); ?>
			</tr>
			<tr>
				<td style='border:none;background-color:white'></td>
				<td>Total</td>
				<td><?= 'Rp. ' . number_format($received - $deduction,2) ?></td>
			</tr>
		</tfoot>
	</table>
	<button type='submit' class='button_success_dark' id='send_email_button'>Send email</button>
	<script>
		$('#send_email_button').click(function(){
			$.ajax({
				url:'create_salary_slip.php',
				data:{
					bonus: <?= $bonus ?>,
					deduction: <?= $deduction ?>,
					user_salary: <?= $user_id ?>,
					month: <?= $month ?>,
					year: <?= $year ?>,
					basic: <?= $basic_wage ?>,
					daily: <?= $daily_wage ?>,
				},
				type:'POST',
				beforeSend:function(){
					$('#send_email_button').attr('disabled',true);
				},
				success:function(){
					$('#button_close_salary_slip').click();
				},
			})
		});
	</script>