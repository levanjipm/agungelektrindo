<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
?>
<head>
	<title>Inventory management</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Inventory</h2>
	<hr>
	<button type='button' class='button_default_dark' title='Add inventory data' id='add_inventory_data_button'><i class='fa fa-plus'></i></button>
	<br><br>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Description</th>
			<th>Classification</th>
			<th>Value</th>
			<th>Depreciation time</th>
			<th>Current estimated value</th>
		</tr>
<?php
	$sql			= "SELECT * FROM inventory ORDER BY purchase_date ASC";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$date		= $row['purchase_date'];
		$name		= $row['name'];
		$desc		= $row['description'];
		$class_id	= $row['classification'];
		$time		= $row['depreciation_time'];
		$value		= $row['initial_value'];
		
		$date_difference = strtotime(date('Y-m-d')) - strtotime($date);
		$year_difference = $date_difference / (60 * 60 * 24 * 365);
		if($time > 0){
			$current_value	= max(0,$value * ($time - $year_difference) / $time);
		} else {
			$current_value	= $value;
		}
		
		$sql_class		= "SELECT name FROM inventory_classification WHERE id = '$class_id'";
		$result_class	= $conn->query($sql_class);
		$class			= $result_class->fetch_assoc();
		
		$class_name		= $class['name'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td><?= $name ?></td>
			<td><?= $desc ?></td>
			<td><?= $class_name ?></td>
			<td>Rp. <?= number_format($value,2) ?></td>
			<td><?= number_format($time) ?> year(s)</td>
			<td>Rp. <?= number_format($current_value,2) ?></td>
		</tr>
<?php
	}
?>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
		<h3 style='font-family:bebasneue'>Add inventory data</h3>
		<hr>
		<label>Name</label>
		<input type='text' class='form-control' id='inventory_name'>
		<label>Description</label>
		<textarea class='form-control' style='resize:none' id='inventory_desc'></textarea>
		
		<label>Date of purchase / acquisition</label>
		<input type='date' class='form-control' id='inventory_date'>
		
		<label>Estimated depreciation time (year)</label>
		<input type='number' class='form-control' id='inventory_time'>
		
		<label>Value</label>
		<input type='number' class='form-control' id='inventory_value'>
		
		<label>Classification</label>
		<select class='form-control' id='inventory_class'>
<?php
	$sql		= "SELECT * FROM inventory_classification ORDER BY name";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
		$id		= $row['id'];
		$name	= $row['name'];
?>
			<option value='<?= $id ?>'><?= $name ?></option>
<?php
	}
?>
		</select>
		<br>
		<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
	</div>
</div>
<script>
	$('#add_inventory_data_button').click(function(){
		$('.full_screen_wrapper').fadeIn();
	});
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#submit_button').click(function(){
		if($('#inventory_name').val() == ''){
			alert('Please insert inventory name');
			$('#inventory_name').focus();
			return false;
		} else if($('#inventory_desc').val() == ''){
			alert('Please insert inventory description');
			$('#inventory_desc').focus();
			return false;
		} else if($('#inventory_date').val() == ''){
			alert('Please insert date of purchase');
			$('#inventory_date').focus();
			return false;
		} else if($('#inventory_time').val() == ''){
			alert('Please insert depreciation time');
			$('#inventory_time').focus();
			return false;
		} else {
			$.ajax({
				url:'inventory_input.php',
				data:{
					inventory_name		: $('#inventory_name').val(),
					inventory_desc		: $('#inventory_desc').val(),
					inventory_date		: $('#inventory_date').val(),
					inventory_time		: $('#inventory_time').val(),
					inventory_class		: $('#inventory_class').val(),
					inventory_value		: $('#inventory_value').val()
				},
				type:'POST',
				beforeSend:function(){
					$('button').attr('disabled',true);
				},
				success:function(){
					window.location.reload();
				}
			});
		}
	});
</script>