<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Found goods</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Add event</h2>
	<p><strong>Found</strong> Goods</p>
	<hr>
	<form action='event_found_create_input' method='POST' id='found_goods_form'>
		<label>Date</label>
		<input type='date' class='form-control' name='date' id='date'>
		
		<label>Reference</label>
		<input type='text' class='form-control' id='reference' name='reference'>
		
		<label>Quantity</label>
		<input type='number' class='form-control' id='quantity' name='quantity'>
		
		<br>
		<button type='button' class='button_warning_dark' id='back_found_goods_button'>Back</button>
		<button type='button' class='button_default_dark' id='submit_found_goods_confirmation_button'>Submit</button>
	</form>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to submit this event?</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Back</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#back_found_goods_button').click(function(){
		window.history.back();
	});
	var available = 1;
	$('#submit_found_goods_confirmation_button').click(function(){
		$.ajax({
			url:'../codes/check_item_availability.php',
			data:{
				reference : $('#reference').val()
			},
			type:'POST',
			success:function(response){
				if(response == 0){
					alert('Reference not found!');
					return false;
				} else {
					if($('#date').val() == ''){
						alert('Please insert correct date');
						return false;
					} else if($('#reference').val() == ''){
						alert('Please insert reference');
						return false;
					} else if($('#quantity').val() == '' || $('#quantity').val() <= 0){
						alert('Please insert correct quantity');
						return false;
					} else {
						var window_height	= $(window).height();
						var notif_height	= $('.full_screen_notif_bar').height();
						var difference		= window_height - notif_height;
						$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
						$('.full_screen_wrapper').fadeIn();
					}
				}
			},
		});
	})
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
	});
	
	$('#confirm_button').click(function(){
		$('#found_goods_form').submit();
	});
</script>