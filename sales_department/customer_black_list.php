<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Black list customer</title>
</head>
<style>
	#search_bar {
		width: 130px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
		padding:10px;
	}
	
	#search_bar:focus {
		width: 100%;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p style='font-family:museo'>Black list or white list customer</p>
	<hr>
	<input type='text' id='search_bar'>
	<br><br>
	<div id='customer_black_list_view'></div>
</div>

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

<div class='full_screen_wrapper' id='white_list_notif'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class="fa fa-times" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to <strong>whitelist</strong> this customer?</p>
		<br>
		<button type='button' class='button_danger_dark close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_white_list_button'>Delete</button>
		<input type='hidden' id='white_list_customer_id'>
	</div>
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
		var notif_height		= $('#black_list_notif .full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('#black_list_notif .full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('#black_list_notif').fadeIn();
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
				$('#confirm_button').attr('disabled',true);
			},
			success:function(){
				$('#confirm_button').attr('disabled',false);
				$('.close_notif_button').click();
				$('#search_bar').change();
			}
		});
	});
	
	function white_list_customer(n){
		var window_height		= $(window).height();
		var notif_height		= $('#white_list_notif .full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('#white_list_notif .full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('#white_list_notif').fadeIn();
		$('#white_list_customer_id').val(n);
	}
	
	$('#confirm_white_list_button').click(function(){
		$.ajax({
			url:'customer_white_list_input.php',
			data:{
				customer_id	: $('#white_list_customer_id').val()
			},
			type:'POST',
			beforeSend:function(){
				$('#confirm_button').attr('disabled',true);
			},
			success:function(){
				$('#confirm_button').attr('disabled',false);
				$('.close_notif_button').click();
				$('#search_bar').change();
			}
		});
	});
	
	$('.close_notif_button').click(function(){
		$('.close_notif_button').parent().parent().fadeOut();
	});
	
	$('#search_bar').change(function(){
		$.ajax({
			url:'customer_black_list_view.php',
			data:{
				term:$('#search_bar').val()
			},
			type:'GET',
			beforeSend:function(){
				$('.loading_wrapper_initial').show();
				$('#customer_black_list_view').html('');
			},
			success: function (data) {
				$('.loading_wrapper_initial').fadeOut(300);
				$('#customer_black_list_view').html(data);
			},
		});
	});
</script>