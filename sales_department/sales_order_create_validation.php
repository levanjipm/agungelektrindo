<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Validate sales order</title>
</head>
<script>
	$('#sales_order_side').click();
	$('#sales_order_create_dashboard').find('button').addClass('activated');
</script>
<style>
	input[type="file"] {
		display: none;
	}
	.custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 6px 12px;
		cursor: pointer;
	}
</style>
<?php
	$customer_top		= $_POST['customer_top'];
	$reference_array	= $_POST['reference'];
	$quantity_array		= $_POST['quantity'];
	$vat_array			= $_POST['vat'];
	$pl_array			= $_POST['pl'];

	$so_date			= $_POST['sales_order_date'];
	$taxing 			= $_POST['taxing'];
	$po_number 			= mysqli_real_escape_string($conn,$_POST['purchase_order_name']);
	$customer 			= $_POST['select_customer'];
	if($customer == NULL){
		$address 		= mysqli_real_escape_string($conn,$_POST['retail_address']);
		$city 			= mysqli_real_escape_string($conn,$_POST['retail_city']);
		$phone 			= mysqli_real_escape_string($conn,$_POST['retail_phone']);
		$name 			= mysqli_real_escape_string($conn,$_POST['retail_name']);
	} else {
		$address 		= '';
		$city 			= '';
		$phone 			= '';
		$name 			= '';
	}
	$sql_customer 		= "SELECT name, address, city FROM customer WHERE id = '" . $customer . "'";
	$result_customer 	= $conn->query($sql_customer);
	$customer_row		= $result_customer->fetch_assoc();
	$customer_name 		= $customer_row['name'];
	$customer_address	= $customer_row['address'];
	$customer_city		= $customer_row['city'];
	
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	$guid = GUID();
?>
<div class='main'>
	<form action="sales_order_create_input" method="POST" id='sales_order_form' enctype="multipart/form-data">
		<h2 style='font-family:bebasneue'>Sales Order</h2>
		<p>Validate Sales Order</p>
		<hr>
		<input type='hidden' value='<?= $address ?>' name='retail_address'>
		<input type='hidden' value='<?= $city ?>' name='retail_city'>
		<input type='hidden' value='<?= $phone ?>' name='retail_phone'>
		<input type='hidden' value='<?= $name ?>' name='retail_name'>
		<input type='hidden' value='<?= $guid ?>' name='guid'>
		
		<input type='hidden' value="<?= $so_date ?>" class="form-control" readonly>
		<input type='hidden' value="<?= $so_date ?>" name="today">
		<input type='hidden' value="<?= $customer?>" name="customer">
		<input type='hidden' value="<?= $customer_top?>" name="customer_top">
		
		<label>Customer</label>
<?php if($customer == 0){ ?>
			<p style="font-family:museo">Retail</p>
<?php } else { ?>
			<p style="font-family:museo"><?= $customer_name ?></p>
			<p style="font-family:museo"><?= $customer_address ?></p>
			<p style="font-family:museo"><?= $customer_city ?></p>
<?php }	if($customer == 0){ ?>
			<p style='font-family:museo'><?= $name ?></p>
			<p style='font-family:museo'><?= $address ?></p>
			<p style='font-family:museo'><?= $city ?></p>
			<p style='font-family:museo'><?= $phone ?></p>
<?php } ?>
		<p><strong>Purchase order number</strong></p>
		<p><?= $po_number ?></p>
		<p><strong>Term of payment</strong></p>
		<p><?= $customer_top ?></p>
		<input type="hidden" class="form-control" value="<?= $po_number ?>" readonly name="purchaseordernumber">
		<label>Taxing Option</label>
<?php if($customer == 0){ ?>
			<p>Retail may not receive tax document</p>
			<input type="hidden" class="form-control" value="0" readonly name="taxing" style='display:none'>
<?php } else { if($taxing == 1){
?>
			<p>Taxable</p>
<?php
			} else {
?>
			<p>Untaxable sales</p>
<?php
			}
?>
			<input type="hidden" class="form-control" value="<?= $taxing ?>" readonly name="taxing">
<?php
		}
?>
		<label for="file-upload" class="custom-file-upload">
			<i class="fa fa-cloud-upload"></i> File Upload
		</label>
		<input id="file-upload" type="file" name='purchase_order_file' accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps"/>
			
		<table class="table table-bordered">
			<thead>
				<tr>
					<th style='text-align:center'>Reference</th>
					<th style='text-align:center'>V.A.T.</th>
					<th style='text-align:center'>Discount</th>
					<th style='text-align:center'>Quantity</th>
					<th style='text-align:center'>Price List</th>
					<th style='text-align:center'>Total price</th>
				</tr>
			</thead>	
			<tbody>
<?php
	$i = 1;
	$total_sales_order = 0;
	foreach($reference_array as $reference){
		$key 		= key($reference_array);
		$quantity 	= $quantity_array[$key];
		$vat 		= $vat_array[$key];
		$pl 		= $pl_array[$key];
		
		$discount	= 100 - ($vat * 100/$pl);
		$total_price = $vat * $quantity;
?>
				<tr style="text-align:center">	
					<td><?= $reference ?></td>						
					<td>Rp. <?= number_format($vat,2) ?></td>
					<td><?= number_format($discount,2) . '%' ?></td>
					<td><?= $quantity ?></td>
					<td>Rp. <?= number_format($pl,2) ?></td>
					<td>Rp. <?= number_format($total_price,2) ?></td>
				</tr>
				<input type='hidden' value="<?= $reference ?>" 	name="reference[<?=$i?>]">
				<input type='hidden' value="<?= $vat ?>" 		name="value_after_tax[<?=$i?>]">
				<input type='hidden' value="<?= $quantity ?>" 	name="quantity[<?=$i?>]">
				<input type='hidden' value="<?= $pl ?>" 		name="price_list[<?=$i?>]">
<?php
		$i++;
		$total_sales_order += $total_price;
		next($reference_array);
	}
?>
			</tbody>
			<tfoot>
				<tr>
					<td style="border:none" colspan='4'></td>
					<td style="padding-left:50px"><b>Grand Total</b></td>
					<td style="text-align:center">Rp. <?= number_format($total_sales_order,2)?></td>
				</tr>
			</tfoot>
		</table>
		<label>Note</label>
		<textarea name="sales_order_note" class='form-control' style='resize:none' rows='5'></textarea>
		<br>
		<button type="button" class="button_success_dark" id='submit_button'>Submit</button>
	</form>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to confirm this Sales Order?</h2>
		<br>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Back</button>
		<button type='button' class='button_success_dark' id='confirm_sales_order_button'>Confirm</button>
	</div>
</div>
<script>
	$('#submit_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn();
		$('#customer_id').val(n);
	});
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#confirm_sales_order_button').click(function(){
		$('#sales_order_form').submit();
	});
</script>