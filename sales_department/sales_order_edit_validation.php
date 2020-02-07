<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$po_number			= $_POST['po_number'];
	$po_number_on_input	= mysqli_real_escape_string($conn,$_POST['po_number']);
	$id_so				= $_POST['id_so'];
	$seller				= $_POST['seller'];
	$label				= $_POST['label'];
	
	$sql_code_so		= "SELECT customer_id FROM code_salesorder WHERE id = '" . $id_so . "'";
	$result_code_so		= $conn->query($sql_code_so);
	$code_so			= $result_code_so->fetch_assoc();
	$customer_id		= $code_so['customer_id'];
	
	
	if($customer_id == 0){
		$sql_customer		= "SELECT retail_name, retail_address, retail_city FROM code_salesorder WHERE id = '$id'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['retail_name'];
		$customer_address	= $customer['retail_address'];
		$customer_city		= $customer['retail_city'];
	} else {
		$sql_customer		= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
	}
	
	$reference_array		= $_POST['reference'];
	$quantity_array			= $_POST['quantity'];
	$price_array			= $_POST['price'];
	$price_list_array		= $_POST['price_list'];
?>
<head>
	<title>Validate Sales Order</title>
</head>
<script>
	$('#sales_order_side').click();
	$('#sales_order_edit_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<form id='edit_sales_order_form' action='sales_order_edit_input' method='POST'>
		<h2 style='font-family:bebasneue'>Sales Order</h2>
		<p style='font-family:museo'>Edit Sales Order</p>
		<hr>
		<label>Customer</label>
		<p style='font-family:museo'><?= $customer_name ?></p>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>
		
		<label>PO Number</label>
		<p><?= $po_number ?></p>
		
		<input type='hidden' value='<?= $po_number_on_input ?>' name='po_number'>
		<input type='hidden' value='<?= $label ?>' name='label'>
		<input type='hidden' value='<?= $seller ?>' name='seller'>
		<input type='hidden' value='<?= $id_so ?>' name='id_so'>
<?php
		if($label != '0'){
?>
			<label>Label</label>
			<p><?= $label ?></p>
<?php
		}
?>
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>Item Desc.</th>
					<th>Reference</th>
					<th>Quantity</th>
					<th>Price list</th>
					<th>Discount</th>
					<th>Net price</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
<?php
		$error				= 0;
		$total_sales_order	= 0;
		foreach($quantity_array as $quantity){
			$key	= key($quantity_array);
			
			$sql_check_quantity 	= "SELECT sent_quantity FROM sales_order WHERE id = '$key'";
			$result_check_quantity 	= $conn->query($sql_check_quantity);
			$check_quantity			= $result_check_quantity->fetch_assoc();
			
			$sent_quantity			= $check_quantity['sent_quantity'];
			
			if($sent_quantity > $quantity){
				$error++;
			}

			if(empty($price_array[$key])){
				$sql		= "SELECT price, price_list FROM sales_order WHERE id = '$key'";
				$result		= $conn->query($sql);
				$row		= $result->fetch_assoc();
				
				$price		= $row['price'];
				$price_list	= $row['price_list'];
			} else {
				$price		= $price_array[$key];
				$price_list	= $price_list_array[$key];
			}
			
			$reference		= $reference_array[$key];
			$reference_on_input	= mysqli_real_escape_string($conn,$reference);
			$sql_item		= "SELECT description FROM itemlist WHERE reference = '$reference_on_input'";
			$result_item	= $conn->query($sql_item);
			$item			= $result_item->fetch_assoc();
			$description	= $item['description'];
			
			$discount = 100 * (1 - ($price/ $price_list));
			
			$total			= $quantity * $price;
			$total_sales_order += $total;
?>	
			<tr>
				<td><?= $description ?></td>
				<td><?= $reference ?>
					<input type='hidden' value='<?= $reference ?>' name='reference[<?= $key ?>]'>
				</td>
				<td>
					<?= $quantity ?>
					<input type='hidden' value='<?= $quantity ?>' name='quantity[<?= $key ?>]'>
				</td>
				<td>
					Rp. <?= number_format($price_list,2) ?>
					<input type='hidden' value='<?= $price_list ?>' name='price_list[<?= $key ?>]'>
				</td>
				<td><?= number_format($discount,2) ?>%</td>
				<td>
					Rp. <?= number_format($price,2) ?>
					<input type='hidden' value='<?= $price ?>' name='price[<?= $key ?>]'>
				</td>
				<td>Rp. <?= number_format($total,2) ?></td>
			</tr>
<?php
			next($quantity_array);
		}
					
		if(!empty($_POST['reference_new'])){
			$reference_new_array	= $_POST['reference_new'];
			$quantity_new_array		= $_POST['quantity_new'];
			$price_new_array		= $_POST['price_new'];
			$price_list_new_array	= $_POST['price_list_new'];
			
			$i = 1;
			foreach($reference_new_array as $reference){
				$key = key($reference_new_array);
				$quantity		= $quantity_new_array[$key];
				$price			= $price_new_array[$key];
				$price_list		= $price_list_new_array[$key];
				
				$reference_on_input	= mysqli_real_escape_string($conn,$reference);
				$sql_item		= "SELECT description FROM itemlist WHERE reference = '$reference_on_input'";
				$result_item	= $conn->query($sql_item);
				$item			= $result_item->fetch_assoc();
				$description	= $item['description'];
				
				$discount = 100 * (1 - ($price/ $price_list));
				
				$total			= $quantity * $price;
				$total_sales_order += $total;
?>
			<tr>
				<td><?= $description ?></td>
				<td>
					<?= $reference ?>
					<input type='hidden' value='<?= $reference_on_input ?>' name='reference-[<?= $i ?>]'>
				</td>
				<td>
					<?= $quantity ?>
					<input type='hidden' value='<?= $quantity ?>' name='quantity-[<?= $i ?>]'>
				</td>
				<td>
					Rp. <?= number_format($price_list,2) ?>
					<input type='hidden' value='<?= $price_list ?>' name='price_list-[<?= $i ?>]'>
				</td>
				<td><?= number_format($discount,2) ?>%</td>
				<td>
					Rp. <?= number_format($price,2) ?>
					<input type='hidden' value='<?= $price ?>' name='price-[<?= $i ?>]'>
				</td>
				<td>Rp. <?= number_format($total,2) ?></td>
			</tr>
<?php
			$i++;
			next($reference_new_array);
		}
	}
?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan='5'></td>
					<td>Total</td>
					<td>Rp. <?= number_format($total_sales_order,2) ?></td>
				</tr>
			</tfoot>
		</table>
<?php
		if($error == 0){
?>
		<button type='submit' class='button_default_dark'>Submit</button>
<?php
		}
?>
	</form>
</div>
<script>
$('form').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
});
</script>