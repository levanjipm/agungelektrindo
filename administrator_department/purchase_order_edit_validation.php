<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/administrator_header.php');
	$po_id 			= $_POST['id'];
	$sql_user 		= "SELECT role FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user 	= $conn->query($sql_user);
	if($role != 'superadmin'){
?>
		<script>
			window.location.href='purchasing';
		</script>
<?php
	}
	
	$sql_initial 			= "SELECT * FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_initial 		= $conn->query($sql_initial);
	$row_initial 			= $result_initial->fetch_assoc();
	
	$purchase_order_name	= $row_initial['name'];
	$supplier_id 			= $row_initial['supplier_id'];
	$tax 					= $row_initial['taxing'];
	$top 					= $row_initial['top'];
	$promo_code 			= $row_initial['promo_code'];
	
	$sql_supplier 			= "SELECT name, address, city FROM supplier WHERE id = '" . $supplier_id . "'";
	$result_supplier 		= $conn->query($sql_supplier);
	$supplier 				= $result_supplier->fetch_assoc();
		
	$supplier_name			= $supplier['name'];
	$supplier_address		= $supplier['address'];
	$supplier_city			= $supplier['city'];
?>
<head>
	<title>Edit <?= $purchase_order_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase order</h2>
	<p style='font-family:museo'>Edit purchase order</p>
	<hr>
	<form action='purchase_order_edit' method="POST" id='edit_purchase_order_form'>
		<label>Purchase order data</label>
		<p style='font-family:museo'><?= $purchase_order_name ?></p>
		<p style='font-family:museo'><?= $supplier_name ?></p>
		<p style='font-family:museo'><?= $supplier_address ?></p>
		<p style='font-family:museo'><?= $supplier_city ?></p>
		
		<input type='hidden' value='<?= $po_id ?>' name='purchase_order_id'>
		
		<label>Promo Code</label>
		<input type="text" class="form-control" value="<?= $promo_code?>" name="promo_code" style='width:50%'>
		<label>Taxing option</label>
		<select class="form-control" name="taxing" style='width:50%'>
			<option value='1' <?php if($tax == 1) { echo 'selected'; } ?>>Tax</option>
			<option value='2' <?php if($tax == 2) { echo 'selected'; } ?>>Non Tax</option>
		</select>
		<label>Term of payment</label>
		<div>
			<input type="text" value="<?= $top ?>" class="form-control" name="top" style='width:50%;display:inline-block;'>
			<span style='width:20%;display:inline-block;'>Days</span>
		</div>
		<br>
		<h4 style='font-family:bebasneue;display:inline-block'>Details</h4>
		<button type='button' class='button_default_dark' style='display:inline-block' id='add_item_button'>Add item</button>
		<table class='table table-bordered'>
			<tr>
				<th>Item</th>
				<th>Price list(Rp.)</th>
				<th>Discount</th>
				<th>Unit price</th>
				<th>Quantity</th>
				<th>Received</th>
				<th>Total price</th>
				<th></th>
			</tr>
			<tbody id='purchase_order_body'>
