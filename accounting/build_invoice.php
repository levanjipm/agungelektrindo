<script src='../universal/Numeral-js-master/numeral.js'></script>
<style>
tr.border_bottom td{
	border-bottom:none;
}
</style>
<?php
	include('accountingheader.php');
	$do_name = $_POST['sj'];
	$inv_name_raw = substr($do_name,6);
	$inv_name = "FU-AE-" . $inv_name_raw;
	$sql_check = "SELECT COUNT(id) AS jumlah FROM code_delivery_order WHERE name = '" . $do_name . "' AND sent = '1' AND isinvoiced = '0'";
	$result_check = $conn->query($sql_check);
	$check = $result_check->fetch_assoc();
	if($check['jumlah'] == 0){
?>
		<script>
			history.back(1);
		</script>
<?php
	}
	$sql = "SELECT * FROM code_delivery_order WHERE name = '" . $do_name . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		$do_id = $row['id'];
		$so_id = $row['so_id'];
		$date = $row['date'];
		$customer = $row['customer_id'];
		$tax = $row['tax'];
	}
	$sql_customer = "SELECT * FROM customer WHERE id = '" . $customer . "'";
	$result_customer = $conn->query($sql_customer);
	while($row_customer = $result_customer->fetch_assoc()) {
		$name = $row_customer['name'];
		$address = $row_customer['address'];
		$city = $row_customer['city'];
	}
	//date name
	if (date('m',strtotime($date)) == 1){
		$month=" Januari ";
	} else if(date('m',strtotime($date)) == 2){
		$month=" Februari ";
	} else if(date('m',strtotime($date)) == 3){
		$month=" Maret ";
	} else if(date('m',strtotime($date)) == 4){
		$month=" April ";
	} else if(date('m',strtotime($date)) == 5){
		$month=" Mei ";		
	} else if(date('m',strtotime($date)) == 6){
		$month=" Juni ";
	} else if(date('m',strtotime($date)) == 6){
		$month=" Juli ";
	} else if(date('m',strtotime($date)) == 8){
		$month=" Agustus ";
	} else if(date('m',strtotime($date)) == 9){
		$month=" September ";
	} else if(date('m',strtotime($date)) == 10){
		$month=" Oktober ";
	} else if(date('m',strtotime($date)) == 11){
		$month=" November ";
	} else {
		$month=" Desember ";
	}		
?>
<div class="main">
	<div class="row" style="padding:0px">
		<div class="col-sm-12">
			<div class="row" style="padding:0px">
				<div class="col-sm-6 ">
				</div>
				<div class="col-sm-3 offset-sm-2">
					Bandung, <?=  date( "d", strtotime ( $date )) . $month . date("Y" , strtotime ( $date )); ?>
					<br><br><br><br>
					Kepada Yth.<br>
					<p><b><?= $name ?></b></p>
					<p><?= $address ?></p>
					<p><?= $city ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					Nomor invoice: <?= $inv_name ?>
				</div>
			</div>
			<br><br>
			<div class="row">
				<div class="col-sm-12">
					<form name="invoice" method="POST" action="build_invoice_input.php" id='invoices'>
					<input type='hidden' value='<?= $do_id ?>' name='do_id'>
						<table class="table">
							<thead>
								<tr>
									<th style="width:10%">Nomor</th>
									<th style="width:10%">Item reference</th>
									<th style="width:30%">Description</th>
									<th style="width:10%">Quantity</th>
									<th style="width:20%">Price</th>
									<th style="width:20%">Total Price</th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql_select = "SELECT * FROM delivery_order WHERE do_id = '" . $do_id . "'";
	$result_select = $conn->query($sql_select);
	$i = 1;
	$price_init = 0;
	while($rows = $result_select->fetch_assoc()) {
		$reference = $rows['reference'];
		$sql_item = "SELECT * FROM itemlist WHERE reference = '" . $reference . "'";
		$result_item = $conn->query($sql_item);
		if ($result_item->num_rows > 0){
			while($row_item = $result_item->fetch_assoc()) {
				$description = $row_item['description'];
			}
		} else {
			$description = '';
		};
		$sql_price = "SELECT price FROM sales_order WHERE reference = '" . $reference . "' AND so_id = '" . $so_id . "'";
		$result_price = $conn->query($sql_price);
		while($row_price = $result_price->fetch_assoc()) {
			$price = $row_price['price'];
		}
		$quantity = $rows['quantity'];
?>
								<tr class="border_bottom">
									<td><?= $i ?></td>
									<td><?= $reference ?></td>
									<td><?= $description ?></td>
									<td><?= $quantity ?></td>
				<?php
									if($tax == 1){
										$price = $price/1.1;
									} else{
										$price = $price;
				?>
				<?php
									}
				?>
									<td style='text-align:left'>Rp. <?= number_format($price,2) ?></td>
				<?php
									$total_price = $price * $quantity;
				?>
									<td style='text-align:left'>Rp. <?= number_format($total_price,2) ?></td>
								</tr>
<?php
	$price_init = $price_init + $total_price;
	$i++;
	}
