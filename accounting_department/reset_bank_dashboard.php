<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Reset transaction</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank</h2>
	<p style='font-family:museo'>Reset transaction</p>
	<hr>
	<label>Transaction type</label>
	<select class='form-control' id='transaction_type'>
		<option value='2'>Credit</option>
		<option value='1'>Debit</option>
	</select>
	<label>Start date</label>
	<input type='date' class='form-control' id='start_date'>
	<label>Edn date</label>
	<input type='date' class='form-control' id='end_date'>
	<br>
	<button type='button' class='button_success_dark' id='search_transaction_button'><i class='fa fa-search'></i></button>
	<br>
	<div id='view_pane'></div>
</div>
<div class='full_screen_wrapper' id='reset'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'></div>
</div>
<script>
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
	});

	$('#search_transaction_button').click(function(){
		if($('#start_date').val() == ''){
			alert('Please insert a start date');
			$('#start_date').focus();
		} else if($('#end_date').val() == ''){
			alert('Please insert an end date');
			$('#end_date').focus();
		} else {
			$.ajax({
				url:'reset_bank_view.php',
				data:{
					start_date:$('#start_date').val(),
					end_date:$('#end_date').val(),
					type:$('#transaction_type').val()
				},
				type:'POST',
				beforeSend:function(){
					$('#search_transaction_button').attr('disabled',true);
					$('#view_pane').html("<h1 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h1>");
				},
				success:function(response){
					$('#search_transaction_button').attr('disabled',false);
					$('#view_pane').html(response);
				}
			});
		}
	});
</script>