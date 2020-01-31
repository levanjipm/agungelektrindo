<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
?>
<style>
	.btn-x{
		background-color:transparent;
		border:none;
		outline:0!important;
	}
	
	.btn-x:focus{
		outline: 0!important;
	}
	
	.box{
		width:30px;
		border:none;
		height:30px;
		margin: auto;
		width: 50%;
		right:0%;
	}
	
	.day_wrapper_calendar{
		width:13%;
		font-size:1.5em;
		font-family:bebasneue;
		text-align:center;
	}
	
	.box_wrapper{
		position:relative;
		width:13%;
		display:inline-block;
	}
	
	.box_kosong{
		width:30px;
		border:none;
		height:30px;
		margin: auto;
		width: 50%;
		right:0%;
	}
	
	.calendar_absent{
		width:100%;
		display:inline-block;
	}
	
	.calendar_action{
		width:100%;
		border:2px solid white;
		display:inline-block;
		margin-top:0;
	}
</style>
<div class='calendar_action'>
	<h2 style='font-family:bebasneue'>Absentee</h2>
	<button type='button' class='button_default_dark' id='view_calendar_button'>View</button>
	<br>
	<br>
	<div id='absentee_table'></div>
<script>
	$(document).ready(function(){
		refresh_absentee();
	});
	function refresh_absentee()
	{
		$.ajax({
			url:'/agungelektrindo/dashboard/view_absentee_table.php',
			success:function(response){
				$('#absentee_table').html(response);
				setTimeout(function(){
					refresh_absentee();
				},1000);
			}
		});
	}
	$('#view_calendar_button').click(function(){
		$('#calendar_absent_view').toggle(300);
	});
</script>
<?php
	$month 			= date('m');
	$year 			= date('Y');
	
	$sql_user 		= "SELECT COUNT(*) AS user_in_total FROM users";
	$result_user 	= $conn->query($sql_user);
	$user 			= $result_user->fetch_assoc();
	$total 			= $user['user_in_total'];
?>
	<div id="calendar_absent_view" style='display:none'>
		<h2 style='font-family:bebasneue'><?= date('F',mktime(0,0,0,$month + 1,0,$year)); ?></h2>
		<div class='calendar_absent'>
			<div class='row'>
				<div class='day_wrapper_calendar'>
					Sun
				</div>
				<div class='day_wrapper_calendar'>
					Mon
				</div>
				<div class='day_wrapper_calendar'>
					Tue
				</div>
				<div class='day_wrapper_calendar'>
					Wed
				</div>
				<div class='day_wrapper_calendar'>
					Thu
				</div>
				<div class='day_wrapper_calendar'>
					Fri
				</div>
				<div class='day_wrapper_calendar'>
					Sat
				</div>
			</div>
			<br>
		<?php
			$d = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			$w = date('w',mktime(0,0,0,$month,1,$year));
			for($i = 0; $i < $w; $i++){
		?>
			<div class='box_wrapper'>
				<div class='box_kosong'>
				</div>
			</div>
		<?php
			}	
			for($i = 1; $i <= $d; $i++){
				$date 		= date('Y-m-d',mktime(0,0,0,$month,$i,$year));
				$sql 		= "SELECT COUNT(id) AS total FROM absentee_list WHERE date = '$date' AND isdelete = '0'";
				$result 	= $conn->query($sql);
				$row 		= $result->fetch_assoc();
		?>
			<div class='box_wrapper'>
				<div class='box' style='background-color:rgba(63, 84, 95, <?= max(0.2,($row['total'] / $total)) ?>)' id='<?= $date ?>'>
				</div>
			</div>
		<?php
			$w = date('w',mktime(0,0,0,$month,$i,$year));
				if($w == 6){
					echo ('<br>');
				}
			}
			
			$sql = "SELECT * FROM absentee_list WHERE MONTH(date) = '$month' AND YEAR(date) = '$year'";
			$result = $conn->query($sql);
		?>
		</div>
	</div>
</div>