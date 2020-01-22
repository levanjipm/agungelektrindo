<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
	
	$sql		= "SELECT date, value, transaction FROM code_bank WHERE major_id = '0' ORDER BY date DESC, id DESC";
	$result		= $conn->query($sql);
	$row		= $result->fetch_assoc();
	
	$date		= $row['date'];
	$value		= $row['value'];
	$transaction	= $row['transaction'];
	
	if($transaction == 1){
		$text	= "DB";
	} else {
		$text	= "CR";
	}
	
	$textarea	= date('d M Y',strtotime($date)) . ' | ' . number_format($value,2) . ' ' . $text;
?>
<head>
	<title>Add bank transaction</title>
</head>
<div class='main'>
	<div class='row'>
		<div class='col-sm-12'>
			<h2 style='font-family:bebasneue'>Bank Account</h2>
			<p>Add transaction</p>
			<hr>
			<form action='transaction_add_validation' method='POST' id='add_transaction_form'>
				<label>Date</label>
				<input type='date' class='form-control' id='date' name='date' value='<?= date('Y-m-d') ?>'>
				<label>Transaction type</label>
				<select class='form-control' name='transaction' id='transaction'>
					<option value='0'>Insert transaction type</option>
					<option value='1'>Debit</option>
					<option value='2'>Credit</option>
				</select>
				<label>Value</label>
				<div class="input-group">
					<span class="input-group-addon">Rp.</span>
					<input type="number" class="form-control" placeholder="Insert value" id='value' name='value'>
				</div>
				<label>Transaction to/from</label><br>
				<label class='radio-inline'>
					<input type='radio' name='transaction_to' value='customer' checked onchange='open_select()'>Customer
				</label>
				<label class='radio-inline'>
					<input type='radio' name='transaction_to' value='supplier' onchange='open_select()'>Supplier
				</label>
				<label class='radio-inline'>
					<input type='radio' name='transaction_to' value='other' onchange='open_select()'>Other
				</label>
				<label class='radio-inline'>
					<input type='radio' name='transaction_to' value='' onchange='open_null()'>Unknown
				</label><br><br>
				<div id='select_wrapper'></div>
				<label>Description</label>
				<textarea class='form-control' name='description' style='resize:none'></textarea>
				<br>
				<label>Last transaction</label>
				<p style='font-family:museo'><?= $textarea ?></p>
				<button type='button' class='button_success_dark' onclick='check_all()'>
					Submit
				</button>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#date').focus();
		open_select();
	});
	
	function open_select(){
		var url		= $('input[name=transaction_to]:checked').val() + '_select.php';
		$.ajax({
			url: url,
			type:'POST',
			success:function(response){
				$('#select_wrapper').html(response);
			}
		});
	}
	
	function open_null(){
		$('#select_wrapper').html('');
	}
	
	function check_all(){
		if($('#date').val() == ''){
			alert('Insert valid date!');
		} else if($('#transaction').val() == 0){
			alert('Please pick transaction type!');
		} else if($('#value').val() == '' || $('#value').val() == 0){
			alert('Please insert value number!');
		} else if($('#transaction_select_to').val() == ''){
			alert('Please pick a client!');
		} else {
			$('#add_transaction_form').submit();
		}
	}
</script>