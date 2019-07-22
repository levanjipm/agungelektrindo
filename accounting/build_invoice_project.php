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
	
	$sql_check = "SELECT COUNT(id) AS jumlah, project_id FROM code_delivery_order WHERE name = '" . $do_name . "' AND sent = '1' AND isinvoiced = '0'";
	$result_check = $conn->query($sql_check);
	$check = $result_check->fetch_assoc();
	if($check['jumlah'] == 0){
?>
		<script>
			history.back(1);
		</script>
<?php
	}
	$project_id = $check['project_id'];
	
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
					<form name="invoice" method="POST" action="build_invoice_project_input.php" id='invoices'>
					<input type='hidden' value='<?= $do_id ?>' name='do_id'>
						<table class="table">
							<thead>
								<tr>
									<th style="width:10%">Nomor</th>
									<th style="width:30%">Description</th>
									<th style="width:20%">Price</th>
									<th style="width:20%">Total Price</th>
								</tr>
							</thead>
							<tbody>
<?php
	$number_helper = 1;
	$sql_select = "SELECT project_name, price, taxing, description
	FROM code_project 
	WHERE id = '" . $project_id . "'";
	$result_select = $conn->query($sql_select);
	while($select = $result_select->fetch_assoc()) {
?>
								<tr class="border_bottom">
									<td><?= $number_helper ?></td>
									<td><?= $select['project_name'] . ' - ' . $select['description'] ?></td>
									<td style='text-align:left'><input type='number' class='form-control' name='price' id='price'></td>
								</tr>
<?php
	$number_helper++;
	}
?>
							</tbody>
							<tfoot>
								<tr>
									<td style="border:none;background-color:#fff" colspan='2'></td>
									<td style="background-color:#fff">Sub Total</td>
									<td style="background-color:#fff;text-align:left">
										<input type='hidden' id="invoice_subtotal" readonly>
									</td>
								</tr>
								<tr>
									<td style="border:none;background-color:#fff" colspan='2'></td>
									<td style="background-color:#fff">Delivery Fee</td>
									<td style="background-color:#fff;text-align:left">
										<input type="number" class='form-control' name="delivery_fee"  id="delivery_fee">
									</td>
								</tr>
								<tr>
									<td style="border:none;background-color:#fff" colspan='2'></td>
									<td style="background-color:#fff">Total</td>
									<td style="background-color:#fff">
									<input type='text' id='invoice_totalis' class='form-control' readonly>
									<input type="hidden" class="form-control" name="invoice_total" id="invoice_total" readonly></td>									
								</tr>
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
		if($('#price').val() == '' || $('#price').val() == 0){
			alert('Cannot input 0 value');
			$('#price').focus();
			return false;
		} else {
			$('#invoices').submit();
		}
	});
</script>