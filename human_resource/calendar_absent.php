<?php
	include('../codes/connect.php');
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
		cursor:pointer;
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
		padding:20px;
		display:inline-block;
		margin-top:0;
	}
</style>
<div class='calendar_action'>
	<h2 style='font-family:bebasneue'>Absentee</h2>
	<button type='button' class='button_default_dark' id='view_calendar_button'>View</button>
	<br>
	<br>
	<table class='table table-bordered' id='table_to_absent'>
		<tr>
			<th>Name</th>
			<th colspan='2'></th>
		</tr>
		<tbody id='table_body_absent'>
<?php
	$sql_user_absen = "SELECT id,name FROM users WHERE isactive = '1'";
	$result_user_absen = $conn->query($sql_user_absen);
	while($user_absen = $result_user_absen->fetch_assoc()){
		$sql_absen = "SELECT * FROM absentee_list WHERE date = '" . date('Y-m-d') . "' AND user_id = '" . $user_absen['id'] . "'";
		$result_absen = $conn->query($sql_absen);
		if(mysqli_num_rows($result_absen) == 0){
?>
			<tr>
				<td><?= $user_absen['name'] ?></td>
				<td><button type='button' class='btn btn-default' onclick='absent(<?= $user_absen['id'] ?>)'><i class="fa fa-check" aria-hidden="true"></i></button></td>
				<td><button type='button' class='btn btn-danger' onclick='confirm_delete(<?= $user_absen['id'] ?>)'>X</button></td>
			</tr>
<?php
		}
	}
?>
		</tbody>
	</table>
<script>
	$('#view_calendar_button').click(function(){
		$('#calendar_absent_view').toggle(300);
	});
</script>
<?php
	$month = date('m');
	$year = date('Y');
	
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
				$date = date('Y-m-d',mktime(0,0,0,$month,$i,$year));
				$sql = "SELECT COUNT(id) AS total FROM absentee_list WHERE date = '$date' AND isdelete = '0'";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
		?>
			<div class='box_wrapper'>
				<div class='box' style='background-color:rgba(46, 92, 184, <?= max(0.2,($row['total'] / $total)) ?>)' id='<?= $date ?>'>
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
		<style>
			.btn-absent{
				background-color:transparent;
				border: 1px solid #ccc;
			}
		</style>	
		</div>
	</div>
</div>
<div class='notification_large' style='display:none' id='delete_absentee'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to delete this attendance?</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete'>Delete</button>
		<input type='hidden' value='0' id='delete_absentee_id'>
	</div>
</div>
<script>
	$(document).ready(function(){
		var Number_of_row = $('#table_body_absent tr').length;
		if(Number_of_row == 0){
			$('#table_to_absent').hide();
		};
	});
	function absent(n){
		$.ajax({
			url:'absenin.php',
			data:{
				user_id: n,
				date: "<?= date('Y-m-d') ?>",
				tipe: "1",
			},
			type:'POST',
			success:function(response){
				$('#table_body_absent').html(response);
			},
		});
		var Number_of_row = $('#table_body_absent tr').length;
		if(Number_of_row == 0){
			$('#table_to_absent').hide();
		};
	};
	$('.btn-back').click(function(){
		$('#delete_absentee').fadeOut();
	});
	function confirm_delete(n){
		$('#delete_absentee').fadeIn();
		$('#delete_absentee_id').val(n);
	}
	$('.btn-delete').click(function(){
		var user_id_get = $('#delete_absentee_id').val();
		if (user_id_get == 0){
			alert('Please pick a user');
			return false;
		} else {
			$.ajax({
				url:'absenin.php',
				data:{
					user_id: user_id_get,
					date: "<?= date('Y-m-d') ?>",
					tipe: "2",
				},
				type:'POST',
				success:function(response){
					$('#table_body_absent').html(response);
					$('.btn-back').click();
				},
			});
		}
		var Number_of_row = $('#table_body_absent tr').length;
		if(Number_of_row == 0){
			$('#table_to_absent').hide();
		};
	});
</script>