<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/head.php');
	include('../codes/connect.php');
	$id 					= $_POST['id'];
	
	$sql_invoice			= "SELECT code_delivery_order.id as do_id, invoices.down_payment, invoices.faktur,invoices.value,invoices.ongkir,invoices.name,invoices.date, code_delivery_order.customer_id, code_salesorder.id as sales_order_id
								FROM invoices 
								JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
								JOIN code_salesorder ON code_salesorder.id = code_delivery_order.so_id
								WHERE invoices.id = '" . $id . "'";
	$result_invoice			= $conn->query($sql_invoice);
	$invoice				= $result_invoice->fetch_assoc();
			
	$ongkir 				= $invoice['ongkir'];
	$value 					= $invoice['value'];
	$name 					= $invoice['name'];
	$date 					= $invoice['date'];
	$customer_id 			= $invoice['customer_id'];
	$faktur 				= $invoice['faktur'];
	$sales_order_id			= $invoice['sales_order_id'];
	$delivery_order_id		= $invoice['do_id'];
	$down_payment			= $invoice['down_payment'];
	
	$do_name = 'SJ-AE-' . substr($name,6,100);
	if($customer_id != 0){
		$sql_customer 		= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
		$result_customer 	= $conn->query($sql_customer);
		$row_customer 		= $result_customer->fetch_assoc();
		
		$customer_name 		= $row_customer['name'];
		$customer_address 	= $row_customer['address'];
		$customer_city 		= $row_customer['city'];
	} else {
		$sql_customer_so	= "SELECT retail_name, retail_address, retail_city FROM code_salesorder WHERE id = '$sales_order_id'";
		$result_customer_so	= $conn->query($sql_customer_so);
		$customer_so		= $result_customer_so->fetch_assoc();
		
		$customer_name 		= $customer_so['retail_name'];
		$customer_address 	= $customer_so['retail_address'];
		$customer_city 		= $customer_so['retail_city'];
	}
	
	$sql_do 		= "SELECT code_salesorder.po_number, code_salesorder.taxing
						FROM code_delivery_order 
						JOIN code_salesorder ON code_salesorder.id = code_delivery_order.so_id
						WHERE code_delivery_order.id = '$delivery_order_id'";
	$result_do 		= $conn->query($sql_do);
	$row_do 		= $result_do->fetch_assoc();
	$taxing 		= $row_do['taxing'];
	$po_number 		= $row_do['po_number'];
?>
<head>
	<title><?= $name . ' ' . $customer_name ?></title>
</head>
<style>
	.table-bordered th{
		background-color:white!important;
		color:black;
	}
	*{
		font-size:1.06em;
	}
</style>
<div class='row' style='background-color:#eee;width:100%;margin:0'>
	<div class='col-sm-10 col-sm-offset-1' style='padding:50px;background-color:white;' id='printable'>
		<div class='row'>
			<div class='col-sm-7'>
				<img src='../universal/images/Logo Agung.jpg' style='width:100%'>
				<p><strong>Nomor invoice:</strong> <?= $name ?></p>
				<p><strong>Nomor PO: </strong><?= $po_number ?></p>
			</div>
			<div class='col-sm-4 col-sm-offset-1'>
				<p>Tanggal: <?= date('d M Y',strtotime($date)) ?></p>
				<p>Kepada Yth.</p>
				<p><strong><?= $customer_name ?></strong></p>
				<p><?= $customer_address ?></p>
				<p><?= $customer_city ?></p>
			</div>
		</div>
		<br><br>
		<table class='table table-bordered' style='text-align:center;'>
			<tr>
				<th style='text-align:center;width:5%'>No.</th>
				<th style='text-align:center;width:30%'>Barang</th>
				<th style='text-align:center;width:15%'>Jumlah</th>
				<th style='text-align:center;width:25%'>Harga satuan</th>
				<th style='text-align:center;width:25%'>Harga</th>
			</tr>
