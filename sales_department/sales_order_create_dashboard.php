<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Create sales order</title>
</head>
<style>
	.tab_top{
		cursor:pointer;
	}
	
	.active_tab{
		border-bottom:2px solid #008080;
	}
</style>
<script>
	$('#sales_order_side').click();
	$('#sales_order_create_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Order</h2>
	<p>Create sales order</h2>
	<hr>
	<div class='row' style='font-family:bebasneue'>
		<div class='col-sm-2 active_tab tab_top' onclick='sales_order_goods()' id='sales_order_good_button'>
			<h3>Goods SO</h3>
		</div>
		<div class='col-sm-2 tab_top' onclick='sales_order_service()' id='sales_order_service_button'>
			<h3>Service SO</h3>
		</div>
	</div>
	<div id='view_pane' style='padding:10px'>
	</div>
</div>
<script>
	function sales_order_goods(){
		$('#sales_order_service_button').removeClass('active_tab');
		$('#sales_order_good_button').addClass('active_tab');
		$.ajax({
			url:'sales_order_goods_form.php',
			beforeSend:function(){
				$('.loading_wrapper_initial').show();
			},
			success:function(response){
				$('#view_pane').html(response);
				$('.loading_wrapper_initial').fadeOut(300);
			}
		});
	};
	
	function sales_order_service(){
		$('#sales_order_service_button').addClass('active_tab');
		$('#sales_order_good_button').removeClass('active_tab');
		$.ajax({
			url:'service_sales_order_form.php',
			beforeSend:function(){
				$('.loading_wrapper_initial').show();
			},
			success:function(response){
				$('#view_pane').html(response);
				$('.loading_wrapper_initial').fadeOut(300);
			}
		});
	};
	
	$(document).ready(function(){
		sales_order_goods();
	});
</script>