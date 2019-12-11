<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Stock value journal</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Accounting Journal</h2>
	<p>Stock value</p>
	<hr>
	<div class='row'>
		<div class='col-sm-3'>
			<label>Start date</label>
			<input type='date' class='form-control' id='start_date'>
		</div>
		<div class='col-sm-3'>
			<label>End date</label>
			<input type='date' class='form-control' id='end_date'>
		</div>
		<div class='col-sm-3'>
			<label style='color:white'>a</label><br>
			<button type='button' class='button_default_dark' onclick='check_date()' id='show_button'>Show</button>
		</div>
	</div>
	<hr>
	<div id='input_list'>
	</div>
</div>
<script>
	function check_date(){
		if($('#start_date').val() == ''){
			alert('Insert start date!');
			return false;
		} else if($('#end_date').val() == ''){
			alert("insert end date!");
			return false;
		} else if($('#start_date').val() > $('#end_date').val()){
			alert('Cannot insert minus value!');
			return false;
		} else {
			$.ajax({
				url:"ajax/search_stock_value.php",
				method: "POST",
				data: {
					start: $('#start_date').val(),
					end: $('#end_date').val()
				},
				dataType: 'html',
				beforeSend:function(){
					$('#show_button').attr('disabled',true);
					$('#input_list').html('<div style="position;absolute;left:0;right:0;color:##2B3940;width:100%;text-align:center;padding:20px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
				},
				success: function(response) {
                    $('#input_list').html(response);
				}
			});
		}
	};
</script>