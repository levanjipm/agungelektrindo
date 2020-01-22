<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/human_resource_header.php');
?>
<head>
	<title>Create salary slip</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Salary Slip</h2>
	<p style='font-family:museo'>Create salary slip</p>
	<hr>
	<form action='salary_create_validation' method='POST'>
	<label>User</label>
	<select class='form-control' name='user'>
<?php
	$sql		= "SELECT id, name FROM users WHERE isactive = '1' ORDER BY name ASC";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
?>
		<option value='<?= $row['id'] ?>'><?= $row['name'] ?></option>
<?php
	}
?>
	</select>
	<label>Month</label>
	<select class='form-control' name='month'>
<?php
	for($i = 1; $i <= 12; $i++){
?>
		<option value='<?= $i ?>'><?= date('F',mktime(0,0,0,$i,10)) ?></option>
<?php
	}
?>
	</select>
	<label>Year</label>
	<select class='form-control' name='year'>
		<option value='<?= date('Y') ?>'><?= date('Y') ?></option>
		<option value='<?= date('Y',strtotime('-1year')) ?>'><?= date('Y',strtotime('-1year')) ?></option>
	</select>
	<br>
	<button type='submit' class='button_success_dark'><i class='fa fa-long-arrow-right'></i></button>
	</form>
</div>