<?php
	include('financialheader.php');
?>
<div class='main'>
<?php
	if(empty($_POST['status'])){
	} else {
		if($_POST['status'] == 'success'){
?>
	<div class="alert alert-success" style='position:absolute;z-index:100;top:20'>
		<strong>Success!</strong> Input data success!
	</div>
<?php
		} else if($_POST['status'] == 'failed'){
?>
	<div class="alert alert-danger" style='position:absolute;z-index:100;top:20'>
		<strong>Danger!</strong> Input data failed!
	</div>
<?php
		}
	}
?>
	<form action='petty_input.php' method='POST' id='pettyform'>
		<h2 style='font-family:bebasneue'>Petty Cash</h2>
		<p>Input petty cash transaction</p>
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
					<label><input type="radio" name="types" id='income' checked value='1' onchange='hide_sub()'>Income</label>
				</div>
			</div>
			<div class='col-sm-3'>
				<div class="radio">
					<label><input type="radio" name="types" id='expense' value='2' onchange='hide_sub()'>Expense</label>
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
			<div class='col-sm-6' id='classes' style='display:none'>
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
				<button type='button' class='button_default_dark' onclick='validate()'>Submit</button>
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
						<th>Balance</th>
					</tr>
<?php
					$sql_aing = "SELECT COUNT(id) AS jumlah_total FROM petty_cash";
					$result_aing = $conn->query($sql_aing);
					$aing = $result_aing->fetch_assoc();
					$offset = $aing['jumlah_total'] - 3;
					$sql_table = "SELECT * FROM petty_cash ORDER BY id ASC LIMIT 10 OFFSET " . $offset;
					$result_table = $conn->query($sql_table);
					while($table = $result_table->fetch_assoc()){
						if($table['class'] == 25){
							echo ('<tr class="success">');
						} else {
							echo ('<tr>');
						}
?>
						<td><?= date('d M Y',strtotime($table['date'])) ?></td>
						<td><?= $table['info'] ?></td>
						<td>Rp. <?= number_format($table['value'],2) ?></td>
						<td><?php
							$sql_class = "SELECT name FROM petty_cash_classification WHERE id = '" . $table['class'] . "'";
							$result_class = $conn->query($sql_class);
							$class = $result_class->fetch_assoc();
							echo $class['name'];
						?></td>
						<td>Rp. <?= number_format($table['balance'],2) ?></td>
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