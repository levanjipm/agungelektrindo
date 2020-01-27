<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
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
	}
	
	.active_tab{
		border-bottom:2px solid #008080;
	}
</style>
	<div class='main'>
		<h2 style='font-family:bebasneue'>Delivery Order</h2>
		<p>Choose a confirmed sales order</p>
		<hr>
		<div class='row' style='font-family:bebasneue'>
			<div class='col-sm-2 active_tab tab_top' onclick='sales_order_goods()'>
				<h3>Goods</h3>
			</div>
			<div class='col-sm-2 tab_top' onclick='sales_order_import_project()'>
				<h3>Project</h3>
			</div>
			<div class='col-sm-2 tab_top' onclick='sales_order_services()'>
				<h3>Services</h3>
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
		</script>
		<div class='row'>
			<div class='col-sm-12' id='sales_order_pane'>
			</div>
		</div>
	</div>
	<div class='full_screen_wrapper'>
		<button class='full_screen_close_button'>X</button>
		<div class='full_screen_box'>
		</div>
	</div>
</body>
<script>
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