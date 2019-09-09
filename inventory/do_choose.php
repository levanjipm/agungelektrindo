<?php
	include("inventoryheader.php")
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script> 
$( function() {
	$('#so_id').autocomplete({
		source: "Ajax/search_so.php"
	 })
});
</script>
<style>
	.tab_top{
		cursor:pointer;
	}
	
	.active_tab{
		border-bottom:2px solid #008080;
	}
	
	.view_sales_order_wrapper{
		background-color:rgba(30,30,30,0.7);
		position:fixed;
		z-index:100;
		top:0;
		width:100%;
		height:100%;
		display:none;
	}
	
	#view_sales_order_box{
		position:absolute;
		width:90%;
		left:5%;
		top:10%;
		height:80%;
		background-color:white;
		overflow-y:scroll;
		padding:20px;
	}
	
	#button_close_sales_order_view{
		position:absolute;
		background-color:transparent;
		top:10%;
		left:5%;
		outline:none;
		border:none;
		color:#333;
		z-index:120;
	}
</style>
	<div class="main">
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
					url: 'do_goods_view.php',
					success: function(response){
						$('#sales_order_pane').html(response);
					},
				});
			};
			function sales_order_services(){
				$.ajax({
					url: 'do_services_view.php',
					success: function(response){
						$('#sales_order_pane').html(response);
					},
				});
			};
			function sales_order_import_project(){
				$.ajax({
					url: 'do_project_view.php',
					success: function(response){
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
	<div class='view_sales_order_wrapper'>
		<button id='button_close_sales_order_view'>X</button>
		<div id='view_sales_order_box'>
		</div>
	</div>
</body>
<script>
	$('#button_close_sales_order_view').click(function(){
		$('.view_sales_order_wrapper').fadeOut();
	});
	
	function view(n){
		$('.view_sales_order_wrapper').fadeIn();
		$.ajax({
			url:'view_so.php',
			data:{
				id: n,
			},
			success:function(response){
				$('#view_sales_order_box').html(response);
			},
			type:'POST',
		})
	}
	function service_view(n){
		$.ajax({
			url:'view_service_so.php',
			data:{
				id: n,
			},
			success:function(response){
				$('#view_so').html(response);
			},
			type:'POST',
		})
	}
	function send(n){
		$('#so_form' + n).submit();
	}
	function send_project(n){
		$('#project_form-' + n).submit();
	}
	
	function send_services(n){
		$('#service_form-'+n).submit();
	}
</script>