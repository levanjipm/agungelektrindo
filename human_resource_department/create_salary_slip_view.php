<?php
	include('../codes/connect.php');
	$user_id_salary		= $_POST['user_id_salary'];
	$term				= $_POST['term'];
	$month				= (int)substr($term,0,2);
	$year				= (int)substr($term,2,6);
	$sql_absent			= "SELECT * FROM absentee_list WHERE user_id = '$user_id_salary' AND MONTH(date) = '$month' AND YEAR(date) = '$year' AND isdelete = '0'";
	$result_absent		= $conn->query($sql_absent);
	
	$absentee			= mysqli_num_rows($result_absent);
	
	$sql_user_salary	= "SELECT name, address FROM users WHERE id = '$user_id_salary'";
	$result_user_salary	= $conn->query($sql_user_salary);
	$user_salary		= $result_user_salary->fetch_assoc();
	
	$user_name_salary	= $user_salary['name'];
	$user_address_salary	= $user_salary['address'];
	
	$sql_history			= "SELECT * FROM salary WHERE user_id = '$user_id_salary' ORDER BY id DESC";
	$result_history			= $conn->query($sql_history);
	$history				= $result_history->fetch_assoc();
	
	$daily					= $history['daily'];
	$basic					= $history['basic'];
	$bonus					= $history['bonus'];
	$deduction				= $history['deduction'];
?>
<h2 style='font-family:bebasneue'>Salary Slip</h2>
<p>Create salary slip</p>
<hr>
<h3 style='font-family:bebasneue'><?= $user_name_salary ?></h3>
<p><?= $user_address_salary ?></p>
<input type='hidden' value='<?= $user_id_salary ?>' id='user_id'>
<input type='hidden' value='<?= $month ?>' 			id='month'>
<input type='hidden' value='<?= $year ?>'			id='year'>
<label>Attendance</label>
<p><?= $absentee ?> days</p>
<label>Daily wage</label>
<input type='number' class='form-control' id='daily' value='<?= $daily ?>'>
<label>Basic wage</label>
<input type='number' class='form-control' id='basic' value='<?= $basic ?>'>
<label>Bonus</label>
<input type='number' class='form-control' id='bonus' value='<?= $bonus ?>'>
<label>Deduction</label>
<input type='number' class='form-control' id='deduction'>
<br>
<button type='button' class='button_success_dark' id='submit_salary_button'>Submit</button>
<script>
	$('#submit_salary_button').click(function(){
		$.ajax({
			url:'create_salary_slip_validation.php',
			data:{
				bonus: $('#bonus').val(),
				deduction: $('#deduction').val(),
				user_salary: <?= $user_id_salary ?>,
				month: $('#month').val(),
				year: $('#year').val(),
				basic: $('#basic').val(),
				daily: $('#daily').val()
			},
			type:'POST',
			beforeSend:function(){
				$('.full_screen_box').fadeOut();
			},
			success:function(response){
				$('.full_screen_box').html(response);
				$('.full_screen_box').fadeIn();
			},
		})
	});
</script>