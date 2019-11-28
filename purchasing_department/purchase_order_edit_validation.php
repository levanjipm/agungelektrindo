<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
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
	
	$sql_initial 	= "SELECT * FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_initial = $conn->query($sql_initial);
	$row_initial 	= $result_initial->fetch_assoc();
	
	$supplier_id 	= $row_initial['supplier_id'];
	$tax 			= $row_initial['taxing'];
	$top 			= $row_initial['top'];
	$promo_code 	= $row_initial['promo_code'];
	
	$sql_supplier 		= "SELECT name FROM supplier WHERE id = '" . $supplier_id . "'";
	$result_supplier 	= $conn->query($sql_supplier);
	$supplier 			= $result_supplier->fetch_assoc();
	
	$supplier_name		= $supplier['name'];
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<style>
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
	}
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
		box-shadow: 3px 4px 3px 4px #ddd;
	}
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-confirm{
		background-color:green;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
</style>
<div class="main">
	<div class='row'>
		<div class='col-sm-12'>
			<h2 style='font-family:bebasneue'>Purchase order</h2>
			<p>Edit purchase order</p>
			<hr>
			<form action='purchase_order_edit' method="POST" id='edit_purchase_order_form'>
				<input type='hidden' value='<?= $po_id ?>' name='purchase_order_id'>
				<label>Order to</label>
				<p><?= $supplier_name ?></p>
				<label>Promo Code</label>
				<input type="text" class="form-control" value="<?= $promo_code?>" name="promo_code" style='width:50%'>
				<label>Taxing option</label>
				<select class="form-control" name="taxing" style='width:50%'>
					<option value='1' <?php if($tax == 0) { echo 'selected'; } ?>>Tax</option>
					<option value='2' <?php if($tax != 0) { echo 'selected'; } ?>>Non Tax</option>
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
							<?= $row['id'] ?>
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
	</div>
</div>
<div class='notification_large' style='display:none'>
	<div class='notification_box' id='confirm_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to edit this purchase order?</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-confirm'>Confirm</button>
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
			$('.notification_large').fadeIn();
		}
	}	

	$('.btn-back').click(function(){
		$('.notification_large').fadeOut();
	});
	
	$('.btn-confirm').click(function(){
		$('#edit_purchase_order_form').submit();
	});
</script>