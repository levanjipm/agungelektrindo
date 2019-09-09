<?php
	//Stock value Journal//
	include('accountingheader.php');
?>
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
			<button type='button' class='button_default_dark' onclick='check_date()'>Show</button>
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
				success: function(response) {
                    $(input_list).html(response);
				}
			});
		}
	};
</script>