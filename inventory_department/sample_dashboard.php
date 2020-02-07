<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Sample</title>
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
	<h2 style='font-family:bebasneue'>Sample</h2>
	<hr>
	<div class='row' style='font-family:bebasneue'>
		<div class='col-sm-2 active_tab tab_top' onclick='send_sample()' id='send_sample_button'>
			<h3>Send sample</h3>
		</div>
		<div class='col-sm-2 tab_top' onclick='receive_sample()' id='receive_sample_button'>
			<h3>Receive sample</h3>
		</div>
	</div>
	<div id='view_pane' style='padding:20px'></div>
</div>
<script>
	function send_sample(){
		$('#send_sample_button').addClass('active_tab');
		$('#receive_sample_button').removeClass('active_tab');
		$.ajax({
			url:'sample_send_view.php',
			beforeSend:function(){
				$('#view_pane').html("<h1 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h1>");
			},
			success:function(response){
				$('#view_pane').html(response);
			}
		})
	};
	
	function receive_sample(){
		$('#receive_sample_button').addClass('active_tab');
		$('#send_sample_button').removeClass('active_tab');
		$.ajax({
			url:'sample_receive_view.php',
			beforeSend:function(){
				$('#view_pane').html("<h1 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h1>");
			},
			success:function(response){
				$('#view_pane').html(response);
			}
		})
	};
	
	$(document).ready(function(){
		send_sample();
	});
</script>