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
?>
<head>
	<title>Edit bank data</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank data</h2>
	<p style='font-family:museo'>Edit bank data</p>
	<hr>
	
	<label>Transaction data</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>
	
	<select class='form-control' name='transaction' id='transaction'>
		<option value='0'>Insert transaction type</option>
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
	<textarea class='form-control' name='description'></textarea>
	<br>
	<button type='button' class='button_success_dark'>Submit</button>
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
</script>