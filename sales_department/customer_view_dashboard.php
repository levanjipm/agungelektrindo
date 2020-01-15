<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	$month			= date('m');
	$year			= date('Y');
?>
<head>
	<title>View customer</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p style='font-family:museo'>View customer</p>
	<hr>
	<div id='customer_view_pane'></div>
</div>
<script>
	$(document).ready(function(){
		$.ajax({
			url:'customer_view_table.php',
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
</script>