<?php
	include('hrheader.php');
?>
	<div class='main'>
	<h2>Salary Slip</h2>
	<p>Create salary slip</p>
	<hr>
		<form method="POST" action='create_salary_slip_validation.php'>
			<label>User id</label>
			<select class='form-control' id='users' name='userid'>
				<option value=''>Pick a user</option>
<?php
				$sql = "SELECT id,name FROM users";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()){
?>
				<option value='<?= $row['id']; ?>'><?= $row['name']; ?></option>
<?php
				}
?>
			</select>
			<div id='absentee'>
			<label>Term</label>
			<select class='form-control' id='absence' onchange='panggil()' name='absence'>
				<option value=''>Pick the term</option>
<?php
				$sql_absen = "SELECT DISTINCT YEAR (date) as 'YEAR', MONTH(date) as 'MONTH' FROM absentee_list";
				$result_absen = $conn->query($sql_absen);
				while($row_absen = $result_absen->fetch_assoc()){
					$dateObj   = DateTime::createFromFormat('!m', $row_absen['MONTH']);
					$monthName = $dateObj->format('F');
?>
				<option value='<?= str_pad($row_absen['MONTH'],2,'0',STR_PAD_LEFT) . $row_absen['YEAR']; ?>'><?= $monthName . ' - ' . $row_absen['YEAR']; ?></option>
<?php
				}
?>
			</select>
			</div>
			<label>Jumlah hari kerja</label>
			<input type='text' class='form-control' readonly id='working' name='working'>
			<label>Gaji per hari</label>
			<input type='number' class='form-control' name='daily'>
			<label>Gaji Dasar</label>
			<input type='number' class='form-control' name='basic'>
			<label>Bonus</label>
			<input type='number' class='form-control' name='bonus'>
			<label>Potongan</label>
			<input type='number' class='form-control' name='potongan'>
			<br>
			<button type='submit' class='btn btn-primary'>Next</button>
		</form>
	</div>
				
<script>
	function panggil(){
		$.ajax({
			url: "counter.php",
			type: "post",
			data: {
				'user': $('#users').val(),
				'term': $('#absence').val()
			},
			success: function(data) {
				$('#working').val(data);
			}
		});
	}
</script>
		