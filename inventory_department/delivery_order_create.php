<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}

	$guid 			= GUID();
?>
<head>
	<title>Create delivery order</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Delivery Order</h2>
	<p style='font-family:museo'>Create new delivery order</p>
	<hr>
<?php
	$so_id 		= $_POST['id'];
	$sql 		= "SELECT * FROM code_salesorder WHERE id = '$so_id'";
	$result 	= $conn->query($sql);
	$row 		= $result->fetch_assoc();
	if(mysqli_num_rows($result) == 0){
?>
		<script>
			window.history.back();
		</script>
<?php
	} else {
		$so_id 				= $row['id'];
		$po_number 			= mysqli_real_escape_string($conn,$row['po_number']);
		$taxing 			= $row['taxing'];
		$customer_id 		= $row['customer_id'];
			
		$sql_customer 		= "SELECT name,address,city FROM customer WHERE id = '$customer_id'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		
		if($result_customer){
			$customer_name		= $customer['name'];
			$customer_address	= $customer['address'];
			$customer_city		= $customer['city'];
		} else {
			$customer_name		= $row['retail_name'];
			$customer_address	= $row['address'];
			$customer_city		= $row['city'];
		}
?>
	<form method='POST' action='delivery_order_create_input' id='delivery_order_form'>
		<input type='hidden' name='tax' value='<?= $taxing ?>'>
		<input type='hidden' name='id' value='<?= $so_id ?>'>
		<input type='hidden' name='customer_id' value='<?= $customer_id ?>'>
		<input type='hidden' value='<?= $guid ?>' name='guid'>
		
		<label>Date:</label>
		<input type='date' class='form-control' value='<?php echo date('Y-m-d');?>' name='delivery_order_date' id='delivery_order_date'>
		
		<label>Customer data</label>
		<p style='font-family:museo'><?= $customer_name ?></p>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>
		
		<label>Purchase order</label>
		<p style='font-family:museo'>
		<p style='font-family:museo'><?= $po_number ?></p>
		
		<input type="hidden" value="<?= $po_number ?>" class="form-control">
		<input type="hidden" value="<?= $customer_name ?>" class="form-control" readonly>

		<table class='table table-bordered'>
			<tr>
				<th style="width:40%">Item</th>
				<th style="width:20%">Sent item</th>
				<th style="width:20%">Quantity ordered</th>
				<th style="width:20%">Quantity to be sent</th>
				<th>Stock</th>
			</tr>
			<tbody>
			<?php
				$total_qty = 0;
				$sql_so 				= "SELECT id, reference, quantity, sent_quantity, status FROM sales_order WHERE so_id = '$so_id'";
				$result_so 				= $conn->query($sql_so);
				while($sales_order 		= $result_so->fetch_assoc()){
					$id					= $sales_order['id'];
					$reference 			= mysqli_real_escape_string($conn,$sales_order['reference']);
					$quantity			= $sales_order['quantity'];
					$sent_quantity		= $sales_order['sent_quantity'];
					$status				= $sales_order['status'];
					
					$maximum_quantity 	= $quantity - $sent_quantity;
					if ($status == 0){
						$sql_stock 			= "SELECT stock FROM stock WHERE reference = '$reference' ORDER BY id DESC";
						$result_stock 		= $conn->query($sql_stock);
						$stock 				= $result_stock->fetch_assoc();
						if($stock == NULL || $stock == 0){
							$final_stock	= 0;
						} else {
							$final_stock	= $stock['stock'];
						}
			?>
				<tr>
					<td><?= $reference ?></td>
					<td><?= $sent_quantity ?></td>
					<td><?= $quantity ?></td>
					<td><input class='form-control' type='number' id='delivery_order_quantity<?= $id ?>' name='quantity[<?= $id ?>]' min='0' max='<?= $quantity - $sent_quantity ?>' onkeyup='update_quantity()' value='0'></td>
					<td><?= number_format($final_stock) ?></td>
				</tr>
			<?php
					}
				}
			?>
			</tbody>
		</table>
		
		<button type='button' class='button_default_dark' onclick='view_delivery_order()'><i class='fa fa-long-arrow-right'></i></button>
	</form>
<input type='hidden' value='0' id='total_delivery_order'>
</div>

<div class='full_screen_wrapper' id='validate_delivery_order_form'>
	<button class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'>
		<h2 style='font-family:bebasneue'>Delivery order</h2>
		<hr>
		<label>Date</label>
		<p style='font-family:museo' id='date_p'></p>
		
		<label>Customer</label>
		<p style='font-family:museo'><?= $customer_name ?></p>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>
		
		<label>Delivery order</label>
		<table class='table table-bordered' id='check_out_table'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
<?php
	$sql	 			= "SELECT sales_order.id, sales_order.reference, itemlist.description
							FROM sales_order 
							JOIN itemlist ON sales_order.reference = itemlist.reference
							WHERE sales_order.so_id = '$so_id' AND sales_order.status = '0'";
	$result				= $conn->query($sql);
	while($row			= $result->fetch_assoc()){
		$sales_order_id	= $row['id'];
		$reference		= $row['reference'];
		$description	= $row['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td id='quantity_table-<?= $sales_order_id ?>'></td>
			</tr>
<?php
	}
?>
		</table>
		
		<button type='button' class='button_success_dark' id='submit_button'><i class='fa fa-long-arrow-right'></i></button>
	</div>
</div>

<script>
function update_quantity(){
	var quantity_now	= 0;
	$('input[id^="delivery_order_quantity"]').each(function(){
		var id			= $(this).attr('id');
		var uid			= parseInt(id.substring(23,40));
		$('#quantity_table-' + uid).html(numeral($(this).val()).format('0,0'));
		if($(this).val() == ''){
			quantity	= 0;
		} else {
			quantity	= $(this).val();
		}
		quantity_now	+= parseInt(quantity);
	});
	
	$('#total_delivery_order').val(quantity_now);
};

function check_delivery_order(){
	validation			= true;
	
	$('input[id^="delivery_order_quantity"]').each(function(){
		var id			= $(this).attr('id');
		var uid			= parseInt(id.substring(23,50));
		var quantity	= parseInt($(this).val());
		var max			= parseInt($(this).attr('max'));
		
		if(quantity > max){
			validation	= false;
		}
	});
	
	if($('#total_delivery_order').val() == 0){
		validation		= false;
	}
	
	return validation;
};

function view_delivery_order(){
	if($('#delivery_order_date').val() == ''){
		alert('Please insert date');
		return false;
	} else if(check_delivery_order()){
		transform_view();
	}
};

function transform_view(){
	$('td[id^="quantity_table-"]').each(function(){
		var quantity		= $(this).html();
		if(quantity == '0'){
			$(this).parent().hide();
		}
	});
	$('#date_p').html($('#delivery_order_date').val());
	
	$('#validate_delivery_order_form').fadeIn();
};

$('.full_screen_close_button').click(function(){
	$(this).parent().fadeOut();
});

$('#submit_button').click(function(){
	$('#delivery_order_form').submit();
});
</script>
<?php
	}
?>	