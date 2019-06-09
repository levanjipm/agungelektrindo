<?php
	include('financialheader.php');
?>
<div class='main'>
	<div class='container'>
		<h2>Bank Account</h2>
		<p>Mutation</p>
		<hr>
	</div>
	<div class='row'>
		<div class='col-sm-3'>
			<label>Date start</label>
			<input type='date' class='form-control' id='start_date' name='start_date'>
		</div>
		<div class='col-sm-3'>
			<label>Date end</label>
			<input type='date' class='form-control' id='end_date' name='end_date'>
		</div>
		<div class='col-sm-3'>
			<label style='color:white'>x</label><br>
			<button type='button' class='btn btn-default' onclick='view()'>View</button>
		</div>
	<hr>
	</div>
	<div id='banks'>
	</div>
	<div id="showresults"></div>
</div>
<form id="reset_form" action='reset_transaction_validation.php' method='POST'>
	<input type='hidden' value="" name='bank_id' id='bank_id'>
</form>
<script>
	function view(){
		var start= new Date($("#start_date").val());
		var end= new Date($("#end_date").val());
		var diff = new Date(end - start);
		var days = diff/1000/60/60/24;
		
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
				url: "ajax/reset.php",
				data: {
					start_date: $('#start_date').val(),
					end_date: $('#end_date').val()
				},
				type: "POST",
				success: function (data) {
					$('#banks').replaceWith($('#showresults').html(data));
				},
			});
		}
	}
	function reset(n){
		$('#bank_id').val(n);
		$('#reset_form').submit();
	}
</script>