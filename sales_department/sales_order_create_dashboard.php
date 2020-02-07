<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Create sales order</title>
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
<script>
	$('#sales_order_side').click();
	$('#sales_order_create_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Order</h2>
	<p>Create sales order</h2>
	<hr>
	<div style='margin-left:-20px;margin-right:-10px'>
	<div class='row' style='font-family:museo;margin:0'>
		<div class='col-sm-2 active_tab tab_top' onclick='sales_order_goods()' id='sales_order_good_button'><p>Goods SO</p></div>
		<div class='col-sm-2 tab_top' onclick='sales_order_service()' id='sales_order_service_button'><p>Service SO</p></div>
	</div>
	<div id='view_pane' style='padding:15px;border:1px solid #ccc'>
	</div>
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