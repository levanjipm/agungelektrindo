<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Check cost</title>
</head>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Cost of Goods Sold</h2>
	<hr>
	<button type='button' class='button_default_dark' id='add_row_button'>Add Item</button>
	<br><br>
	<form id='check_hpp_form' action='check_cost_report' method='POST'>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Quantity</th>
				<th>Available Qty.</th>
				<th></th>
			</tr>
			<tbody id='cost_goods_table'>
				<tr>
					<td id='wrapper_reference1'><input type='text' class='form-control' id='reference1'></td>
					<td id='quantity_wrapper1'></td>
					<td id='available_quantity1'></td>
					<td><button type='button' class='button_success_dark' style='visibility:hidden'><i class='fa fa-trash'></i></td>
				</tr>
			</tbody>
		</table>
		<button type='button' class='button_default_dark' id='check_item_button'>Check</button>
		<button type='button' class='button_danger_dark' id='back_button' style='display:none'>Back</button>
		<button type='submit' class='button_default_dark' id='check_hpp_button' style='display:none'>Next</button>
	</form>
</div>
<script>
	var a = 2;
	
	$('#add_row_button').click(function (){
		$('#cost_goods_table').append(
			"<tr id='tr-" + a + "'>"+
				"<td id='wrapper_reference" + a + "'><input type='text' class='form-control' id='reference" + a + "'></td>"+
				"<td id='quantity_wrapper" + a + "'></td>"+
				"<td id='available_quantity" + a + "'></td>"+
				"<td><button type='button' class='button_danger_dark' onclick='remove_row(" + a + ")'><i class='fa fa-trash'></i></button></td>"+
			"</tr>"
		).find("input").each(function () {});
		$("#reference" + a).autocomplete({
			source: "../codes/search_item.php"
		});
		a++;
	});

	function remove_row(n){
		$('#tr-' + n).remove();
	}

	$('#check_item_button').click(function(){
		$('input[id^="reference"]').each(function(){
			var input_id		= $(this).attr('id');
			var uid				= parseInt(input_id.substr(9,15));
			$.ajax({
				url:"check_cost_stock.php",
				data:{
					reference:$(this).val()
				},
				type:'POST',
				success:function(result){
					var reference	= $('#' + input_id).val();
					$('#wrapper_reference' + uid).html(reference);
					$('#wrapper_reference' + uid).append(
						"<input type='hidden' value='" + reference + "' id='reference" + uid + "' name='reference[" + uid + "]'>"
					);
					$('#available_quantity' + uid).html(result);
					$('#quantity_wrapper' + uid).append(
						"<input type='number' class='form-control' id='quantity-" + uid + "' name='quantity[" + uid + "]' max='" + result + "'>"
					);
				},
			});
						
			$('.button_danger_dark').hide();
			$('#add_row_button').hide();
			$('#check_item_button').hide();
			$('#check_hpp_button').show();
			$('#back_button').show();
		});
	});
	
	$('#back_button').click(function(){
		$('input[id^="reference"]').each(function(){
			var reference			= $(this).val();
			var input_id			= $(this).attr('id');
			var uid					= parseInt(input_id.substr(9,15));
			$('#wrapper_reference' + uid).html("<input type='text' class='form-control' id='reference" + uid + "' value='" + reference + "'>");
			$('#quantity_wrapper' + uid).html('');
			$('#reference' + uid).autocomplete({
				source: "../codes/search_item.php"
			 })
		})
		
		$('.button_danger_dark').show();
		$('#add_row_button').show();
		$('#check_item_button').show();
		$('#check_hpp_button').hide();
		$('#back_button').hide();
	});
			
</script>