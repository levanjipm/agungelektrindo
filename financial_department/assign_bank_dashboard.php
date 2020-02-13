<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
?>
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
<head>
	<title>Assign bank data</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank</h2>
	<p>Assign transaction to journal</p>
	<hr>
	<div style='margin-left:-20px;margin-right:-10px'>
	<div class='row' style='font-family:museo;margin:0'>
		<div class='col-sm-2 active_tab tab_top' disabled id='debit_button'><p>Debit</p></div>
		<div class='col-sm-2 tab_top' id='credit_button'><p>Credit</p></div>
	</div>
	<div id='view_pane'  style='padding:15px;border:1px solid #ccc'></div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#debit_button').click();
	});
	
	
	$('#debit_button').click(function(){
		$('#credit_button').removeClass('active_tab');
		$('#debit_button').addClass('active_tab');
		$.ajax({
			url:'assign_bank_debit.php',
			beforeSend:function(){
				$('#view_pane').html("<h1 style='font-size:3em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h1>");
			},
			success:function(response){
				$('#debit_button').attr('disabled',false);
				$('#view_pane').html(response);
			}
		})
	});
	
	$('#credit_button').click(function(){
		$('#credit_button').addClass('active_tab');
		$('#debit_button').removeClass('active_tab');
		$.ajax({
			url:'assign_bank_credit.php',
			beforeSend:function(){
				$('#view_pane').html("<h1 style='font-size:3em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h1>");
			},
			success:function(response){
				$('#view_pane').html(response);
			}
		})
	});
</script>