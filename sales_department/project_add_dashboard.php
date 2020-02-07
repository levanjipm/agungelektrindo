<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Create project data</title>
</head>
<script>
	$('#project_side').click();
	$('#project_add_dashboard').find('button').addClass('activated');
</script>
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
	<h2 style='font-family:bebasneue'>Project</h2>
	<p>Add project</p>
	<hr>
	<div style='margin-left:-20px;margin-right:-10px'>
	<div class='row' style='font-family:museo;margin:0'>
		<div class='col-sm-2 active_tab tab_top' disabled id='add_new_project_button'><p>Add new project</p></div>
		<div class='col-sm-2 tab_top' id='add_existing_project_button'><p>Add existing</p></div>
	</div>
	<div id='project_form_wrapper' style='padding:15px;border:1px solid #ccc'></div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#add_new_project_button').click();
	});
	
	$('#add_new_project_button').click(function(){
		$('#add_existing_project_button').removeClass('active_tab');
		$('#add_new_project_button').addClass('active_tab');
		$.ajax({
			url:'project_new_form.php',
			success:function(response){
				$('#add_new_project_button').attr('disabled',false);
				$('#project_form_wrapper').html(response);
			}
		})
	});
	
	$('#add_existing_project_button').click(function(){
		$('#add_existing_project_button').addClass('active_tab');
		$('#add_new_project_button').removeClass('active_tab');
		$.ajax({
			url:'project_exist_form.php',
			success:function(response){
				$('#project_form_wrapper').html(response);
			}
		})
	});
</script>