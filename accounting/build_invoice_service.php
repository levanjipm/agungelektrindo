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
	$row = $result->fetch_assoc();
	
	$do_id = $row['id'];
	$so_id = $row['so_id'];
	$date = $row['date'];
	$customer = $row['customer_id'];
	$tax = $row['tax'];
	
	$sql_customer = "SELECT id,name,address,city FROM customer WHERE id = '" . $customer . "'";
	$result_customer = $conn->query($sql_customer);
	$row_customer = $result_customer->fetch_assoc();
	$name = $row_customer['name'];
	$address = $row_customer['address'];
	$city = $row_customer['city'];
	
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
					<form name="invoice" method="POST" action="build_invoice_service_input.php" id='invoices'>
					<input type='hidden' value='<?= $do_id ?>' name='do_id'>
						<table class="table">
							<thead>
								<tr>
									<th style="width:10%">Nomor</th>
									<th style="width:30%">Description</th>
									<th style="width:10%">Quantity</th>
									<th style="width:20%">Price</th>
									<th style="width:20%">Total Price</th>
								</tr>
							</thead>
							<tbody>
<?php
	$value = 0;
	$number_helper = 1;
	$sql_select = "SELECT service_sales_order.description, service_delivery_order.service_sales_order_id, service_delivery_order.quantity, service_sales_order.unitprice
	FROM service_delivery_order 
	JOIN service_sales_order ON service_sales_order.id = service_delivery_order.service_sales_order_id
	WHERE service_delivery_order.do_id = '" . $do_id . "'";
	$result_select = $conn->query($sql_select);
	while($select = $result_select->fetch_assoc()) {
?>
								<tr class="border_bottom">
									<td><?= $number_helper ?></td>
									<td><?= $select['description'] ?></td>
									<td><?= $select['quantity'] ?></td>
				<?php
									if($tax == 1){
										$price = $select['unitprice']/1.1;
									} else{
										$price = $select['unitprice'];
				?>
				<?php
									}
				?>
									<td style='text-align:left'>Rp. <?= number_format($price,2) ?></td>
				<?php
									$total_price = $price * $select['quantity'];
				?>
									<td style='text-align:left'>Rp. <?= number_format($total_price,2) ?></td>
								</tr>
<?php
	$value += $total_price;
	$number_helper++;
	}
?>
							</tbody>
							<tfoot>
<?php
								if($tax == 0){
?>
								<tr>
									<td style="border:none;background-color:#fff" colspan='3'></td>
									<td style="background-color:#fff">Total</td>
									<td style="background-color:#fff;text-align:left">
										Rp. <?= number_format($value,2) ?>
									<input type="hidden" class="form-control" name="invoice_total" id="invoice_total" readonly></td>									
								</tr>
<?php
								} else{
?>
								<tr>
									<td style="border:none;background-color:#fff" colspan='3'></td>
									<td style="background-color:#fff">Sub Total</td>
									<td style="background-color:#fff;text-align:left">
										<input type='hidden' id="invoice_subtotal" name="invoice_subtotal" value="<?= $value/1.1 ?>" readonly>
										<?= 'Rp. ' . number_format($value,2)?>
									</td>
								</tr>
								<tr>
									<td style="border:none;background-color:#fff" colspan='3'></td>
									<td style="background-color:#fff">PPN 10%</td>
									<td style="background-color:#fff;text-align:left">
										<input type="hidden" name="ppn"  id="ppn" value="<?= $value*1.1 - $value ?>" readonly>
										<?= 'Rp. ' . number_format(($value*1.1 - $value),2) ?>
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
						</table>
						<br>
						<br>
						<button type="button" class="btn btn-success" id='submit_form'>Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
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