<?php
	$sql  = "SELECT * FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$total_price 		= $row['unitprice'] * $row['quantity'];
		$quantity_received	= $row['received_quantity'];
		$reference			= $row['reference'];
		$price_list			= $row['price_list'];
		$discount			= $row['discount'];
		$unit_price			= $row['unitprice'];
		
		if($quantity_received > 0){
			$disabled = 'disabled';
		} else {
			$disabled = '';
		}
		
		if($disabled == 'disabled'){
?>
				<tr>
					<td><?= $reference ?></td>
					<td>Rp. <?= number_format($price_list,2) ?></td>
					<td><?= number_format($discount,2) ?>%</td>
					<td>Rp. <?= number_format($unit_price,2) ?></td>
					<td><input type="number" value="<?= $row['quantity'] ?>"	class="form-control" id="qty<?= $row['id'] ?>" 	name="qty[<?= $row['id'] ?>]" 		min='<?= $quantity_received ?>' ></td>
					<td><?= number_format($quantity_received,0) ?></td>
					<td><?= number_format($total_price,2) ?></td>
					<td></td>
				</tr>
				<script>
					$( function() {
						$('#reference<?= $row['id'] ?>').autocomplete({
							source: "ajax/search_item.php"
						 })
					});
				</script>
<?php
		} else {
?>
				<tr id="tr<?= $row['id'] ?>">
					<td><input type='text' value="<?= $row['reference'] ?>" 	class='form-control' id='reference<?= $row['id'] ?>' 	name='reference[<?= $row['id'] ?>]'></td>
					<td><input type="text" value="<?= $row['price_list'] ?>" 	class='form-control' name='price_list[<?= $row['id']?>]'></td>
					<td><input type="text" value="<?= $row['discount'] ?>" 		class='form-control' name='discount[<?= $row['id'] ?>]'	min='0' max='100'></td>
					<td><input type="text" value="<?= $row['unitprice'] ?>" 	class='form-control' readonly ></td>
					<td><input type="text" value="<?= $row['quantity'] ?>" 		class='form-control' name='quantity[<?= $row['id'] ?>]' min='<?= $min_val ?>' ></td>
					<td><?= number_format($quantity_received,0) ?></td>
					<td><?= number_format($total_price,2) ?></td>
					<td><button type="button" class="button_danger_dark" onclick="delete_item_exist(<?= $row['id'] ?>)" id='delete_button-<?= $row['id'] ?>'>&times</button></td>
				</tr>
				<script>
					$( function() {
						$('#reference<?= $row['id'] ?>').autocomplete({
							source: "ajax/search_item.php"
						 })
					});
				</script>
<?php
		}
	}
?>
			</tbody>
		</table>
		<button type="button" class="button_default_dark" onclick="calculate()">Calculate</button>
	</form>	
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-exclamation" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to delete this purchase order?</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Submit</button>
	</div>
</div>
<script>
	var a = 1;
	
	function delete_item_exist(n){
		$.ajax({
			url:'purchase_order_edit_delete_item.php',
			data:{
				purchase_order_id: n
			},
			type:'POST',
			beforeSend:function(){
				$('#delete_button-' + n).attr('disabled',true);
			},
			success:function(){
				$('#tr' + n).remove();
			}
		});
	}
	
	$("#add_item_button").click(function (){
		$("#purchase_order_body").append(
			"<tr id='tr-" + a + "'>"+
			"<td><input type='text' class='form-control' name='reference-[" + a + "]' id='reference-" + a + "'></td>"+
			"<td><input type='number' class='form-control' name='price_list-[" + a + "]' id='price_list-" + a + "'></td>"+
			"<td><input type='number' class='form-control' name='discount-[" + a + "]' id='discount-" + a + "' max='100' min='0'></td>"+
			"<td id='unit_price-" + a + "'></td>"+
			"<td><input type='number' class='form-control' name='quantity-[" + a + "]' id='quantity-" + a + "' min='0'></td>"+
			"<td>0</td>"+
			"<td id='total_price-" + a + "'></td>"+
			"<td><button type='button' class='button_danger_dark' onclick='delete_item(-" + a + ")'>&times</button></td>"+
			"</tr>");
		
		$('#reference-' + a).autocomplete({
			source: "ajax/search_item.php"
		});
		
		a++;
	});
	
	function calculate(){
		var reference_array = [];
		var duplicate		= false;
		$('input[id^="reference"]').each(function(){
			var reference_value		= $(this).val();
			if (reference_array.indexOf(reference_value) == -1){
				reference_array.push(reference_value);
			} else {
				duplicate	= true;
			}
		});
		
		if(duplicate == true){
			alert('Please insert unique references');
			return false;
		} else {
			var window_height			= $(window).height();
			var notif_height			= $('.full_screen_notif_bar').height();
			var difference				= window_height - notif_height;
			$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
			$('.full_screen_wrapper').fadeIn();
		}
	}	

	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#confirm_button').click(function(){
		$('#edit_purchase_order_form').submit();
	});
</script>