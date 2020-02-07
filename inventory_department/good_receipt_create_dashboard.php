<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Create good receipt</title>
</head>
<div class='main'>
	<h2 style=';font-family:bebasneue'>Good receipt</h2>
	<p style='font-family:museo'>Create new good receipt</p>
	<hr>
	
	<label>Date</label>
	<input type='date' class='form-control' id='date'>
	
	<label>Supplier</label>
	<select class='form-control' id='supplier' required>
		<option value=''>--Please Select a supplier--</option>
<?php
	$sql_incomplete_supplier	= "SELECT DISTINCT(code_purchaseorder.supplier_id) as id, supplier.name FROM code_purchaseorder 
									JOIN purchaseorder ON purchaseorder.purchaseorder_id = code_purchaseorder.id 
									JOIN supplier ON code_purchaseorder.supplier_id = supplier.id
									WHERE purchaseorder.status = '0'";
	$result_supplier			= $conn->query($sql_incomplete_supplier);
	while($supplier				= $result_supplier->fetch_assoc()){
		$supplier_id			= $supplier['id'];
		$supplier_name			= $supplier['name'];
?>
		<option value='<?= $supplier_id ?>'><?= $supplier_name ?></option>
<?php } ?>
	</select>
	
	<div id='purchase_order_wrapper'>
	</div>
	<br>
	<button type='button' class='button_success_dark' id='submit_button'><i class='fa fa-long-arrow-right'></i></button>
</div>

<div class='full_screen_wrapper' id='good_receipt_create_wrapper'>
	<button type='button' class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'></div>
</div>
<script>
	$(document).ready(function(){
		$('#date').focus();
	});

	$("#supplier").change(function(){
		var options = {
			url: 'good_receipt_incomplete_purchase_order.php',
			type: "POST",
			data: {
				supplier_id:$('#supplier').val()
			},
			success: function(response){
				$('#purchase_order_wrapper').html(response);
			}};
		$.ajax(options);
	});
	
	$('#submit_button').click(function(){
		if($('#date').val() == ''){
			alert('Please insert date');
			return false;
		} else {
			$.ajax({
				url:'good_receipt_create_form',
				data:{
					purchase_order: $('#purchase_order').val(),
					date:$('#date').val()
				},
				type:'POST',
				success:function(response){
					$('#good_receipt_create_wrapper .full_screen_box').html(response);
					$('#good_receipt_create_wrapper').fadeIn();
				}
			});
		}
	});
	
	$('.full_screen_close_button').click(function(){
		$(this).parent().fadeOut();
	});
</script>