<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Delivery Order</h2>
	<p style='font-family:museo'>Create new delivery order</p>
	<hr>
<?php
	$so_id 		= $_POST['id'];
	$sql 		= "SELECT * FROM code_salesorder WHERE id = '" . $so_id . "'";
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
			
		$sql_customer 		= "SELECT name,address,city FROM customer WHERE id = '" . $customer_id . "'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
?>
		<form method="POST" action="delivery_order_create_validation" id="do_validate">
			<label>Date:</label>
			<input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" name="today">
			
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
					$i = 1;
					$sql_so 		= "SELECT * FROM sales_order WHERE so_id = '" . $so_id . "'";
					$result_so 		= $conn->query($sql_so);
					while($sales_order = $result_so->fetch_assoc()){
						$id					= $sales_order['id'];
						$reference 			= mysqli_real_escape_string($conn,$sales_order['reference']);
						$quantity			= $sales_order['quantity'];
						$sent_quantity		= $sales_order['sent_quantity'];
						$price				= $sales_order['price'];
						
						$maximum_quantity 	= $quantity - $sent_quantity;
						if ($sent_quantity != $quantity){
				?>
					<tr>
						<td>
							<?= $reference ?>
							<input type='hidden' value="<?= $reference ?>" name="reference[<?= $id ?>]" readonly tabindex="-1">
							<input type='hidden' value='<?= $price ?>' name='price[<?= $id ?>]' readonly>
						</td>
						<td>
							<?= $sent_quantity ?>
							<input type='hidden' value="<?= $sent_quantity ?>" id="sent<?= $i ?>" readonly tabindex="-1">
						</td>
						<td>
							<?= $quantity ?>
							<input type='hidden' value="<?= $quantity ?>" id="qty<?= $i ?>" readonly tabindex="-1">
						</td>
						<td>
							<input class="form-control" type="number" id = "qty_send<?= $i ?>" name="quantity[<?= $id ?>]" min="0">
						</td>
						<td><?php
							$sql_stock 			= "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC";
							$result_stock 		= $conn->query($sql_stock);
							$stock 				= $result_stock->fetch_assoc();
							if($stock == NULL || $stock == 0){
								echo ('0');
							} else {
								echo $stock['stock'];
							}
						?></td>
					</tr>
				<?php
					$maximum[$i] = $maximum_quantity;
					$i++;
						}
					}
				?>
				</tbody>
			</table>
			<input type="hidden" name="tax" value="<?= $taxing ?>">
			<input type="hidden" name="id" value="<?= $so_id ?>">
			<input type="hidden" name="customer_id" value="<?= $customer_id ?>">
			<input type="hidden" name="jumlah" value="<?= $i ?>" id='jumlah'>
			<button type='button' class='button_success_dark' id='complete_delivery_button'>Complete delivery</button>
			<button type="button" class="button_default_dark" onclick="lihat()">Proceed</button>
		</form>
	</div>
	<script>
	$('#complete_delivery_button').click(function(){
		$('input[id^="qty_send"]').each(function(){
			var quantity = $(this).parent().siblings().find('input[id^="qty"]').val();
			var sent = $(this).parent().siblings().find('input[id^="sent"]').val();
			var isi = quantity - sent;
			$(this).val(isi);
		})
	});
	function lihat(){
		var z = 1;
		var y = 0;
		for (z = 1; z < $('#jumlah').val(); z++){
			if($('#qty_send' + z).val() == ''){
				$('#qty_send' + z).val(0);
			}
			var jumlah_kirim = parseInt($('#qty_send' + z).val(),10);
			var maximum = <?= json_encode($maximum) ?>;
			if(jumlah_kirim > maximum[z]){
				alert('Cannot exceed the order');
				y ++;
				return false;
			}
		}
		if(y == 0){
			var jumlah_barang = 0;
			$('input[id^=qty_send]').each(function(){
				jumlah_barang = jumlah_barang + $(this).val();
			});
			if (jumlah_barang > 0){
			$("#do_validate").submit();
			} else{
			alert('insert correct quantity')
			}
		} else {
			alert('error');
		}
	}
	
	</script>
<?php
	}
?>	