<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/human_resource_header.php');
?>
<head>
	<title>Create salary slip</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Salary Slip</h2>
	<p>Create salary slip</p>
	<hr>
	<label>Term</label>
	<select class='form-control' id='term' name='term' required>
<?php
	$sql_absen 			= "SELECT DISTINCT YEAR (date) as 'YEAR', MONTH(date) as 'MONTH' FROM absentee_list";
	$result_absen 		= $conn->query($sql_absen);
	while($row_absen 	= $result_absen->fetch_assoc()){
		$dateObj   		= DateTime::createFromFormat('!m', $row_absen['MONTH']);
		$monthName 		= $dateObj->format('F');
?>
			<option value='<?= str_pad($row_absen['MONTH'],2,'0',STR_PAD_LEFT) . $row_absen['YEAR']; ?>'><?= $monthName . ' - ' . $row_absen['YEAR']; ?></option>
<?php
		}
?>	
	</select>
	<br>
	<table class='table' style='text-align:center'>
		<tr>
			<th style='text-align:center'>Name</th>
			<th></th>
		</tr>
<?php
	$sql 				= "SELECT id,name FROM users WHERE isactive = '1'";
	$result 			= $conn->query($sql);
	while($row 			= $result->fetch_assoc()){
?>
		<tr>
			<td><?= $row['name'] ?></td>
			<td>
				<button type='button' class='button_default_dark' onclick='salary_slip_open(<?= $row['id'] ?>)'>Create Salary Slip</button>
			</td>
		</tr>
<?php
	}
?>
	</table>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>X</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function salary_slip_open(n){
		$.ajax({
			url:'create_salary_slip_view.php',
			data:{
				user_id_salary:n,
				term:$('#term').val()
			},
			type:'POST',
			success:function(response){
				$('.full_screen_box').html(response);
				$('.full_screen_wrapper').fadeIn();	
			}
		});
		
	};
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
</script>