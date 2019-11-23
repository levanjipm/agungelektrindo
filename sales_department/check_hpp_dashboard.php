<?php
	include('salesheader.php');
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class='main'>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
	<h2 style='font-family:bebasneue'>Cost of Goods Sold</h2>
	<hr>
	<h4 style='font-family:bebasneue;display:inline-block'>Detail</h4>
	<button type='button' class='button_default_dark' style='display:inline-block' id='add_row_button'>Add Item</button>
	<form id='check_hpp_form' action='check_hpp' method='POST'>
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
					<td></td>
				</tr>
			</tbody>
		</table>
		<button type='button' class='button_default_dark' id='check_item_button'>Check</button>
		<button type='button' class='button_warning_dark' id='back_button' style='display:none'>Back</button>
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
				"<td><button type='button' class='button_danger_dark' onclick='remove_row(" + a + ")'>X</button></td>"+
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
			var input_id	= $(this).attr('id');
			var uid			= parseInt(input_id.substr(9,15));
			if($(this).val() == ''){
				alert('Please insert reference');
				$(this).focus();
				return false;
			} else {
				$.ajax({
					url:"check_quantity_hpp.php",
					data:{
						reference:$(this).val()
					},
					type:'POST',
					success:function(result){
						var reference	= $('#' + input_id).val();
						$('#wrapper_reference' + uid).html(reference);
						$('#wrapper_reference' + uid).append(
							"<input type='hidden' value='" + reference + "' name='reference[" + uid + "]'>"
						);
						$('#available_quantity' + uid).html(result);
						$('#quantity_wrapper' + uid).append(
							"<input type='number' class='form-control' id='quantity-" + uid + "' name='quantity[" + uid + "]' max='" + result + "'>"
						);
					},
				});
				
						
				$('.button_danger_dark').remove();
				$('#add_row_button').hide();
				$('#check_item_button').hide();
				$('#check_hpp_button').show();
			}
		});
	});
</script>