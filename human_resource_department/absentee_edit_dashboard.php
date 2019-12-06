<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/human_resource_header.php');
?>
<head>
	<title>Edit att. list</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Absentee List</h2>
	<p>Edit absentee data</p>
	<hr>
	<label>User</label>
	<select class='form-control' id='user'>
		<option value='0'>-- Please select user --</option>
<?php
	$sql		= "SELECT * FROM users WHERE isactive = '1' ORDER BY name ASC";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
?>
		<option value='<?= $row['id'] ?>'><?= $row['name'] ?></option>
<?php
	}
?>
	</select>
	<label>Month</label>
	<select class='form-control' id='month'>
		<option value='0'>-- Please select a month --</option>
<?php
	$month		= 1;
	for($i = 1; $i <= 12; $i++){
?>
		<option value='<?= $i ?>'><?= date('F',mktime(0,0,0,$i,1,0)) ?></option>
<?php
	}
?>
	</select>
	<label>Year</label>
	<select class='form-control' id='year'>
		<option value='0'>-- Please select a year --</option>
<?php
	$sql_year		= "SELECT DISTINCT(YEAR(date)) as year FROM absentee_list";
	$result_year	= $conn->query($sql_year);
	while($year		= $result_year->fetch_assoc()){
?>
		<option value='<?= $year['year'] ?>'><?= $year['year'] ?></option>
<?php
	}
?>
	</select>
	<br>
	<button type='button' class='button_default_dark'>Search</button>
</div>
<script>

</script>