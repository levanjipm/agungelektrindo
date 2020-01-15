<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
?>
<head>
	<title>Manage item</title>
</head>
<style>
	input[type=text] {
		padding:10px;
		width: 130px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
	}
	input[type=text]:focus {
		width: 100%;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Item</h2>
	<p style='font-family:museo'>Manage items</p>
	<hr>
	<br>
	<input type="text" id="search_item_bar" placeholder="Search for reference or description" class="form-control">
	<br>
	<div id='edit_item_table'>
	</div>
</div>
<div class='full_screen_wrapper' id='delete_large'>
	<div class='full_screen_notif_bar'>
		<h2 style='font-size:2em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h2>
		<p style='font-family:museo'>Are you sure to delete this item?</p>
		<button type='button' class='button_danger_dark' id='check_again_button'>Check again</button>
		<button type='button' class='button_success_dark' id='delete_button'>Confirm</button>
	</div>
	<input type='hidden' id='delete_id'>
</div>

<div class='full_screen_wrapper' id='edit_item_wrapper'>
	<button class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'>
	</div>
</div>

<script>
	function disable(n){
		var window_height			= $(window).height();
		var notif_height			= $('.full_screen_notif_bar').height();
		var difference				= window_height - notif_height;
		$('#delete_large .full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('#delete_large').fadeIn();
		$('#delete_id').val(n);
	}

	$('#check_again_button').click(function(){
		$('#delete_large').fadeOut();
	});

	$('#delete_button').click(function(){
		$.ajax({
			url:'item_delete.php',
			data:{
				id :$('#delete_id').val(),
			},
			type:'POST',
			success: function(){
				location.reload();
			}
		})
	});

	function open_edit_pane(n){
		$.ajax({
			url:'item_edit_form.php',
			type:'POST',
			data:{
				item_id:n
			},
			success: function(response){
				$('#edit_item_wrapper').fadeIn();
				$('.full_screen_box').html(response);
			},
		})
	}

	$('.full_screen_close_button').click(function(){
		$('#edit_item_wrapper').fadeOut();
	});

	$(document).ready(function(){
		$.ajax({
			url: "item_edit_search.php",
			dataType: "html",
			beforeSend:function(){
				$('#search_item_bar').attr('disabled',true);
				$('#edit_item_table').html("<h2 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h2>");
			},
			success: function (data) {
				$('#search_item_bar').attr('disabled',false);
				$('#edit_item_table').html(data);
			},
		});
	});

	$('#search_item_bar').change(function () {	
		$.ajax({
			url: "item_edit_search.php",
			data: {
				term: $('#search_item_bar').val(),
			},
			type: "GET",
			dataType: "html",
			beforeSend:function(){
				$('#search_item_bar').attr('disabled',true);
				$('#edit_item_table').html("<h2 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h2>");
			},
			success: function (data) {
				$('#search_item_bar').attr('disabled',false);
				$('#edit_item_table').html(data);
			},
		});
	});
</script>