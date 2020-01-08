<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/administrator_header.php');
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
	<label>End date</label>
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
<div class='full_screen_wrapper' id='delete'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class='fa fa-exclamation'></i></h1>
		<p style='font-family:museo'>Are you sure to delete this transaction</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_delete_button'>Confirm</button>
		
		<input type='hidden' id='bank_delete_id'>
	</div>
</div>
<script>
	$('.full_screen_close_button').click(function(){
		$('#reset').fadeOut(300);
	});
	
	$('#close_notif_button').click(function(){
		$('#delete').fadeOut(300);
	});
	
	$('#confirm_delete_button').click(function(){
		$.ajax({
			url:'bank_delete.php',
			data:{
				bank_id: $('#bank_delete_id').val()
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled',true);
			},
			success:function(){
				$('button').attr('disabled',false);
				$('#close_notif_button').click();
				$('#search_transaction_button').click();
			}
		})
	});

	$('#search_transaction_button').click(function(){
		if($('#start_date').val() == ''){
			alert('Please insert a start date');
			$('#start_date').focus();
		} else if($('#end_date').val() == ''){
			alert('Please insert an end date');
			$('#end_date').focus();
		} else if($('#end_date').val() < $('#start_date').val()){
			alert('End date value must be greater than start date');
			$('#end_date').focus();
			return false;
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