<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/administrator_header.php');
?>
<head>
	<title>Reset petty cash data</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Petty cash</h2>
	<p style='font-family:museo'>Edit petty cash data</p>
	<hr>
	<label>Date start</label>
	<input type='date' class='form-control' id='date_start'>
	<label>Date end</label>
	<input type='date' class='form-control' id='date_end'>
	<br>
	<button type='button' class='button_default_dark' id='search_button'><i class='fa fa-search'></i></button>
	<div id='preview_pane'></div>
</div>
<script>
	$('#search_button').click(function(){
		if($('#date_start').val() == ''){
			alert('Please insert starting date');
			$('#date_start').focus();
			return false;
		} else if($('#date_end').val() == ''){
			alert('Please insert end date');
			$('#date_end').focus();
			return false;
		} else {
			$.ajax({
				url:'petty_cash_view.php',
				data:{
					start_date:$('#date_start').val(),
					end_date:$('#date_end').val(),
				},
				type:'POST',
				beforeSend:function(){
					$('#preview_pane').html("<h2 style='font-size:3em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h2>");
					$('input').attr('readonly',true);
					$('button').attr('disabled',true);
				},
				success:function(response){
					$('#preview_pane').html(response);
					$('input').attr('readonly',false);
					$('button').attr('disabled',false);
				}
			});
		};
	});
</script>