<?php
		$i = 1;
		$sql_count 		= "SELECT COUNT(*) AS counter FROM delivery_order WHERE do_id = '$delivery_order_id'";
		$result_count 	= $conn->query($sql_count);
		$row_count 		= $result_count->fetch_assoc();
		$counting 		= $row_count['counter'];
		$max = ($counting <= 10)? 10: $counting;
		$value = 0;
			for($i = 1; $i <= $max; $i++){
				$sql_table 		= "SELECT delivery_order.quantity, delivery_order.reference, itemlist.description, delivery_order.billed_price
									FROM delivery_order 
									JOIN itemlist ON delivery_order.reference = itemlist.reference
									WHERE do_id = '$delivery_order_id' LIMIT 1 OFFSET " . ($i - 1);
				$result_table 	= $conn->query($sql_table);
				$row_table 		= $result_table->fetch_assoc();
				if(empty($row_table['reference'])){
?>
			<tr style='height:40px'>
				<td></td><td></td><td></td><td></td><td></td></tr>
<?php
			} else {
				$reference		= $row_table['reference'];
				$description	= $row_table['description'];
				$price			= $row_table['billed_price'];
				$quantity		= $row_table['quantity'];
?>
			<tr style='height:40px'>
				<td><?= $i . '.' ?></td>
				<td><?= $description . ' - ' . $reference ?></td>
				<td><?= $quantity ?></td>
				<td><?php
					if($taxing == 1){
						echo ('Rp. ' . number_format($price * 10 /11,2));
					} else {
						echo ('Rp. ' . number_format($price,2));
					}
				?></td>
				<td><?php
					if($taxing == 1){
						echo('Rp. ' . number_format($price * $quantity * 10/11,2));
					} else {
						echo('Rp. ' . number_format($price * $quantity,2));
					}
				?></td>
			</tr>
		<?php 
			$value += $price * $quantity;
			}
		}
		if($taxing == 1){ 
		?>
			<tr>
				<td style='background-color:white;border-bottom:none;' colspan='3'></td>
				<td>Subtotal</td>
				<td><?= 'Rp. ' . number_format($value*10/11,2) ?></td>
			</tr>
			<tr>
				<td style='background-color:white;border-bottom:none;' colspan='3'></td>
				<td>PPn 10%</td>
				<td><?= 'Rp. ' . number_format($value - $value*10/11,2) ?></td>
			</tr>
<?php
			if($down_payment > 0){
?>
			<tr>
				<td style='background-color:white;border-bottom:none;' colspan='3'></td>
				<td>Down payment</td>
				<td><?= 'Rp. ' . number_format($down_payment,2) ?></td>
			</tr>
			<tr>
				<td style='background-color:white;border-bottom:none;' colspan='3'></td>
				<td>Total</td>
				<td><?= 'Rp. ' . number_format($value - $down_payment,2) ?></td>
			</tr>
<?php
			} else {
?>
			<tr>
				<td style='background-color:white;border-bottom:none;' colspan='3'></td>
				<td>Total</td>
				<td><?= 'Rp. ' . number_format($value,2) ?></td>
			</tr>
<?php
			}
?>
		<?php } else { ?>
			<tr>
				<td style='background-color:white;border-bottom:none;' colspan='3'></td>
				<td>Total</td>
				<td><?= 'Rp. ' . number_format($value,2) ?></td>
			</tr>
		<?php } ?>
		<?php
			if($ongkir == ''|| $ongkir == NULL || $ongkir == 0){
			} else {
		?>
			<tr>
				<td style='background-color:white;border-bottom:none;' colspan='3'></td>
				<td>Ongkos Kirim</td>
				<td><?= 'Rp. ' . number_format($ongkir,2) ?></td>
			</tr>
<?php
			}
?>
			<tr>
				<td style='background-color:white;border-bottom:none;' colspan='3'></td>
				<td>Down payment</td>
				<td><?= 'Rp. ' . number_format($down_payment,2) ?></td>
			</tr>
			<tr>
				<td style='background-color:white;border-bottom:none;' colspan='3'></td>
				<td>Grand Total</td>
				<td><?= 'Rp. ' . number_format($value - $down_payment + $ongkir,2) ?></td>
			</tr>
		</table>
		<br><br><br>
		<div class='row'>
			<div class='col-sm-3 col-sm-offset-9' style='margin-bottom:150px;margin-right:30px;'>
				<p style='text-align:center'>Hormat kami,</p>
				<?php
					if($taxing == 1){
				?>
				<div style='border:1px solid #ddd;width:130px;height:80px;position:absolute;right:80px;'>
				</div>
				<?php
					}
				?>
			</div>
		</div>
		<div class='row'>
			<div class='col-xs-6'>
				<p><strong>Keterangan</strong></p>
				<ol>
					<li>
						<p style='line-height:1;font-size:1em'>Pembayaran dilakukan melalui rekening</p>
						<p style='line-height:1;font-size:1em'>BCA Cabang Ahmad Yani II - Bandung</p>
						<p style='line-height:1;font-size:1em'>A/N: CV Agung Elektrindo</p>
						<p style='line-height:1;font-size:1em'>AC No.:8090249500</p>
					</li>
					<li>
						<p style='line-height:1.3;font-size:1em'>Pembayaran dengan menggunakan giro atau cek dianggap sah setelah diuangkan</p>
					</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="row" style="background-color:#424242;padding:30px;margin:0;width:100%">
	<div class="col-sm-2 offset-sm-5">
		<button class="button_success_dark hidden-print" type="button" id="print" onclick="printing()"><i class='fa fa-print'></i></button>
	</div>
</div>
<script>
function printing(){
	var printContents = document.getElementById('printable').innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;
}
</script>
	