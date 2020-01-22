<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/human_resource_header.php');
	
	$user		= $_POST['user'];
	$month		= $_POST['month'];
	$year		= $_POST['year'];
	
	$sql_check		= "SELECT * FROM salary WHERE user_id = '$user' AND month = '$month' AND year = '$year'";
	$result_check	= $conn->query($sql_check);
	$check			= mysqli_num_rows($result_check);
	
	$sql_detail		= "SELECT name, address, city FROM users WHERE id = '$user'";
	$result_detail	= $conn->query($sql_detail);
	$detail			= $result_detail->fetch_assoc();
	
	$sql_absent		= "SELECT id FROM absentee_list WHERE user_id = '$user' AND MONTH(date) = '$month' AND YEAR(date) = '$year' AND isdelete = '0'";
	$result_absent	= $conn->query($sql_absent);
	$absent			= mysqli_num_rows($result_absent);
	
	$name			= $detail['name'];
	$address		= $detail['address'];
	$city			= $detail['city'];
?>
<head>
	<title>Create salary slip</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Salary slip</h2>
	<p style='font-family:museo'>Create salary slip</p>
	<hr>
<?php
	if($check == 0){
?>
	<form action='salary_create_input' method='POST'>
<?php
	}
?>	
	<label>User data</label>
	<p style='font-family:museo'><?= $name ?></p>
	<p style='font-family:museo'><?= $address ?></p>
	<p style='font-family:museo'><?= $city ?></p>
	
	<label>Absentee list data</label>
	<p style='font-family:museo'><?= $absent ?> days</p>
	
	<label>Daily wage</label>
	<input type='number' class='form-control' name='daily' min='0' required>
	
	<label>Bonus wage</label>
	<input type='number' class='form-control' name='bonus' min='0' required>
	
	<label>Deduction</label>
	<input type='number' class='form-control' name='deduction' min='0' required>
	
<?php
	if($check == 0){
?>
	<br>
	<button type='button' class='button_success_dark'><i class='fa fa-long-arrow-right'></i></button>
	</form>
<?php
	}
?>
</div>