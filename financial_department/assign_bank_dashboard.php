<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
?>
<style>
	.tab_top{
		cursor:pointer;
	}
	
	.active_tab{
		border-bottom:2px solid #008080;
	}
</style>
<head>
	<title>Assign bank data</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank</h2>
	<p>Assign transaction to journal</p>
	<hr>
	<div class='row' style='font-family:bebasneue'>
		<div class='col-sm-2 active_tab tab_top' disabled id='debit_button'><h3>Debit</h3></div>
		<div class='col-sm-2 tab_top' id='credit_button'><h3>Credit</h3></div>
	</div>
	<div id='view_pane' style='padding:20px'></div>
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