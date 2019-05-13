<?php
	//View by category//
	include('financialheader.php');
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-3'>
			<label>Month</label>
			<select class='form-control' id='monthly'>
				<option value='0'>Please select a month</option>
<?php
			$i = 1;
			for($i = 1; $i <= 12; $i++){
?>
				<option value='<?= $i ?>'><?= date('F',mktime(0,0,0,$i + 1,0,0)); ?></option>
<?php
			}
?>
			</select>
		</div>
		<div class='col-sm-3'>
			<label>Year</label>
			<select class='form-control' id='yearly'>
				<option value='0'>Please select a year</option>
<?php
	$sql_year = "SELECT DISTINCT(YEAR(date)) AS years FROM petty_cash";
	$result_year = $conn->query($sql_year);
	while($year = $result_year->fetch_assoc()){
?>
				<option value='<?= $year['years'] ?>'><?= $year['years'] ?></option>
<?php
	}
?>
			</select>
		</div>
		<div class='col-sm-2'>
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
			<br>
			<button type='button' class='btn btn-default' onclick='view_category()'>View</button>
		</div>
	</div>
	<div id='viewing'></div>
</div>
<script>
	function view_category(){
		if($('#monthly').val() == 0 && $('#yearly').val() == 0){
			alert('Please insert valid boundaries!');
			return false; 
		} else {
			$.ajax({
				data:{
					filter : $('#filter').val(),
					month: $('#monthly').val(),
					year: $('#yearly').val(),
					username: '<?= $user_name ?>',
				},
				method: 'POST',
				url : 'search_chart.php',
				success: function(data){
					$('#viewing').html(data);
				}
			});
		}
	}
</script>