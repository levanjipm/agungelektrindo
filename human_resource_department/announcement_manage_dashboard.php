<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/human_resource_header.php');
?>
<head>
	<title>Manage announcement</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Announcement</h2>
	<p style='font-family:museo'>Manage announcements</p>
	<hr>
	
	<button type='button' class='button_default_dark' id='create_announcement_button'>Add announcement</button>
	<br><br>
	
	<input type="text" id='search_bar'><br><br>
	
	<div id='view_pane'></div>
</div>
<div class='full_screen_wrapper' id='create_announcement_wrapper'>
	<button type='button' class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'>
		<h2 style='font-family:bebasneue'>Create new announcement</h2>
		<hr>
		<form action='announcement_create' method='POST'>
			<label>Date</label>
			<input type='date' class='form-control' name='date' required>
			
			<label>Name</label>
			<input type='text' class='form-control' name='name' required>
			
			<label>Description</label>
			<textarea class='form-control' style='resize:none' name='description' required></textarea>
			<br>
			<button type='submit' class='button_success_dark'>Submit</button>
		</form>
	</div>
</div>

<div class='full_screen_wrapper' id='edit_announcement_wrapper'>
	<button type='button' class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'></div>
</div>
<script>
	search_announcement();
	
	function search_announcement(){
		$.ajax({
			url:'announcement_manage',
			data:{
				term:$('#search_bar').val(),
				page:$('#page').val()
			},
			type:'GET',
			beforeSend:function(){
				$('.loading_wrapper_initial').fadeIn();
				$('#search_bar').attr('disabled',true);
			},
			success:function(response){
				$('#view_pane').html(response);
				$('.loading_wrapper_initial').fadeOut();
				$('#search_bar').attr('disabled',false);
			}
		});
	}
	
	$('#search_bar').change(function(){
		search_announcement();
	});
	
	$('#page').change(function(){
		search_announcement();
	});
	
	$('#create_announcement_button').click(function(){
		$('#create_announcement_wrapper').fadeIn();
	});
	
	$('.full_screen_close_button').click(function(){
		$(this).parent().fadeOut();
	});
</script>