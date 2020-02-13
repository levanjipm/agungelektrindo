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
	<h2 style='font-family:bebasneue'>Sample</h2>
	<hr>
	<div style='margin-left:-20px;margin-right:-10px'>
	<div class='row' style='font-family:museo;margin:0'>
		<div class='col-sm-2 active_tab tab_top' onclick='send_sample()' id='send_sample_button'><p>Send sample</p></div>
		<div class='col-sm-2 tab_top' onclick='receive_sample()' id='receive_sample_button'><p>Receive sample</p></div>
	</div>
	<div id='view_pane' style='padding:15px;border:1px solid #ccc'></div>
	</div>
</div>
<script>
	send_sample();
	
	function send_sample(){
		$('#send_sample_button').addClass('active_tab');
		$('#receive_sample_button').removeClass('active_tab');
		$.ajax({
			url:'sample_send_view.php',
			beforeSend:function(){
				$('.loading_wrapper_initial').fadeIn();
			},
			success:function(response){
				$('.loading_wrapper_initial').fadeOut();
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
				$('.loading_wrapper_initial').fadeIn();
			},
			success:function(response){
				$('.loading_wrapper_initial').fadeOut();
				$('#view_pane').html(response);
			}
		})
	};
</script>