<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/administrator_header.php');
?>
<head>
	<title>Delete good receipt</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Good receipt</h2>
	<p style='font-family:museo'>Delete good receipt</p>
	<hr>
	<label>Search</label>
	<input type='text' class='form-control' id='search_bar'>
	<button type='button' class='button_success_dark' id='search_button'><i class='fa fa-search'></i></button>
	<div id='view_pane'></div>
</div>
<script>
	$('#search_button').click(function(){
		$.ajax({
			url:'good_receipt_delete_view.php',
			data:{
				term:$('#search_bar').val()
			},
			type:'GET',
			beforeSend:function(){
				$('#search_bar').attr('disabled',true);
				$('#search_button').attr('disabled',true);
				$('#view_pane').html("<h1 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h1>");
			},
			success:function(response){
				$('#search_bar').attr('disabled',false);
				$('#search_button').attr('disabled',false);
				$('#view_pane').html(response);
			}
		});
	});
</script>