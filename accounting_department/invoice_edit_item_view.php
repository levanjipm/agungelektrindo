<?php
	include('../codes/connect.php');
	$delivery_order_id			= $_POST['delivery_order_id'];
	$sql						= "SELECT delivery_order.quantity, delivery_order.reference, delivery_order.billed_price, itemlist.description
									FROM delivery_order
									JOIN itemlist ON itemlist.reference = delivery_order.reference
									WHERE delivery_order.id = '$delivery_order_id'";
	$result						= $conn->query($sql);
	$row						= $result->fetch_assoc();
	$reference					= $row['reference'];
	$description				= $row['description'];
	$quantity					= $row['quantity'];
	$billed_price				= $row['billed_price'];
?>
<h2 style='font-family:bebasneue'>Edit invoice data</h2>
<hr>
<table class='table table-bordered'>
	<tr>
		<th>Reference</th>
		<th>Quantity</th>
		<th>Price</th>
		<th>Total price</th>
	</tr>
	<tr>
		<td><?= $reference ?></td>
		<td><?= $quantity ?></td>
		<td><input type='number' class='form-control' id='billed_price' value='<?= $billed_price ?>' onkeyup='adjust_total_price()'></td>
		<td id='total_price_text'></td>
	</tr>
</table>
<button type='button' class='button_danger_dark' id='close_box_button'>Check again</button>
<button type='button' class='button_success_dark' id='submit_price_change'>Submit</button>
<script>
	function adjust_total_price(){
		var unit_price			= $('#billed_price').val();
		var quantity			= <?= $quantity ?>;
		var total_price			= quantity * unit_price;
		$('#total_price_text').text(numeral(total_price).format('0,0.00'));
	}
	
	$(document).ready(function(){
		adjust_total_price();
	});
	
	$('#submit_price_change').click(function(){
		$.ajax({
			url:'invoice_edit_item_input.php',
			type:'POST',
			data:{
				delivery_order_id: <?= $delivery_order_id ?>,
				price			:	$('#billed_price').val()
			},
			beforeSend:function(){
				$('#submit_price_change').attr('disabled',true);
			},
			success:function(){
				location.reload();
			}
		});
	});
	
	$('#close_box_button').click(function(){
		$('.full_screen_close_button').click();
	});
</script>