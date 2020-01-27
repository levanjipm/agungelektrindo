<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<script>
$( function() {
	$('#reference_dem').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Add event</h2>
	<p><strong>Materialized</strong> Goods</p>
	<hr>
	<form action='event_materialized_input' method='POST' id='materialized_form'>
		<div id='first_form'>
			<label>Date</label>
			<input type='date' class='form-control' name='date' id='date'>
			<label>Reference to be materialized</label>
			<input type='text' class='form-control' id='reference_dem' name='reference_dem'>
			<label>Quantity to be materialized</label>
			<input type='number' class='form-control' id='quantity' name='quantity_dem'>
			<label>Materialized from</label>
			<select class='form-control' id='number_of_dem'>
				<option value='2'>2</option>
				<option value='3'>3</option>
				<option value='4'>4</option>
			</select>
			<br>
			<a href='/agungelektrindo/inventory_department/event_add_dashboard' style='text-decoration:none'>
				<button type='button' class='button_warning_dark'>Back</button>
			</a>
			<button type='button' class='button_success_dark' id='next_dem_goods_confirmation_button'>Next</button>
		</div>
		<div id='second_form' style='display:none'>
			<br>
			<div id='appended_reference'>
			</div>
			<br><br>
			<button type='button' class='button_warning_dark' id='back_button'>Back</button>
			<button type='button' class='button_default_dark' id='submit_mat_goods_confirmation_button'>Submit</button>
		</div>
	</form>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class='fa fa-exclamation'></i></h1>
		<p style='font-family:museo'>Are you sure to submit this event?</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Back</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#back_button').click(function(){
		$('#first_form').fadeIn();
		$('#second_form').fadeOut();
	});
	
	$('#form_mat_goods_button').click(function(){
		$('#first_form').fadeOut();
		$('#second_form').fadeIn();
	});
	$('#back_dem_goods_button').click(function(){
		window.history.back();
	});
	$('#next_dem_goods_confirmation_button').click(function(){
		if($('#date').val() == ''){
			alert('Please insert date!');
			$('#date').focus();
			return false;
		} else {
			$.ajax({
				url:'../codes/check_item_availability.php',
				data:{
					reference : $('#reference_dem').val()
				},
				type:'POST',
				success:function(response){
					if($('date').val() == ''){
						alert('Please insert a valid date');
						return false;
					} else if($('#quantity').val() == '' || $('#quantity').val() == 0){
						alert('Please insert valid quantity');
						return false;
					} else if(response == 0){
						alert('Reference not found!');
						return false;
					} else {
						$('#appended_reference').html('');
						$('#first_form').fadeOut();
						var option_number = $('#number_of_dem').val();
						for (i = 1; i<= option_number; i++){
							$('#appended_reference').append("<div class='row'><div class='col-sm-6'><label>Reference #" + i + "</label><input type='text' class='form-control' name='reference[" + i + "]' id='reference-" + i + "' required></div><div class='col-sm-2'><label>Quantity #" + i + "</label><input type='number' class='form-control' name='quantity[" + i + "]'>");
							$("#reference-" + i).autocomplete({
								source: "../codes/search_item.php"
							 });
						}
						$('#second_form').fadeIn();
					}
				}
			});
		}
	});
	var available = 1;
	$('#submit_mat_goods_confirmation_button').click(function(){
		$.ajax({
			url:'../codes/check_item_availability.php',
			data:{
				reference : $('#reference').val()
			},
			type:'POST',
			success:function(response){
				if(response == 0){
					alert('Reference not found!');
					return false;
				} else {
					if($('#date').val() == ''){
						alert('Please insert correct date');
						return false;
					} else if($('#reference').val() == ''){
						alert('Please insert reference');
						return false;
					} else if($('#quantity').val() == '' || $('#quantity').val() <= 0){
						alert('Please insert correct quantity');
						return false;
					} else {
						var window_height			= $(window).height();
						var notif_height			= $('.full_screen_notif_bar').height();
						var difference				= window_height - notif_height;
						$('.full_screen_notif_bar').css('top', 0.7 * difference / 2)
						$('.full_screen_wrapper').fadeIn();
					}
				}
			},
		});
	})
	$('#confirm_button').click(function(){
		var reference_length = $('input[id^="reference-"]').length;
		for(i = 1; i <= reference_length; i++){
			if(i == reference_length){
				$.ajax({
					url:'../codes/check_item_availability.php',
					data:{
						reference : $('#reference-' + i).val()
					},
					type:'POST',
					success:function(response){
						if(response != 0){
							$('#materialized_form').submit();
						}
					}
				});
			} else {
				$.ajax({
					url:'../codes/check_item_availability.php',
					data:{
						reference : $('#reference-' + i).val()
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
	});
</script>