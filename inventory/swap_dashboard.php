<?php
	include('inventoryheader.php');
?>
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	})
	$('#reference2').autocomplete({
		source: "../codes/search_item.php"
	})
	$('#reference3').autocomplete({
		source: "../codes/search_item.php"
	})
	$('#reference4').autocomplete({
		source: "../codes/search_item.php"
	})
});
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Event</h2>
	<p>Input <strong>swap</strong> event</p>
	<hr>
	<form action='swap_input.php' method='POST' id='swap_event_form'>
		<div class='row'>
			<div class='col-xs-3'>
				<label>Date</label>
				<input type='date' class='form-control' id='date' name='date'>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-6 col-xs-12'>
				<h3 style='font-family:bebasneue'>Original items</h3>
				<label>Reference 1</label>
				<input type='text' class='form-control' id='reference1' name='reference1'>
				<label>Reference 2</label>
				<input type='text' class='form-control' id='reference2' name='reference2'>
				<label>Quantity</label>
				<input type='number' class='form-control' id='quantity' name='quantity'>
			</div>
			<div class='col-sm-6 col-xs-6'>
				<h3 style='font-family:bebasneue'>Swapped items</h3>
				<label>Reference 1</label>
				<input type='text' class='form-control' id='reference3' name='reference3'>
				<label>Pricelist 1</label>
				<input type='number' class='form-control' id='price_list1' name='price_list1'>
				<hr>
				<label>Reference 2</label>
				<input type='text' class='form-control' id='reference4' name='reference4'>
				<label>Pricelist 2</label>
				<input type='number' class='form-control' id='price_list2' name='price_list2'>
			</div>
		</div>
	</form>
	<div class='row'>
		<div class='col-xs-12'>
			<button type='button' class='btn btn-default' id='swap_event_button_submit'>Submit</button>
		</div>
	</div>
</div>
<script>
	$('#swap_event_button_submit').click(function(){
		if($('#date').val() == ''){
			alert('Please insert date');
			$('#date').focus();
			return false;
		} else if($('#quantity').val() == '' || $('#quantity').val() == 0){
			alert('Please insert correct quantity');
			$('#quantity').focus();
			return false;
		} else if($('#price_list1').val() == '' || $('#price_list2').val() == 0){
			alert('Please insert valid pricelist');
			$('#price_list1').focus();
			return false;
		} else if($('#price_list2').val() == '' || $('price_list2').val() == 0){
			alert('Please inesrt valid pricelist');
			$('#price_list2').focus();
			return false;
		} else {
			for(i = 1; i<= 4; i++){
				if(i == 4){
					$.ajax({
						url:'../codes/check_item_availability.php',
						data:{
							reference : $('#reference' + i).val()
						},
						type:'POST',
						success:function(response){
							console.log(response);
							if(response != 0){
								$('#swap_event_form').submit();
							}
						}
					});
				} else {
					$.ajax({
						url:'../codes/check_item_availability.php',
						data:{
							reference : $('#reference' + i).val()
						},
						type:'POST',
						success:function(response){
							console.log(response);
							if(response == 0){
								alert('Reference not found!');
								return false;
							}
						}
					});
				}
			}
		}
	});
</script>