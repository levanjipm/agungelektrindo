<?php
	include("inventoryheader.php")
?>
<div class="main">
<?php
	$so_name = $_POST['so_id'];
	$sql = "SELECT * FROM code_salesorder WHERE name = '" . $so_name . "'";
	$result = $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
		<script>
			window.history.back();
		</script>
<?php
	} else {
	while($row = $result->fetch_assoc()){
		$so_id = $row['id'];
		$po_number = $row['po_number'];
		$taxing = $row['taxing'];
		$customer_id = $row['customer_id'];
		$delivery_id = $row['delivery_id'];
	}
	$sql_customer = "SELECT * FROM customer WHERE id = '" . $customer_id . "'";
	$res = $conn->query($sql_customer);
	while($ro = $res->fetch_assoc()){
		$customer_name = $ro['name'];
	}	
?>
	<div class="container">	
		<form method="POST" action="do_validation.php" id="do_validate">
			<div class="row">
				<div class="col-lg-4">
					<p><b>Purchase order number :</b><?= $po_number ?></p>
					<input type="hidden" value="<?= $po_number ?>" class="form-control">
				</div>
				<div class="col-lg-3 offset-lg-5">
					<label>Date:</label>
					<input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" name="today">
					<label>Customer:</label>
					<input type="text" value="<?= $customer_name ?>" class="form-control" readonly>
				</div>
			</div>
			<br><br>
			<div class="row">
				<div class="col-lg-8">

				</div>
			</div>
			<br>
			<hr>
			<table class="table">
				<thead>
					<tr>
						<th style="width:40%">Item</th>
						<th style="width:20%">Sent item</th>
						<th style="width:20%">Quantity ordered</th>
						<th style="width:20%">Quantity to be sent</th>
						<th>Stock</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$total_qty = 0;
					$i = 1;
					$sql_so = "SELECT * FROM sales_order WHERE so_id = '" . $so_id . "'";
					$r = $conn->query($sql_so);
					while($rows = $r->fetch_assoc()){
						$ref = $rows['reference'];
						$qty = $rows['quantity'];
						$sql_sent = "SELECT * FROM sales_order_sent WHERE so_id = '" . $so_id . "' AND reference = '" . $ref . "' LIMIT 1";
						$results = $conn->query($sql_sent);
						while($row_sent = $results->fetch_assoc()){
							$sent_qty = $row_sent['quantity'];
						}
						$max_qty = $qty - $sent_qty;
						if ($sent_qty == $qty){
						} else{
				?>
					<tr>
						<td>
							<?= $ref ?>
							<input type='hidden' value="<?= $ref ?>" name="ref<?= $i ?>" readonly tabindex="-1">
						</td>
						<td>
							<?= $sent_qty ?>
							<input type='hidden' value="<?= $sent_qty?>" id="sent<?= $i ?>" readonly tabindex="-1">
						</td>
						<td>
							<?= $qty ?>
							<input type='hidden' value="<?= $qty ?>" id="qty<?= $i ?>" readonly tabindex="-1">
						</td>
						<td><input class="form-control" type="number" id = "qty_send<?= $i ?>" name="qty_send<?= $i ?>" min="0">
						</td>
						<td><?php
							$sql_stock = "SELECT stock FROM stock WHERE reference = '" . $ref . "' ORDER BY id DESC";
							$result_stock = $conn->query($sql_stock);
							$stock = $result_stock->fetch_assoc();
							echo $stock['stock'];
						?></td>
					</tr>
				<?php
					$maximum[$i] = $max_qty;
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
			<br>
			<div class="row">
				<div class="col-lg-3 offset-lg-9">
					<button type="button" class="btn btn-info" onclick="lihat()">Proceed</button>
				</div>
			</div>
		</form>
	</div>
	<script>
	function lihat(){
		var z = 1;
		var y = 0;
		for (z = 1; z < $('#jumlah').val(); z++){
			if($('#qty_send' + z).val() == ''){
				$('#qty_send' + z).val(0);
			}
			var jumlah_kirim = parseInt($('#qty_send' + z).val(),10);
			var maximum = <?= json_encode($maximum) ?>;
			//yang mau dikirim + udah dikirim//
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