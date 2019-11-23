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
	$sql = "SELECT id,so_id,date,customer_id,tax FROM code_delivery_order WHERE name = '" . $do_name . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$do_id = $row['id'];
	$so_id = $row['so_id'];
	$date = $row['date'];
	$customer = $row['customer_id'];
	$tax = $row['tax'];
	
	if($customer != 0){
		$sql_customer 			= "SELECT id,name,address,city FROM customer WHERE id = '" . $customer . "'";
		$result_customer 		= $conn->query($sql_customer);
		$row_customer 			= $result_customer->fetch_assoc();
		
		$name 					= $row_customer['name'];
		$address 				= $row_customer['address'];
		$city 					= $row_customer['city'];
	} else {
		$sql 					= "SELECT code_salesorder.retail_name, code_salesorder.retail_address, code_salesorder.retail_city
								FROM code_salesorder
								JOIN code_delivery_order ON code_delivery_order.so_id = code_salesorder.id
								WHERE code_delivery_order.id = '" . $do_id . "'";
		$result 				= $conn->query($sql);
		$row 					= $result->fetch_assoc();
				
		$name 					= $row['retail_name'];
		$address 				= $row['retail_address'];
		$city 					= $row['retail_city'];
	}	
?>
<div class="main">
	<div class="row" style="padding:0px">
		<div class="col-xs-12">
			<h2 style='font-family:bebasneue'>Sales Invoice</h2>
			<p>Create sales invoice</p>
			<hr>
		</div>
	</div>
	<div class='row'>
		<div class='col-xs-9'>
			Bandung, <?=  date('d M Y',strtotime($date)) ?>
			<br><br>
			Kepada Yth.<br>
			<p><b><?= $name ?></b></p>
			<p><?= $address ?></p>
			<p><?= $city ?></p>
			<p><b>Nomor invoice:</b> <?= $inv_name ?></p>
		</div>
		<div class='col-xs-3'>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<form name="invoice" method="POST" action="build_invoice_input" id='invoices'>
			<input type='hidden' value='<?= $do_id ?>' name='do_id'>
				<table class="table">
					<thead>
						<tr>
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
		$reference 			= $rows['reference'];
		$sql_item 			= "SELECT * FROM itemlist WHERE reference = '" . $reference . "'";
		$result_item 		= $conn->query($sql_item);
		if ($result_item->num_rows > 0){
			$row_item 		= $result_item->fetch_assoc();
			$description 	= $row_item['description'];
		} else {
			$description = '';
		};
		
		$price 				= $rows['billed_price'];
		$quantity 			= $rows['quantity'];
?>
						<tr class="border_bottom">
							<td><?= $reference ?></td>
							<td><?= $description ?></td>
							<td><?= $quantity ?></td>
<?php
		if($tax == 1){
			$price = $price/1.1;
		} else{
			$price = $price;
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
	if($tax != 1){
?>
						<tr>
							<td style="border:none;background-color:#fff" colspan='3'></td>
							<td>Sub Total</td>
							<td><input type="text" class="form-control" name="invoice_total" value="<?= $price_init ?>" readonly></td>
						</tr>
						<tr>
							<td style="border:none;background-color:#fff" colspan='3'></td>
							<td style="background-color:#fff">Ongkos Kirim</td>
							<td style="background-color:#fff">
								<input type="text" class="form-control" name="ongkos_kirim" id='ongkir' value='0'>
							</td>									
						</tr>
						<tr>
							<td style="border:none;background-color:#fff" colspan='3'></td>
							<td style="background-color:#fff">Total</td>
							<td style="background-color:#fff">
							<input type='text' id='invoice_totalis' class='form-control' readonly>
							<input type="hidden" class="form-control" id="invoice_total" readonly></td>									
						</tr>
<?php
	} else{
?>
						<tr>
							<td style="border:none;background-color:#fff" colspan='3'></td>
							<td style="background-color:#fff">Sub Total</td>
							<td style="background-color:#fff;text-align:left">
								<input type='hidden' id="invoice_subtotal" name="invoice_subtotal" value="<?= $price_init/1.1 ?>" readonly>
								<?= 'Rp. ' . number_format($price_init,2)?>
							</td>
						</tr>
						<tr>
							<td style="border:none;background-color:#fff" colspan='3'></td>
							<td style="background-color:#fff">PPN 10%</td>
							<td style="background-color:#fff;text-align:left">
								<input type="hidden" name="ppn"  id="ppn" value="<?= $price_init*1.1 - $price_init ?>" readonly>
								<?= 'Rp. ' . number_format(($price_init*1.1 - $price_init),2) ?>
							</td>
						</tr>
						<tr>
							<td style="border:none;background-color:#fff" colspan='3'></td>
							<td style="background-color:#fff">Ongkos Kirim</td>
							<td style="background-color:#fff">
								<input type="text" class="form-control" name="ongkos_kirim" id='ongkir' value='0'>
							</td>									
						</tr>
						<tr>
							<td style="border:none;background-color:#fff" colspan='3'></td>
							<td style="background-color:#fff">Total</td>
							<td style="background-color:#fff">
							<input type='text' id='invoice_totalis' class='form-control' readonly>
							<input type="hidden" class="form-control" name="invoice_total" id="invoice_total" readonly></td>									
						</tr>
<?php
	}
?>		
					</tfoot>
				</table>
				<br>
				<br>
				<button type="button" class="button_default_dark" onclick="calculate_form()" id='calculate'>Calculate</button>
				<button type='button' class='button_warning_dark' onclick='back_form()' style="display:none" id='back'>Back</button>
				<button type="button" class="button_success_dark" style="display:none" id='submit_form'>Submit</button>
			</form>
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