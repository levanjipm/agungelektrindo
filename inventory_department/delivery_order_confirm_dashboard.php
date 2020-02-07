<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Confrim delivery order</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Delivery Order</h2>
	<p style='font-family:museo'>Confirm delivery order</p>
	<hr>
	<div class='row' id='view_delivery_order_pane'>
	</div>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
	<div class='full_screen_box_loader_wrapper'><div class='full_screen_box_loader'></div></div>
</div>
<script>
	function refresh_view(){
		$.ajax({
			url:'delivery_order_confirm_view',
			success:function(response){
				$('#view_delivery_order_pane').html(response);
				setTimeout(function(){
					refresh_view()
				},500);
			}
		});
	};
	
	$(document).ready(function(){
		refresh_view();
	});
	
	function view_delivery_order(n){
		$.ajax({
			url:'delivery_order_confirm_form.php',
			data:{
				delivery_order_id:n
			},
			type:'POST',
			success:function(response){
				$('.full_screen_box').html(response);
				$('.full_screen_wrapper').fadeIn(300);
			}
		})
	}
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_box').html('');
		$('.full_screen_wrapper').fadeOut(300);
	});
</script>