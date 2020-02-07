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
	}
	
	.active_tab{
		border-bottom:2px solid #008080;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Confirm return</h2>
	<hr>
	<div class='row' style='font-family:bebasneue'>
		<div class='col-sm-2 active_tab tab_top' id='sales_return_button'>
			<h3>Sales return</h3>
		</div>
		<div class='col-sm-2 tab_top' id='purchasing_return_button'>
			<h3>Purchasing return</h3>
		</div>
	</div>
	<div id='view_pane' style='padding:10px'>
	</div>
</div>
<script>
	$('#sales_return_button').click(function(){
		$('#purchasing_return_button').removeClass('active_tab');
		$('#sales_return_button').addClass('active_tab');
		$.ajax({
			url:'sales_return_view.php',
			success:function(response){
				$('#view_pane').html(response);
			}
		});
	});
	
	$('#purchasing_return_button').click(function(){
		$('#purchasing_return_button').addClass('active_tab');
		$('#sales_return_button').removeClass('active_tab');
		$.ajax({
			url:'purchasing_return_view.php',
			success:function(response){
				$('#view_pane').html(response);
			}
		});
	});
	
	$(document).ready(function(){
		$('#sales_return_button').click();
	});
</script>