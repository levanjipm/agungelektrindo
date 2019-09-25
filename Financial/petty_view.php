<?php
	include('financialheader.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Petty Cash</h2>
	<p>View cash transaction</p>
	<hr>
	<div class='row'>
		<div class='col-sm-3'>
			<label>Month</label>
			<select class='form-control' name='month' id='month'>
				<option value='0'>Please pick a month to view</option>
<?php
	$i = 1;
	for($i = 1; $i <= 12; $i++){
		if($i == date('m')){
?>
				<option value='<?= $i ?>' selected="selected" ><?= date('F', mktime( 0,0,0,$i,10 )) ?></option>
<?php
		} else {
?>
				<option value='<?= $i ?>'><?= date('F', mktime( 0,0,0,$i,10 )) ?></option>
<?php
		}
	}
?>
			</select>
		</div>
		<div class='col-sm-3'>
			<label>Year</label>
			<select class='form-control' name='year' id='year'>
				<option value='0'>Please pick a year to view</option>
<?php
	$sql = "SELECT DISTINCT(YEAR(date)) AS year FROM petty_cash";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		if($row['year'] == date('Y')){
?>
				<option value='<?= $row['year'] ?>' selected = 'selected'><?= $row['year'] ?></option>
<?php
		} else {
?>
				<option value='<?= $row['year'] ?>' selected = 'selected'><?= $row['year'] ?></option>
<?php
		}
	}
?>
			</select>
		</div>
		<div class='col-sm-1'>
			<label style='color:white'>Submit</label><br>
			<button type='button' class='button_default_dark' onclick='view_petty()'>Submit</button>					
		</div>
		<div class='col-sm-3'>
			<label>Filter table</label><br>
			<select class='form-control' name='filter' id='filter'>
				<option value='0'>Filter Table</option>
<?php
		$sql = "SELECT * FROM petty_cash_classification WHERE major_id = '0'";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
?>	
				<option value='<?= $row['id'] ?>' style='font-weight:bold'><?= $row['name'] ?></option>				
<?php
			$sql_detail = "SELECT * FROM petty_cash_classification WHERE major_id = '" . $row['id'] . "'";
			$result_detail = $conn->query($sql_detail);
			if($result_detail){
				while($detail = $result_detail->fetch_assoc()){
?>
				<option value='<?= $detail['id'] ?>'><?= $detail['name'] ?></option>	
<?php
				}
			}
		}
?>
					</select>
				</div>
				<div class='col-sm-2'>
					<label>Print</label><br>
					<button type='button' class='button_warning_dark' onclick='printer()'>
						<i class="fa fa-print" aria-hidden="true"></i>
					</button>
				</div>
			</div>
			<div id='inputs'></div>
		</div>
	</div>
</div>
<script>
	function printer(inputs){
		if($('#inputs').html().length == 0){
			alert('Input is empty!');
			return false;
		} else {
			var printContents = document.getElementById('inputs').innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		}
	}
	
	function view_petty(){
		if($('#month').val() == 0){
			alert('Please insert valid month!');
			return false;
		} else if($('#year').val() == 0){
			alert('Please insert valid year!');
			return false;
		} else {
			$.ajax({
				data:{
					filter : $('#filter').val(),
					month: $('#month').val(),
					year: $('#year').val(),
					username: '<?= $user_name ?>',
				},
				method: 'POST',
				url : 'search_view.php',
				success: function(data){
					$('#inputs').html(data);
				}
			});
		}
	}
</script>	