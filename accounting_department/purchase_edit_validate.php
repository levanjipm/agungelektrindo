<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	
	if(empty($_POST['invoice_id'])){
?>
<script>
	window.location.href='/agungelektrindo/accounting_department/edit_purchase_dashboard';
</script>
<?php 
	}
	
	$invoice_id				= $_POST['invoice_id'];
	$sql_code				= "SELECT * FROM purchases WHERE id = '$invoice_id'";
	$result_code			= $conn->query($sql_code);
	$code					= $result_code->fetch_assoc();
	
	$invoice_date			= $code['date'];
	$faktur					= $code['faktur'];
	$document_name			= $code['name'];
	$document_description	= $code['keterangan'];
	$document_value			= $code['value'];
	
	$supplier_id			= $code['supplier_id'];
	$sql_supplier			= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier		= $conn->query($sql_supplier);
	$supplier				= $result_supplier->fetch_assoc();
	
	$supplier_name			= $supplier['name'];
	$supplier_address		= $supplier['address'];
	$supplier_city			= $supplier['city'];
	
	$name					= $code['name'];
	$faktur					= $code['faktur'];
	
	$sql_good_receipt		= "SELECT id FROM code_goodreceipt WHERE isinvoiced = '1' AND invoice_id = '$invoice_id'";
	$result_good_receipt	= $conn->query($sql_good_receipt);
	if(mysqli_num_rows($result_good_receipt) == 0){
		$invoice_type		= "EMPTY";
	} else {
		$invoice_type		= "NORMAL";
	}
?>
<script src='/agungelektrindo/universal/Jquery/jquery.inputmask.bundle.js'></script>
<head>
	<title>Edit <?= $document_name . ' ' . $supplier_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Debt document</h2>
	<p style='font-family:museo'>Edit debt document</p>
	<hr>
<?php	
	if($invoice_type		== "NORMAL"){
		$good_receipt		= mysqli_num_rows($result_good_receipt);
?>
	<label>Date</label>
	<input type='date' class='form-control' value='<?= $invoice_date ?>' id='document_date'>
	
	<label>Document name</label>
	<input type='text' class='form-control' id='document_name' value='<?= $document_name ?>'>
	
<?php
	if($faktur				!= ''){
?>
	<label>Tax document</label>
	<input type='text' class='form-control' id='tax_document' value='<?= $faktur ?>'>
	<script>
		$("#tax_document").inputmask("999.999.99-99999999");
	</script>
<?php
	} else {
?>
	<input type='hidden' name='tax_document'>
<?php
	}
?>
	<br>
	<button type='button' class='button_default_dark' id='submit_button' title='Edit general data'><i class='fa fa-long-arrow-right'></i></button>
	<br>
	<br>
	<div class='full_screen_wrapper' id='confirm_change_notif'>
		<div class='full_screen_notif_bar'>
			<h1 style='font-size:2em;color:red'><i class='fa fa-exclamation'></i></h1>
			<p style='font-family:museo'>Are you sure to edit this debt document?</p>
			<button type='button' class='button_danger_dark' id='close_notif_bar_button'>Check again</button>
			<button type='button' class='button_success_dark' id='confirm_change_button'>Confirm</button>
		</div>
	</div>
<?php
	if($faktur				!= ''){
?>	
	<script>
		$('#submit_button').click(function(){
			if($('#tax_document').val() == ''){
				alert('Please insert tax document number');
				$('#tax_document').focus();
				return false;
			} else {
				var window_height		= $(window).height();
				var notif_height		= $('#confirm_change_notif .full_screen_notif_bar').height();
				var difference			= window_height - notif_height;
				
				$('#confirm_change_notif .full_screen_notif_bar').css('top', 0.7 * difference / 2);
				$('#confirm_change_notif').fadeIn();
			}
		});
		
		$('#confirm_change_button').click(function(){
			$.ajax({
				url:'purchase_edit_general_input.php',
				data:{
					purchase_id:<?= $invoice_id ?>,
					date:$('#document_date').val(),
					name:$('#document_name').val(),
					faktur:$('#tax_document').val(),
				},
				type:'POST',
				beforeSend:function(){
					$('#confirm_change_button').html("<i class='fa fa-spin fa-spinner'></i>");
					$('#confirm_change_button').attr('disabled',true);
				},
				success:function(){
					window.location.reload();
					$('#confirm_change_button').attr('disabled',false);
				}
			});
		});
	</script>
<?php
	} else {
?>
	<script>
		$('#submit_button').click(function(){
			var window_height		= $(window).height();
			var notif_height		= $('#confirm_change_notif .full_screen_notif_bar').height();
			var difference			= window_height - notif_height;
			
			$('#confirm_change_notif .full_screen_notif_bar').css('top', 0.7 * difference / 2);
			$('#confirm_change_notif').fadeIn();
		});
		
		$('#confirm_change_button').click(function(){
			$.ajax({
				url:'purchase_edit_general_input.php',
				data:{
					purchase_id:<?= $invoice_id ?>,
					date:$('#document_date').val(),
					name:$('#document_name').val(),
					faktur:'',
				},
				type:'POST',
				beforeSend:function(){
					$('#confirm_change_button').html("<i class='fa fa-spin fa-spinner'></i>");
					$('#confirm_change_button').attr('disabled',true);
				},
				success:function(){
					window.location.reload();
					$('#confirm_change_button').attr('disabled',false);
				}
			});
		});
	</script>
<?php
	}
?>
	<script>
		$('#close_notif_bar_button').click(function(){
			$('#confirm_change_notif').fadeOut();
		});
	</script>
	<label>Supplier data</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	
	<label>Good receipt</label>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Document</th>
		</tr>
<?php
		$sql_good_receipt		= "SELECT id, date, document FROM code_goodreceipt WHERE invoice_id = '$invoice_id'";
		$result_good_receipt	= $conn->query($sql_good_receipt);
		while($good_receipt		= $result_good_receipt->fetch_assoc()){
			$gr_date			= $good_receipt['date'];
			$gr_id				= $good_receipt['id'];
			$gr_document		= $good_receipt['document'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($gr_date)) ?></td>
			<td><?= $gr_document ?></td>
		</tr>
<?php
		}
?>
	</table>
	
	<label>Items</label>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Total price</th>
		</tr>
<?php
		$invoice_value			= 0;
		$sql_good_receipt		= "SELECT id, date, document FROM code_goodreceipt WHERE invoice_id = '$invoice_id'";
		$result_good_receipt	= $conn->query($sql_good_receipt);
		while($good_receipt		= $result_good_receipt->fetch_assoc()){
			$gr_id				= $good_receipt['id'];
			$sql				= "SELECT goodreceipt.id, purchaseorder.reference, goodreceipt.quantity, itemlist.description, goodreceipt.billed_price FROM goodreceipt 
									JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
									JOIN itemlist ON purchaseorder.reference = itemlist.reference
									WHERE goodreceipt.gr_id = '$gr_id'";
			$result				= $conn->query($sql);
			while($row			= $result->fetch_assoc()){
				$detail_id		= $row['id'];
				$reference		= $row['reference'];
				$description	= $row['description'];
				$quantity		= $row['quantity'];
				$price			= $row['billed_price'];
				$gr_price		= $price * $quantity;
				
				$invoice_value	+= $gr_price;
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity) ?></td>
			<td>Rp. <?= number_format($price,2) ?></td>
			<td>Rp. <?= number_format($gr_price,2) ?></td>
			<td><button type='button' class='button_success_dark' onclick='open_edit_form(<?= $detail_id ?>)'><i class='fa fa-eye'></i></button></td>
		</tr>
<?php
			}
		}
