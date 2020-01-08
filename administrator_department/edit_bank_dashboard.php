<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/administrator_header.php');
	
	$id				= $_POST['id'];
	$sql			= "SELECT * FROM code_bank WHERE id = '$id'";
	$result			= $conn->query($sql);
	$row			= $result->fetch_assoc();
	
	$date			= $row['date'];
	$transaction	= $row['transaction'];
	$value			= $row['value'];
	$label			= $row['label'];
	$opponent		= $row['bank_opponent_id'];
?>
<head>
	<title>Edit bank data</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank data</h2>
	<p style='font-family:museo'>Edit bank data</p>
	<hr>
	<form action='edit_bank_input' method='POST' id='edit_bank_form'>
		<input type='hidden' value='<?= $id ?>' name='id'>
		<label>Transaction data</label>
		<input type='date' class='form-control' name='date' value='<?= $date ?>' id='date'>
		
		<label>Transaction type</label>
		<select class='form-control' name='transaction' id='transaction'>
			<option value='1' <?php if($transaction == 1){ echo 'selected'; } ?>>Debit</option>
			<option value='2' <?php if($transaction == 2){ echo 'selected'; } ?>>Credit</option>
		</select>
		<label>Value</label>
		<div class="input-group">
			<span class="input-group-addon">Rp.</span>
			<input type="number" class="form-control" placeholder="Insert value" id='value' name='value' value='<?= $value ?>'>
		</div>
		
		<label>Transaction to/from</label><br>
		<label class='radio-inline'>
			<input type='radio' name='transaction_to' value='customer' onchange='open_select()' <?php if($label == 'CUSTOMER'){ echo 'checked';} ?>>Customer
		</label>
		<label class='radio-inline'>
			<input type='radio' name='transaction_to' value='supplier' onchange='open_select()' <?php if($label == 'SUPPLIER'){ echo 'checked';} ?>>Supplier
		</label>
		<label class='radio-inline'>
			<input type='radio' name='transaction_to' value='other' onchange='open_select()' <?php if($label == 'OTHER'){ echo 'checked';} ?>>Other
		</label>
		<label class='radio-inline'>
			<input type='radio' name='transaction_to' value='' onchange='open_null()'>Unknown
		</label><br><br>
		<div id='select_wrapper'></div>
		<label>Description</label>
		<textarea class='form-control' name='description'></textarea>
	</form>
	<br>
	<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
</div>
<script>
	$(document).ready(function(){
		$('#date').focus();
		open_select(<?= $opponent ?>);
	});
	
	function open_select(n){
		var url		= $('input[name=transaction_to]:checked').val() + '_select.php';
		$.ajax({
			url: url,
			type:'POST',
			data:{
				opponent:n
			},
			success:function(response){
				$('#select_wrapper').html(response);
			}
		});
	}
	
	$('#submit_button').click(function(){
		if($('#date').val() == ''){
			alert('Please insert date');
			$('#date').focus();
			return false;
		} else if($('#value').val() <= 0){
			alert('Please insert valid value');
			$('#value').focus();
			return false;
		} else {
			$('#edit_bank_form').submit();
		};
	});
</script>