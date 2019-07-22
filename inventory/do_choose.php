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
.box_do{
	padding:100px 30px;
	box-shadow: 3px 3px 3px 3px #888888;
}
.icon_wrapper{
	position:relative;
}
.view_wrapper{
	position:fixed;
	top:30px;
	right:0px;
	margin-left:0;
	width:30%;
	background-color:#eee;
	padding:20px;
}
.active_tab{
	border-bottom:2px solid #5cb85c;
}
.tab_top{
	cursor:pointer;
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
			<div class='col-sm-7' id='sales_order_pane'>
			</div>
		</div>
		<div class='view_wrapper'>
			<div id='view_so'>
			</div>
		</div>
	</div>
</body>
<script>
	function view(n){
		$.ajax({
			url:'view_so.php',
			data:{
				id: n,
			},
			success:function(response){
				$('#view_so').html(response);
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