<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	$month			= date('m');
	$year			= date('Y');
?>
<head>
	<title>View customer</title>
</head>
<script>
	$('#customer_side').click();
	$('#customer_manage_dashboard').find('button').addClass('activated');
</script>
<style>
	#search_bar {
		width: 130px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
		padding:10px;
	}
	
	#search_bar:focus {
		width: 100%;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p style='font-family:museo'>View customer</p>
	<hr>
	<input type='text' class='form-control' id='search_bar'>
	<br>
	<div id='customer_view_pane'></div>
</div>
<script>
	$(document).ready(function(){
		$.ajax({
			url:'customer_manage_view.php',
			data:{
			},
			type:'GET',
			beforeSend:function(){
				$('#customer_view_pane').html("<h2 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h2>");
			},
			success:function(response){
				$('#customer_view_pane').html(response);
			}
		});
	});
	
	$('#search_bar').change(function(){
		$.ajax({
			url:'customer_manage_view.php',
			data:{
				term:$('#search_bar').val()
			},
			type:'GET',
			beforeSend:function(){
				$('#c').html("<h2 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h2>");
			},
			success:function(response){
				$('#customer_view_pane').html(response);
			}
		});
	});
</script>