<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<style>
	.button_tab{
		background-color:transparent;
		border:none;
		outline:none!important;
		display:inline-block;
		width:30%;
	}
	
	.button_tab.activ{
		border-bottom:2px solid #008080;
	}
	
	#customer_list{
		padding:20px;
	}
</style>
<script>
	$('#customer_side').click();
	$('#customer_black_list').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p>Black list or white list customer</p>
	<hr>
	<button type='button' class='button_tab activ' id='blacklist_button'>
		<p>Blacklist customer</p>
	</button>
	<button type='button' class='button_tab' id='whitelist_button'>
		<p>Whitelist customer</p>
	</button>
	<div id='customer_list'>
	</div>
</div>
<script>
	$('.button_tab').click(function(){
		var button_id	= $(this).attr('id');
		if(button_id	== 'blacklist_button'){
			$('.activ').removeClass('activ');
			$('#' + button_id).addClass('activ');
			$.ajax({
				url:'customer_black_list_view.php',
				beforeSend:function(){
					$('.loading_wrapper_initial').show();
				},
				success:function(response){
					$('.loading_wrapper_initial').fadeOut(300);
					$('#customer_list').html(response);
				}
			});
		} else if(button_id	== 'whitelist_button'){
			$('.activ').removeClass('activ');
			$('#' + button_id).addClass('activ');
			$.ajax({
				url:'customer_white_list_view.php',
				beforeSend:function(){
					$('.loading_wrapper_initial').show();
				},
				success:function(response){
					$('.loading_wrapper_initial').fadeOut(300);
					$('#customer_list').html(response);
				}
			});
		}
	});
	
	$(document).ready(function(){
		$('#blacklist_button').click();
	});
</script>