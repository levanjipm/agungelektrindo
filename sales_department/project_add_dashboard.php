<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<style>
	.tab{
		padding:5px 20px;
		background-color:transparent;
		border:none;
		outline:none !important;
	}
	
	.tab_active{
		border-bottom:2px solid #008080;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Project</h2>
	<p>Add project</p>
	<hr>
	<div class='row'>
		<div class='col-sm-12'>
			<button type='button' class='tab tab_active' disabled id='add_new_project_button'><i class="fa fa-plus-circle" aria-hidden="true"></i>Add new project</button>
			<button type='button' class='tab' id='add_existing_project_button'><i class="fa fa-plus" aria-hidden="true"></i>Add existing</button>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$('#add_new_project_button').click();
		});
		
		$('#add_new_project_button').click(function(){			
			$.ajax({
				url:'project_new_form.php',
				beforeSend:function(){
					$('.tab_active').attr('disabled',false);
					$('.tab_active').removeClass('tab_active');
					$('#add_new_project_button').addClass('tab_active');
					$('#add_new_project_button').attr('disabled',true);
				},
				success:function(response){
					$('#project_form_wrapper').html(response);
				}
			})
		});
		
		$('#add_existing_project_button').click(function(){			
			$.ajax({
				url:'project_exist_form.php',
				beforeSend:function(){
					$('.tab_active').attr('disabled',false);
					$('.tab_active').removeClass('tab_active');
					$('#add_existing_project_button').addClass('tab_active');
					$('#add_existing_project_button').attr('disabled',true);
				},
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