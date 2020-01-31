<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Check stock</title>
</head>
<style>
	input[type=text] {
		width: 130px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
		padding:10px;
	}
	
	input[type=text]:focus {
		width: 100%;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Check Stock</h2>
	<hr>
	<input type="text" id="search_item_bar" placeholder="Search..">
	<br><br>
	
	<div id='check_stock_table'>
	</div>
</div>
<script>
$.ajax({
	url:'check_stock_view.php',
	beforeSend:function(){
		$('.loading_wrapper_initial').fadeIn();
		$('#search_item_bar').attr('disabled',true);
		$('#check_stock_table').html('');
	},
	success: function (response) {
		$('.loading_wrapper_initial').fadeOut();
		$('#search_item_bar').attr('disabled',false);
		$('#check_stock_table').html(response);
	},
});

$('#search_item_bar').change(function () {
    $.ajax({
        url: "check_stock_view.php",
        data: {
            term: $('#search_item_bar').val()
        },
        type: "GET",
		beforeSend:function(){
			$('.loading_wrapper_initial').fadeIn();
			$('#search_item_bar').attr('disabled',true);
			$('#check_stock_table').html('');
		},
        success: function (response) {
			$('.loading_wrapper_initial').fadeOut();
			$('#search_item_bar').attr('disabled',false);
            $('#check_stock_table').html(response);
        },
    });
});
</script>