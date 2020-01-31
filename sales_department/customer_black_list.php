<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Black list customer</title>
</head>
<div class='full_screen_wrapper' id='black_list_notif'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class="fa fa-times" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to <strong>blacklist</strong> this customer?</p>
		<br>
		<button type='button' class='button_danger_dark close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Delete</button>
		<input type='hidden' id='customer_id'>
	</div>
</div>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p style='font-family:museo'>Black list or white list customer</p>
	<hr>
	<div id='customer_black_list_view'></div>
</div>
<script>
	$.ajax({
		url:'customer_black_list_view.php',
		success:function(response){
			$('#customer_black_list_view').html(response);
		}
	});
	function black_list_customer(n){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn();
		$('#customer_id').val(n);
	}
	
	$('#confirm_button').click(function(){
		$.ajax({
			url:'customer_black_list_input.php',
			data:{
				customer_id	: $('#customer_id').val()
			},
			type:'POST',
			beforeSend:function(){
				$('.btn-delete').attr('disabled',true);
			},
			success:function(){
				$('.btn-delete').attr('disabled',false);
				$('.btn-back').click();
				$('#blacklist_button').click();
			}
		});
	});
	$('.close_notif_button').click(function(){
		$('.close_notif_button').parent().parent().fadeOut();
	});
</script>