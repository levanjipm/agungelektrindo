<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
?>
<head>
	<title>Input petty cash</title>
</head>
<div class='main'>
<?php
	if(empty($_POST['status'])){
	} else {
		if($_POST['status'] == 'success'){
?>
	<div class="alert alert-success" style='position:absolute;z-index:100;top:100px'>
		<strong>Success!</strong> Input data success!
	</div>
<?php
		} else if($_POST['status'] == 'failed'){
?>
	<div class="alert alert-danger" style='position:absolute;z-index:100;top:100px'>
		<strong>Danger!</strong> Input data failed!
	</div>
<?php
		}
	}
?>
	<form action='petty_input' method='POST' id='pettyform'>
		<h2 style='font-family:bebasneue'>Petty Cash</h2>
		<p style='font-family:museo'>Input petty cash transaction</p>
		<hr>
		<div class='row'>
			<div class='col-sm-3'>
				<label>Date</label>
				<input type='date' class='form-control' name='today' id='today' value='<?= date('Y-m-d') ?>'>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-3'>
				<div class="radio">
					<label><input type="radio" name="types" id='expense' checked value='2' onchange='hide_sub()'>Expense</label>
				</div>
			</div>
			<div class='col-sm-3'>
				<div class="radio">
					<label><input type="radio" name="types" id='income' value='1' onchange='hide_sub()'>Income</label>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-6'>
				<label>Value</label>
				<div class="input-group">
					<span class="input-group-addon">Rp. </span>
					<input id="value" type="number" class="form-control" name="value" placeholder="Value">
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-6' id='classes'>
				<label>Expense Classification</label>
				<select class='form-control' onchange='activate_sub()' id='class' name='class'>
					<option value='0'>Please select a classification</option>
<?php
	$sql_petty = "SELECT * FROM petty_cash_classification WHERE major_id = '0' AND id <> '25'";
	$result_petty = $conn->query($sql_petty);
	while($petty = $result_petty->fetch_assoc()){
?>
					<option value='<?= $petty['id'] ?>'><?= $petty['name'] ?></option>
<?php
	}
?>
				</select>
				<label>Information</label>
				<input type='text' class='form-control' name='info' id='info'>
			</div>
			<div class='col-sm-6' id='subclass'>
			</div>
			<div class='col-sm-12' style='padding-top:10px'>
				<button type='button' class='button_success_dark' onclick='validate()'>Submit</button>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-12'>
				<h3 style='font-family:bebasneue'>Recent transactions</h3>
				<table class='table table-bordered'>
					<tr>
						<th>Date</th>
						<th>Info</th>
						<th>Value</th>
						<th>Class</th>
					</tr>
<?php
					$sql_table 					= "SELECT petty_cash.value, petty_cash.date, petty_cash_classification.name, petty_cash.class, petty_cash.info
													FROM petty_cash
													JOIN petty_cash_classification ON petty_cash.class = petty_cash_classification.id
													ORDER BY petty_cash.date DESC, petty_cash.id ASC LIMIT 3";
					$result_table 				= $conn->query($sql_table);
					while($table 				= $result_table->fetch_assoc()){
						$petty_value			= $table['value'];
						$petty_date				= $table['date'];
						$class_name				= $table['name'];
						$petty_class			= $table['class'];
						$petty_info				= $table['info'];
						
						if($petty_class 		== 25){
							echo ('<tr class="success">');
						} else {
							echo ('<tr>');
						}
?>
						<td><?= date('d M Y',strtotime($petty_date)) ?></td>
						<td><?= $petty_info ?></td>
						<td>Rp. <?= number_format($petty_value,2) ?></td>
						<td><?= $class_name ?></td>
					</tr>
<?php
					}
?>
				</table>
			</div>
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#today').focus();
		setTimeout(function(){
			$('.alert').fadeOut()
		},1000);
	});
	
	function hide_sub(){
		if($('#income').prop('checked')){
			$('#classes').hide();
		} else {
			$('#classes').show();
		}
	}
	
	function activate_sub(){
		$.ajax({
			data:{
				term: $('#class').val()
			},
			method: 'POST',
			url : 'search_class.php',
			success: function(data){
				$('#subclass').html(data);
			}
		});
	}
	function validate(){
		if($('#today').val() == ''){
			alert('Please insert date!');
			$('#today').focus();
			return false;
		} else if($('#value').val() == '' || $('#value').val() == 0){
			alert('Please insert correct value!');
			$('#value').focus();
			return false;
		} else if($('#expense').prop('checked') && $('#class').val() == 0){
			alert('Insert correct classification!');
			$('#class').focus();
			return false;
		} else if($('#expense').prop('checked') && $('#info').val() == ''){
			alert('Insert general information!');
			$('#info').focus();
			return false;
		} else if($('#sub').length != 0 && $('#sub').val() == 0){
			alert('Insert correct subclass!');
			$('#sub').focus();
			return false;
		} else {
			$('#pettyform').submit();
		}
	}
</script>