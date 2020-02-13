<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Add Promotion</title>
</head>
<script>
	$('#promotion_side').click();
	$('#promotion_add_dashboard').find('button').addClass('activated');
</script>
<style>
.fileContainer{
	display:block;
	border:none;
	height:15px;
	position:relative;
}
.input_file{
	border:none;
	outline:none;
	opacity:0;
	position:absolute;
	top:0;
	left:0;
	z-index:20;
	cursor:pointer;
}

.file_label{
	position:absolute;
	top:0;
	left:0;
	border:none;
	background-color:#2B3940;
	color:white;
	padding:5px 25px;
	z-index:15;
}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Promotion</h2>
	<p>Add promotion</p>
	<hr>
	<div class='row'>
		<div class='col-sm-12'>
			<form id='promotion_add_form' action='promotion_add_input' method='POST' enctype= "multipart/form-data">
				<label>Start date</label>
				<input type='date' class='form-control' id='start_date'	name='start_date'>
				<label>End date</label>
				<input type='date' class='form-control' id='end_date'	name='end_date'>
				<label>Promo name</label>
				<input type='text' class='form-control' id='promo_name'	name='promo_name'>
				<label>Promo description</label>
				<textarea class='form-control' style='resize:none' id='promo_desc' name='promo_desc'></textarea>
				<label>Image</label>
				<div class="fileContainer">
					<input type="file" class='input_file' id='promo_image' name='promo_image' onchange='edit_text()' accept="image/x-png,image/gif,image/jpeg" />
					<div class='file_label'>Input image file</div>
				</div>
				<br><br>
				<button type='button' class='button_success_dark' id='validate_button'><i class='fa fa-long-arrow-right'></i></button>
			</form>
		</div>
	</div>
</div>

<div class='full_screen_wrapper' id='promotion_validation'>
	<button type='button' class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'>
		<label>Date</label>
		<p style='font-family:museo'><span id='start_date_p'></span> - <span id='end_date_p'></span></p>
		
		<label>Promotion name</label>
		<p style='font-family:museo' id='promo_name_p'></p>
		
		<label>Promo description</label>
		<p style='font-family:museo' id='promo_description_p'></p>
		
		<button type='button' class='button_default_dark' id='submit_button'><i class='fa fa-long-arrow-right'></i></button>
	</div>
</div>
<script>
	function edit_text() {
		if(document.getElementById('promo_image').files.length == 0){
			$('.file_label').text('Input image file');
		} else {
			var fileName = $('#promo_image').val().split('\\').pop();
			$('.file_label').text(fileName);
		}
	}
	
	$('#validate_button').click(function(){
		if($('#start_date').val() == ''){
			alert('Please insert start date');
			$('#start_date').focus();
			return false;
		} else if($('#end_date').val() == ''){
			alert('Please insert end date');
			$('#end_date').focus();
			return false;
		} else if($('#promo_name').val() == ''){
			alert('Please insert promotion name');
			$('#promo_name').focus();
			return false;
		} else if($('#promo_desc').val() == ''){
			alert('Please insert promotion description');
			$('#promo_desc').focus();
			return false;
		} else {
			transform_view();
		}
	});
	
	function transform_view(){
		$('#start_date_p').html($('#start_date').val());
		$('#end_date_p').html($('#end_date').val());
		
		$('#promo_name_p').html($('#promo_name').val());
		$('#promo_description_p').html($('#promo_desc').val());
		
		$('#promotion_validation').fadeIn();
	};
	
	$('#submit_button').click(function(){
		$('#promotion_add_form').submit();
	});
</script>