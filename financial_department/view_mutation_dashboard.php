<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
?>
<head>
	<title>View bank mutation data</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank Account</h2>
	<p style='font-family:museo'>Mutation</p>
	<hr>
	<div class='row'>
		<div class='col-sm-3'>
			<label>Date start</label>
			<input type='date' class='form-control' id='start_date'>
		</div>
		<div class='col-sm-3'>
			<label>Date end</label>
			<input type='date' class='form-control' id='end_date'>
		</div>
		<div class='col-sm-3'>
			<label style='color:white'>x</label><br>
			<button type='button' class='button_success_dark' id='view_mutation_button'>View</button>
		</div>
		<hr>
	</div>
	<div id='banks'></div>
</div>
<script>
	$('#view_mutation_button').click(function(){
		var start	= new Date($("#start_date").val());
		var end		= new Date($("#end_date").val());
		var diff 	= new Date(end - start);
		var days 	= diff/1000/60/60/24;
		
		if($('#start_date').val() == ''){
			alert('Insert start date!');
			$('#start_date').focus();
			return false;
		} else if($('#end_date').val() == ''){
			alert('Insert end date!');
			$('#end_date').focus();
			return false;
		} else if(days > 7){
			alert('Maximum 7 days!');
			return false;
		} else {
			$.ajax({
				url: "mutation.php",
				data: {
					start_date: $('#start_date').val(),
					end_date: $('#end_date').val()
				},
				type: "POST",
				beforeSend:function(){
					$('#view_mutation_button').attr('disabled',true);
					$('#banks').html("<h1 style='font-size:6em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h1>");
				},
				success:function(response){
					$('#view_mutation_button').attr('disabled',false);
					$('#banks').html(response);
				},
			});
		}
	});
</script>