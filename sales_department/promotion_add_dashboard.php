<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
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
				<br>
				<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
			</form>
		</div>
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
	
	$('#submit_button').click(function(){
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
			$('#promotion_add_form').submit();
		}
	});
</script>