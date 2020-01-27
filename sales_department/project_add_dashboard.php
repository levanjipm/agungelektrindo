<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
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
	}
	
	.active_tab{
		border-bottom:2px solid #008080;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Project</h2>
	<p>Add project</p>
	<hr>
	<div class='row' style='font-family:bebasneue'>
		<div class='col-sm-2 active_tab tab_top' disabled id='add_new_project_button'><h3>Add new project</h3></div	>
		<div class='col-sm-2 tab_top' id='add_existing_project_button'><h3>Add existing</h3></div>
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
	<div class='row'>
		<div class='col-sm-12' style='padding:30px' id='project_form_wrapper'>
		</div>
	</div>
</div>