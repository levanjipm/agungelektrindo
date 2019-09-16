<?php
	include('purchasingheader.php');
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
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>

<div class="main">
	<div class='row'>
		<div class='col-sm-12'>
			<h2 style='font-family:bebasneue'>Purchase order</h2>
			<p>Edit purchase order</p>
			<hr>
			<form action="editpurchaseorder.php" method="POST" id='edit_po'>
				<label>Order to</label>
				<p><?php
				$sql_supplier 		= "SELECT name FROM supplier WHERE id = '" . $supplier_id . "'";
				$result_supplier 	= $conn->query($sql_supplier);
				$supplier 			= $result_supplier->fetch_assoc();
				echo $supplier['name'];
				?></p>
				<label>Promo Code</label>
				<input type="text" class="form-control" value="<?= $promo_code?>" name="promo_code" style='width:50%'>
				<label>Taxing option</label>
				<select class="form-control" name="taxing" style='width:50%'>
<?php
			if($tax == 0){
?>
						<option value='2'>Non Tax</option>
						<option value='1'>Tax</option>
<?php
			} else{
?>
						<option value='1'>Tax</option>
						<option value='2'>Non tax</option>
<?php
			}
?>
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
							<td><input type='text' value="<?= $row['reference'] ?>" 	class="form-control" id='reference<?= $row['id'] ?>' 	name='ref<?= $row['id'] ?>'></td>
							<td><input type="text" value="<?= $row['price_list'] ?>" 	class='form-control' id="pl<?= $row['id']?>" 			name="pl<?= $row['id']?>"></td>
							<td><input type="text" value="<?= $row['discount'] ?>" 		class="form-control" id="discount<?= $row['id'] ?>" 	name="discount<?= $row['id'] ?>"	min='0' max='100'></td>
							<td><input type="text" value="<?= $row['unitprice'] ?>" 	class="form-control" id="unitprice<?= $row['id']?>" 	name="unitprice<?= $row['id']?>"	readonly ></td>
							<td><input type="text" value="<?= $row['quantity'] ?>" 		class="form-control" id="qty<?= $row['id'] ?>" 			name="qty<?= $row['id'] ?>" 		min='<?= $min_val ?>' ></td>
							<td><?= number_format($quantity_received,0) ?></td>
							<td><?= number_format($total_price,2) ?></td>
							<td><button type="button" class="button_danger_dark" onclick="delete_item(<?= $row['id'] ?>)">&times</button></td>
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
<script>
	var a = 1;
	
	function delete_item(n){
		$('#tr' + n).remove();
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
		var duplicate=false;
		$('input[id^=ref]').each(function(){
			var $this = $(this);
			if ($this.val()===''){ return;}
			$('input[id^=ref]').not($this).each(function(){
				if ( $(this).val()==$this.val()) {duplicate=true;}
			});
		});
		if(duplicate){
			alert('Reference must be unique!');
			return false;
		} else {
			$('#jumlah_barang').val(i);
			$('#pin_wrapper').fadeIn();
			$('.btn-danger').each(function(){
				$(this).hide();
			});
		}
	}			
</script>