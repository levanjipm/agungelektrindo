<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Confirm Return</title>
</head>
<style>
	.tab_top{
		cursor:pointer;
		bottom:-1px;
		background-color:#326d96;
		color:white;
		padding:5px;
		border:none;
		transition:0.3s all ease;
		text-align:center;
		width:150px;
	}
	
	.tab_top p{
		position: relative;
		top: 50%;
		transform: translateY(-50%);
	}
	
	.active_tab{
		border-bottom:1px solid #fff;
		border-top:1px solid #ccc;
		border-left:1px solid #ccc;
		border-right:1px solid #ccc;
		background-color:white;
		color:#424242;
		transition:0.3s all ease;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Confirm return</h2>
	<hr>
	<div style='margin-left:-20px;margin-right:-10px'>
	<div class='row' style='font-family:museo;margin:0'>
		<div class='col-sm-2 active_tab tab_top' id='sales_return_button'><p>Sales return</p></div>
		<div class='col-sm-2 tab_top' id='purchasing_return_button'><p>Purchasing return</p></div>
	</div>
	<div id='view_pane' style='padding:15px;border:1px solid #ccc'>
	</div>
</div>
<script>
	$('#sales_return_button').click(function(){
		$('#purchasing_return_button').removeClass('active_tab');
		$('#sales_return_button').addClass('active_tab');
		$.ajax({
			url:'sales_return_view.php',
			beforeSend:function(){
				$('.loading_wrapper_initial').show();
			},
			success:function(response){
				$('.loading_wrapper_initial').fadeOut(300);
				$('#view_pane').html(response);
			}
		});
	});
	
	$('#purchasing_return_button').click(function(){
		$('#purchasing_return_button').addClass('active_tab');
		$('#sales_return_button').removeClass('active_tab');
		$.ajax({
			url:'purchasing_return_view.php',
			beforeSend:function(){
				$('.loading_wrapper_initial').show();
			},
			success:function(response){
				$('.loading_wrapper_initial').fadeOut(300);
				$('#view_pane').html(response);
			}
		});
	});
	
	$('#sales_return_button').click();
</script>