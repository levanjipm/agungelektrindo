<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	$id					= (int)$_GET['id'];
	$sql_ongoing		= "SELECT * FROM promotion WHERE end_date > CURDATE() AND id = '$id' ORDER BY end_date ASC";
	$result_ongoing		= $conn->query($sql_ongoing);
?>
<head>
	<title>Edit promotion</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Promotion</h2>
	<p style='font-family:museo'>Manage promotion</p>
	<hr>
<?php
	if(mysqli_num_rows($result_ongoing) == 0){
		echo ("<p style='font-family:museo'>This promotion does not exist or has been expired</p>");
	} else {
		$ongoing		= $result_ongoing->fetch_assoc();
		$id				= $ongoing['id'];
		$name			= $ongoing['name'];
		$description	= $ongoing['description'];
		$end_date		= $ongoing['end_date'];
		$start_date		= $ongoing['start_date'];
?>
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
	<form action='promotion_manage_input' method='POST' id='edit_promotion_form'>
		<input type='hidden' value='<?= $id ?>' name='promo_id'>
		<label>Start date</label>
		<input type='date' class='form-control' id='promo_start_date' name='promo_start_date' value='<?= $start_date ?>'>
		
		<label>End date</label>
		<input type='date' class='form-control' id='promo_end_date' name='promo_end_date' value='<?= $end_date ?>'>
		
		<label>Promotion name</label>
		<input type='text' class='form-control' id='promotion_name' name='promotion_name' value='<?= $name ?>'>
		
		<label>Promotion description</label>
		<textarea class='form-control' id='promotion_description' name='promotion_description' style='resize:none'><?= $description ?></textarea>
		
		<br>
		<div class="fileContainer">
			<input type="file" class='input_file' id='promo_image' name='promo_image' onchange='edit_text()' accept="image/x-png,image/gif,image/jpeg" />
			<div class='file_label'>Input image file</div>
		</div>
		<br><br>
		<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
	</form>
	<script>
		$('#submit_button').click(function(){
			if($('#promotion_name').val() == ''){
				alert('Please insert a promotion name!');
				$('#promotion_name').focus();
				return false;
			} else if($('#promotion_description').val() == ''){
				alert('Please insert description');
				$('#promotion_description').focus();
				return false;
			} else if($('#promo_start_date').val() == ''){
				alert('Please insert start date!');
				$('#promo_start_date').focus();
				return false;
			} else if($('#promo_end_date').val() == ''){
				alert('Please insert end date!');
				$('#promo_end_date').focus();
				return false;
			} else if($('#promo_end_date').val() < $('#promo_start_date').val()){
				alert('End date must be greater than start date');
				$('#promo_end_date').focus();
				return false;
			} else {
				$('#edit_promotion_form').submit();
			}
		});
		
		function edit_text() {
			if(document.getElementById('promo_image').files.length == 0){
				$('.file_label').text('Input image file');
			} else {
				var fileName = $('#promo_image').val().split('\\').pop();
				$('.file_label').text(fileName);
			}
		}
	</script>
<?php
	}
?>
</div>