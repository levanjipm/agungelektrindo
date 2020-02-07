<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<script> 
$( function() {
	$('#so_id').autocomplete({
		source: "Ajax/search_so.php"
	 })
});
</script>
<head>
	<title>Create delivery order</title>
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
	<h2 style='font-family:bebasneue'>Delivery Order</h2>
	<p>Choose a confirmed sales order</p>
	<hr>
	<div style='margin-left:-20px;margin-right:-10px'>
	<div class='row' style='font-family:museo;margin:0'>
		<div class='col-sm-2 active_tab tab_top' onclick='sales_order_goods()'><p>Goods</p></div>
		<div class='col-sm-2 tab_top' onclick='sales_order_import_project()'><p>Project</p></div>
		<div class='col-sm-2 tab_top' onclick='sales_order_services()'><p>Services</p></div>
	</div>
	<div id='sales_order_pane' style='padding:15px;border:1px solid #ccc'></div>
	</div>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function sales_order_goods(){
		$.ajax({
			url: 'delivery_order_goods.php',
			beforeSend:function(){
				$('.loading_wrapper_initial').show();
			},
			success: function(response){
				$('.loading_wrapper_initial').fadeOut(300);
				$('#sales_order_pane').html(response);
			},
		});
	};
	function sales_order_services(){
		$.ajax({
			url: 'delivery_order_service.php',
			beforeSend:function(){
				$('.loading_wrapper_initial').show();
			},
			success: function(response){
				$('.loading_wrapper_initial').fadeOut(300);
				$('#sales_order_pane').html(response);
			},
		});
	};
	function sales_order_import_project(){
		$.ajax({
			url: 'delivery_order_project.php',
			beforeSend:function(){
				$('.loading_wrapper_initial').show();
			},
			success: function(response){
				$('.loading_wrapper_initial').fadeOut(300);
				$('#sales_order_pane').html(response);
			},
		});
	}
	$(document).ready(function(){
		sales_order_goods()
	});
	$('.tab_top').click(function(){
		$('.tab_top').removeClass('active_tab');
		$(this).addClass('active_tab');
	});
		
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	function view(n){
		$('.full_screen_wrapper').fadeIn();
		$.ajax({
			url:'view_so.php',
			data:{
				id: n,
			},
			success:function(response){
				$('.full_screen_box').html(response);
			},
			type:'POST',
		})
	}
	
	function service_view(n){
		$('.full_screen_wrapper').fadeIn();
		$.ajax({
			url:'view_service_so.php',
			data:{
				id: n,
			},
			success:function(response){
				$('.full_screen_box').html(response);
			},
			type:'POST',
		})
	}
	
	function send_project(n){
		$('#project_form-' + n).submit();
	}
	
	function send_services(n){
		$('#service_form-'+n).submit();
	}
</script>