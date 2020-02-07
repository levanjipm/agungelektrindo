<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
	if(empty($_POST['id'])){
?>
<script>
	window.location.href='/agungelektrindo/accounting';
</script>
<?php
	}
	
	$bank_id			= $_POST['id'];
	$sql				= "SELECT * FROM code_bank WHERE id = '$bank_id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	$value				= $row['value'];
	$date				= $row['date'];
	$transaction		= $row['transaction'];
	
	if($transaction		== 1){
		$text			= 'DB';
	} else {
		$text			= 'CR';
	}
	
	$description		= $row['description'];
?>
<head>
	<title>Assign bank data</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank</h2>
	<p style='font-family:museo'>Assign empty bank data</p>
	<hr>
	<label>Date</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>
	<label>Value</label>
	<p style='font-family:museo'>Rp. <?= number_format($value,2) ?> <?= $text ?></p>
	<form action='bank_assign_input' method='POST' id='add_transaction_form'>
		<input type='hidden' value='<?= $bank_id ?>' name='id'>
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
		<textarea class='form-control' style='resize:none' name='description'><?= $description ?></textarea>
		<br>
		<button type='button' class='button_success_dark' onclick='check_all()'><i class='fa fa-long-arrow-right'></i></button>
	</form>
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
	
	function check_all(){
		if($('#transaction_select_to').val() == ''){
			alert('Please pick a client!');
		} else {
			$('#add_transaction_form').submit();
		}
	}
</script>