?>
							</tbody>
							<tfoot>
<?php
								echo $tax;
								if($tax == 0){
?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>Sub Total</td>
									<td><input type="text" class="form-control" name="invoice_total" value="<?= $price_init ?>" readonly></td>
								</tr>
								<tr>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="background-color:#fff">Ongkos Kirim</td>
									<td style="background-color:#fff">
										<input type="text" class="form-control" name="ongkos_kirim" id='ongkir' value='0'>
									</td>									
								</tr>
								<tr>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="background-color:#fff">Total</td>
									<td style="background-color:#fff">
									<input type='text' id='invoice_totalis' class='form-control' readonly>
									<input type="hidden" class="form-control" name="invoice_total" id="invoice_total" readonly></td>									
								</tr>
<?php
								} else{
?>
								<tr>
									<td style="border:none;border-top:1px solid #ddd;background-color:#fff"></td>
									<td style="border:none;border-top:1px solid #ddd;background-color:#fff"></td>
									<td style="border:none;border-top:1px solid #ddd;background-color:#fff"></td>
									<td style="border:none;border-top:1px solid #ddd;background-color:#fff"></td>
									<td style="background-color:#fff">Sub Total</td>
									<td style="background-color:#fff;text-align:left">
										<input type='hidden' id="invoice_subtotal" name="invoice_subtotal" value="<?= $price_init/1.1 ?>" readonly>
										<?= 'Rp. ' . number_format($price_init,2)?>
									</td>
								</tr>
								<tr>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="background-color:#fff">PPN 10%</td>
									<td style="background-color:#fff;text-align:left">
										<input type="hidden" name="ppn"  id="ppn" value="<?= $price_init*1.1 - $price_init ?>" readonly>
										<?= 'Rp. ' . number_format(($price_init*1.1 - $price_init),2) ?>
									</td>
								</tr>
								<tr>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="background-color:#fff">Ongkos Kirim</td>
									<td style="background-color:#fff">
										<input type="text" class="form-control" name="ongkos_kirim" id='ongkir' value='0'>
									</td>									
								</tr>
								<tr>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="border:none;background-color:#fff"></td>
									<td style="background-color:#fff">Total</td>
									<td style="background-color:#fff">
									<input type='text' id='invoice_totalis' class='form-control' readonly>
									<input type="hidden" class="form-control" name="invoice_total" id="invoice_total" readonly></td>									
								</tr>
<?php
								}
?>		
						</table>
						<br>
						<br>
						<button type="button" class="btn btn-primary" onclick="calculate_form()" id='calculate'>Calculate</button>
						<button type='button' class='btn btn-warning' onclick='back_form()' style="display:none" id='back'>Back</button>
						<button type="button" class="btn btn-success" style="display:none" id='submit_form'>Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	if($tax == 1){
?>
<script>
	function calculate_form(){
		var subtotal = <?= $price_init*1.1 ?>;
		var ongkir = parseInt($('#ongkir').val());
		var total = Math.round(subtotal + ongkir,2);
		var subtotalis = subtotal + ongkir;
		$('#invoice_totalis').val(numeral(subtotalis).format('0,0.00'));
		$('#ongkir').attr('readonly', true);
		$('#invoice_total').val(total);
		$('#back').show();
		$('#submit_form').show();
		$('#calculate').hide();
	}
</script>
<?php
	} else {
?>
<script>
	function calculate_form(){
		var subtotal = <?= $price_init ?>;
		var ongkir = parseInt($('#ongkir').val());
		var total = Math.round(subtotal + ongkir,2);
		var subtotalis = subtotal + ongkir;
		$('#invoice_totalis').val(numeral(subtotalis).format('0,0.00'));
		$('#ongkir').attr('readonly', true);
		$('#invoice_total').val(total);
		$('#back').show();
		$('#submit_form').show();
		$('#calculate').hide();
	}
</script>
<?php
	}
?>
<script>
	$('#submit_form').click(function(){
		$('#invoices').submit();
	});
	function back_form(){
		$('#ongkir').attr('readonly', false);
		$('#back').hide();
		$('#submit_form').hide();
		$('#calculate').show();
	}
</script>