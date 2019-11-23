<?php
	include('financialheader.php');
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-12'>
			<h2 style='font-family:bebasneue'>Bank Account</h2>
			<p>Add transaction</p>
			<hr>
			<form action='add_transaction_validation' method='POST' id='add_transaction_form'>
				<label>Date</label>
				<input type='date' class='form-control' id='date' name='date'>
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
				</label><br><br>
				<div id='select_wrapper'></div>
				<label>Description</label>
				<textarea class='form-control' form='add_transaction_form' name='description'></textarea>
				<hr>
				<button type='button' class='button_success_dark' onclick='check_all()'>
					Submit
				</button>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
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