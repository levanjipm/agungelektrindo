<?php
	include('../codes/connect.php');
	$good_receipt_id			= $_POST['good_receipt_id'];
	$sql						= "SELECT purchaseorder.reference, goodreceipt.billed_price, goodreceipt.quantity, goodreceipt.gr_id, itemlist.description
									FROM goodreceipt 
									JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
									JOIN itemlist ON itemlist.reference = purchaseorder.reference
									WHERE goodreceipt.id = '$good_receipt_id'";
	$result						= $conn->query($sql);
	$row						= $result->fetch_assoc();
	$reference					= $row['reference'];
	$quantity					= $row['quantity'];
	$description				= $row['description'];
	$billed_price				= $row['billed_price'];
	$gr_id						= $row['gr_id'];
	
	$sql						= "SELECT document, date FROM code_goodreceipt WHERE id = '$gr_id'";
	$result						= $conn->query($sql);
	$row						= $result->fetch_assoc();
	
	$document_name				= $row['document'];
	$document_date				= $row['date'];
?>
	<h3 style='font-family:bebasneue'>Edit item data</h3>
	<hr>
	<label>Reference</label>
	<p style='font-family:museo'><?= $reference ?></p>
	
	<label>Description</label>
	<p style='font-family:museo'><?= $description ?></p>
	
	<label>Quantity</label>
	<p style='font-family:museo'><?= number_format($quantity) ?></p>
	
	<label>Price</label>
	<input type='number' class='form-control' value='<?= $billed_price ?>' id='price'>

	<br>
	<button type='button' class='button_success_dark' id='submit_change_item_button'><i class='fa fa-long-arrow-right'></i></button>
	
	<script>
		$('#submit_change_item_button').click(function(){
			$.ajax({
				url:'purchase_edit_item_input.php',
				data:{
					good_receipt_id:<?= $good_receipt_id ?>,
					price:$('#price').val(),
				},
				type:'POST',
				beforeSend:function(){
					$('#submit_change_item_button').attr('disabled',true);
				},
				success:function(){
					window.location.reload();
				}
			});
		});
	</script>