?>
		<tr>
			<td colspan='3'></td>
			<td>Grand total</td>
			<td>Rp. <?= number_format($invoice_value,2) ?></td>
		</tr>
	</table>
</div>
<div class='full_screen_wrapper' id='item_edit_form'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'></div>
</div>
	<script>
		function open_edit_form(n){
			$.ajax({
				url:'purchase_edit_item_view.php',
				data:{
					good_receipt_id:n,
				},
				type:'POST',
				success:function(response){
					$('.full_screen_box').html(response);
					$('#item_edit_form').fadeIn();
				}
			});
		}
		
		$('.full_screen_close_button').click(function(){
			$('#item_edit_form').fadeOut();
		});
	</script>
<?php
	} else {
?>
	<label>Date</label>
	<input type='date' class='form-control' value='<?= $invoice_date ?>' id='document_date'>
	
	<label>Document name</label>
	<input type='text' class='form-control' id='document_name' value='<?= $document_name ?>'>
	
<?php
		if($faktur				!= ''){
?>
	<label>Tax document</label>
	<input type='text' class='form-control' id='tax_document' value='<?= $faktur ?>'>
	<script>
		$("#tax_document").inputmask("999.999.99-99999999");
	</script>
<?php
		} else {
?>
	<input type='hidden' id='tax_document'>
<?php
		}
?>
	<label>Description</label>
	<textarea class='form-control' style='resize:none' id='document_description'><?= $document_description ?></textarea>
	
	<label>Value</label>
	<input type='number' class='form-control' id='price' value='<?= $document_value ?>'>
	
	<div class='full_screen_wrapper' id='edit_confirmation_notif'>
		<div class='full_screen_notif_bar'>
			<h1 style='font-size:2em;color:red'><i class='fa fa-exclamation'></i></h1>
			<p style='font-family:museo'>Are you sure to edit this invoice?</p>
			<button type='button' class='button_danger_dark' id='close_confirmation_notif'>Check again</button>
			<button type='button' class='button_success_dark' id='confirm_edit_random_button'>Confirm</button>
		</div>
	</div>
	<br>
	<button type='button' class='button_success_dark' id='confirm_change_invoice_button'><i class='fa fa-long-arrow-right'></i></button>
	
	<script>
		$('#confirm_change_invoice_button').click(function(){
			var window_height		= $(window).height();
			var notif_height		= $('#edit_confirmation_notif .full_screen_notif_bar').height();
			var difference			= window_height - notif_height;
			
			$('#edit_confirmation_notif .full_screen_notif_bar').css('top', 0.7 * difference / 2);
			$('#edit_confirmation_notif').fadeIn();
		});
		
		$('#close_confirmation_notif').click(function(){
			$('#edit_confirmation_notif').fadeOut();
		});
		
		$('#confirm_edit_random_button').click(function(){
			$.ajax({
				url:'purchase_edit_random_input.php',
				data:{
					invoice_id:<?= $invoice_id ?>,
					description:$('#document_description').val(),
					date:$('#document_date').val(),
					name:$('#document_name').val(),
					tax:$('#tax_document').val(),
					value:$('#price').val(),
				},
				type:'POST',
				beforeSend:function(){
					$('#confirm_edit_random_button').attr('disabled',true);
				},
				success:function(){
					window.location.reload();
				}
			})
		});					
	</script>
<?php
	}
?>