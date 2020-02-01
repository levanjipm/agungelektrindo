<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	session_start();
?>
<p style='font-family:museo'>This salary slip is confidential, please do not show them to unauthorized parties</p>
<label>Period</label>
<form action='/agungelektrindo/dashboard/print_salary' method='POST' id='salary_form' target='_blank'>
	<select class='form-control' name='salary_period' id='salary_period'>
		<option value='0'>Select a period</option>
<?php
	$sql 		= "SELECT * FROM salary WHERE user_id = '" . $_SESSION['user_id'] . "' ORDER BY id ASC";
	$result		= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
?>
		<option value='<?= $row['id'] ?>'><?= date('F Y',mktime(0,0,0,$row['month'],1,$row['year'])) ?></option>
<?php
	}
?>
	</select>
</form>
<br>
<button type='button' class='button_default_dark' id='print_salary_button'>Print</button>
<script>
	$('#print_salary_button').click(function(){
		if($('#salary_period').val() == '0'){
			alert('Please insert a valid period');
			return false;
		} else {
			$('#salary_form').submit();
		}
	});
</script>