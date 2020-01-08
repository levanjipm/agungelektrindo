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
<h3 style='font-family:bebasneue'>Edit invoice data</h2>
<hr>
<label>Reference</label>
<p style='font-famliy:museo'><?= $reference ?></p>

<label>Descritpion</label>
<p style='font-family:museo'><?= $description ?></p>

<label>Quantity</label>
<p style='font-family:museo'><?= number_format($quantity) ?></p>

<label>Price</label>
<input type='number' class='form-control' id='billed_price' value='<?= $billed_price ?>'>

<br>
<button type='button' class='button_success_dark' id='submit_price_change'>Submit</button>
<script>
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
				window.location.reload();
			}
		});
	});
</script>