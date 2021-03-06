<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/head.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	$q_id 					= $_POST['id'];
	
	$sql 					= "SELECT * FROM code_quotation WHERE id = '" . $q_id . "'";
	$result 				= $conn->query($sql);
	$row 					= $result->fetch_assoc();
				
	$q_name 				= $row['name'];
	$customer 				= $row['customer_id'];
	$q_date 				= $row['date'];
	$additional_discount 	= $row['additional_discount'];
	$payment_id 			= $row['payment_id'];
	$dp 					= $row['down_payment'];
	$lunas 					= $row['repayment'];
	$note 					= $row['note'];
	
	$sql_customer 			= "SELECT * FROM customer WHERE id = '" . $customer . "'";
	$result 				= $conn->query($sql_customer);
	$row 					= $result->fetch_assoc();
	
	$customer_name 			= $row['name'];
	$customer_address 		= $row['address'];
	$customer_city 			= $row['city'];
	$customer_phone 		= $row['phone'];
	$customer_pic_prefix 	= $row['prefix'];
	$customer_pic 			= $row['pic'];
?>
<head>
	<title><?= strtoupper($q_name . " " .$customer_name) ?></title>
</head>
<body>
	<div class="row" style='margin:0'>
		<div class="col-sm-2" style="background-color:#eee">
		</div>
		<div class="col-sm-8" id="printable">
			<div class="row">
				<div class="col-sm-8 offset-sm-2">
					<img src="/agungelektrindo/universal/images/Logo Agung.jpg" style="width:100%"></img>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 offset-sm-3">
					<h2 style="text-align:center"><b>Quotation</b></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 offset-sm-3">
					<h4 style="text-align:center"><?= $q_name?></h4>
				</div>
			</div>
			<br><br><br>
			<div class="row">
				<div class="col-sm-5">
					<p>Kepada Yth. <b><?= $customer_name?></b></p>
					<p><?= $customer_address?></p>
					<p><?= $customer_city?></p>
					<p><?= $customer_phone?></p>
					<p>Untuk perhatian:<?php echo($customer_pic_prefix . ' ' . $customer_pic) ?>
				</div>
			</div>
			<br><br><br>
			<table class="table" style='background-color:white!important'>
				<thead>	
					<th style='width:20%;text-align:center;background-color:#fff!important;color:#000!important'>Item Description</th>
					<th style='width:20%;text-align:center;background-color:#fff!important;color:#000!important'>Reference</th>
					<th style='width:20%;text-align:center;background-color:#fff!important;color:#000!important'>Unit price</th>
					<th style='width:20%;text-align:center;background-color:#fff!important;color:#000!important'>Quantity</th>
					<th style='width:30%;text-align:center;background-color:#fff!important;color:#000!important'>Total price</th>
				</thead>
				<tbody>
				<?php 
					$sql_item = "SELECT * FROM quotation WHERE quotation_code = '" . $q_id . "'";
					$result = $conn->query($sql_item);
					$i = 0;
					$total = 0;
					while($row = $result->fetch_assoc()){
						$ref[$i] = $row['reference'];;
						$net_price[$i] = $row['net_price'];
						$quantity[$i] = $row['quantity'];
						$total_price[$i] = $row['quantity'] * $row['net_price'];
						
						$sql_desc = "SELECT description FROM itemlist WHERE reference = '" . $ref[$i] . "'";
						$r = $conn->query($sql_desc);
						$row = $r->fetch_assoc();
						$desc = $row['description'];
						?>
						<tr>
							<td style="text-align:center"><?php if(isset($desc)) echo $desc ?></td>
							<td style="text-align:center"><?= $ref[$i] ?></td>
							<td style="text-align:center">Rp. <?= number_format($net_price[$i],2) ?></td>
							<td style="text-align:center"><?= $quantity[$i] ?></td>
							<td style="text-align:center">Rp. <?= number_format($total_price[$i],2) ?></td>
						</tr>
						<?php
						$total = $total + $total_price[$i];
						$i++;
					}
				?>	
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td><b>Total</b></td>
						<td style="text-align:center">Rp.<?= number_format($total,2) ?></td>
					</tr>
<?php
	if($additional_discount > 0){
?>
					<tr>
						<td style="border:none"></td>
						<td style="border:none"></td>
						<td style="border:none"></td>
						<td>Add. Discount</td>
						<td style="text-align:center">Rp.<?= number_format($additional_discount,2) ?></td>
					</tr>
					<tr>
						<td style="border:none"></td>
						<td style="border:none"></td>
						<td style="border:none"></td>
						<td>Grand Total</td>
						<td style="text-align:center">Rp.<?= number_format($total - $additional_discount,2) ?></td>
					</tr>
<?php
	}
?>	
				</tfoot>
			</table>
			<div class="row">
				<div class="col-sm-12">
					<h4>Keterangan</h4>
					<p><b>1. </b>
					<?php
						if($payment_id == 1){
							echo ('Pembayaran dilakukan sebelum pengiriman barang');
						} else if($payment_id == 2){
							echo ('Cek atau giro dengan tanggal pencairan ' . $lunas . 'hari setelah tanggal pengiriman barang.');
						} else if($payment_id == 3){
							echo ('Pembayaran dilakukan ' . $lunas . ' hari setelah tanggal pengiriman barang.');
						} else {
							echo ('Uang muka sebesar ' . $dp . '% dan pelunasan dalam ' . $lunas . ' hari setelah tanggal pengiriman barang.');
						}
					?>
					</p>
					<p><b>2. </b>Harga dan ketersediaan barang dapat berubah sewaktu waktu tanpa pemberitahuan terlebih dahulu.</p>
					<p><b>3. </b>Harga tertera di atas <strong>sudah termasuk</strong> dengan PPn senilai 10%.</p>
					<p><b>4. </b>Pembayaran dengan menggunakan cek atau giro dinilai sah setelah diuangkan.</p>
					<p><?= $note ?></p>
				</div>
			</div>
			<br><br><br><br>
			<div class="row">
				<div class="col-sm-4 offset-sm-1">
					Menyetujui,
				</div>
				<div class="col-sm-3 offset-sm-4">
					Hormat kami,
				</div>
			</div>
			<br><br><br><br>
			<div class="row">
				<div class="col-sm-4 offset-sm-1">
					<?= $customer_name ?>
				</div>
				<div class="col-sm-3 offset-sm-4">
					Bag. Penjualan
				</div>
			</div>
			<br><br><br><br>
		</div>
		<div class="col-sm-2" style="background-color:#eee">
		</div>
	</div>
	<div class="row" style="background-color:#424242;padding:20px;margin:0">
		<br><br><br>
		<div class="col-sm-2 offset-sm-5">
			<button class="button_success_dark hidden-print" type="button" id="print" onclick="printing('printable')"><i class='fa fa-print'></i></button>
		</div>
	</div>
</body>
<script>
function printing(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>