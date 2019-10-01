<?php
	include('hrheader.php');
?>
	<style>
		.view_salary_slip_wrapper{
			background-color:rgba(30,30,30,0.7);
			position:fixed;
			z-index:100;
			top:0;
			width:100%;
			height:100%;
			display:none;
		}
		
		#view_salary_slip_box{
			position:absolute;
			width:90%;
			left:5%;
			top:10%;
			height:80%;
			background-color:white;
			overflow-y:scroll;
			padding:20px;
		}
		
		#button_close_salary_slip{
			position:absolute;
			background-color:transparent;
			top:10%;
			left:5%;
			outline:none;
			border:none;
			color:#333;
			z-index:120;
		}
	</style>
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
	<div class='view_salary_slip_wrapper'>
		<button id='button_close_salary_slip'>X</button>
		<div id='view_salary_slip_box'>
		</div>
	</div>
</body>
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
				$('.view_salary_slip_wrapper').fadeIn();
				$('#view_salary_slip_box').html(response);
			}
		});
		
	};
	
	$('#button_close_salary_slip').click(function(){
		$('.view_salary_slip_wrapper').fadeOut();
	});
</script>