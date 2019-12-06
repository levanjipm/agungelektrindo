<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
?>
<head>
	<title>Add client</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Client</h2>
	<p style='font-family:museo'>Add client data</p>
	<hr>
	<label>Opponent name</label>
	<input type='text' class='form-control' id='name'>
	
	<br>
	<button type='button' class='button_success_dark' id='submit_client_button'>Submit</button>
</div>
<script>
	$('#submit_client_button').click(function(){
		if($('#name').val() == ''){
			alert('Please insert name!');
			$('#name').focus();
			return false;
		} else {
			$.ajax({
				url:'client_add_input.php',
				data:{
					client_name: $('#name').val()
				},
				type:'POST',
				beforeSend:function(){
					$('#submit_client_button').attr('disabled',true);
				},
				success:function(){
					location.reload();
				}
			});
		}
	});
</script>