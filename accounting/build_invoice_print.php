<head>
<title>Print Invoice</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
</head>
<style>
	*{
		font-size:1.06em;
	}
</style>
<?php
	include('../codes/connect.php');
	
	$id = $_POST['id'];
	
	$sql = "SELECT * FROM invoices WHERE id = '" . $id . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$ongkir = $row['ongkir'];
	$value = $row['value'];
	$name = $row['name'];
	$date = $row['date'];
	$customer_id = $row['customer_id'];
	$faktur = $row['faktur'];
	
	$do_name = 'SJ-AE-' . substr($name,6,100);
	
	$sql_customer = "SELECT name, address, city FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$row_customer = $result_customer->fetch_assoc();
	
	$customer_name = $row_customer['name'];
	$customer_address = $row_customer['address'];
	$customer_city = $row_customer['city'];
	
	$sql_do = "SELECT so_id,id FROM code_delivery_order WHERE name = '" . $do_name . "'";
	$result_do = $conn->query($sql_do);
	$row_do = $result_do->fetch_assoc();
	$do_id = $row_do['id'];
	$so_id = $row_do['so_id'];
	
	$sql_so = "SELECT po_number,taxing FROM code_salesorder WHERE id = '" . $so_id . "'";
	$result_so = $conn->query($sql_so);
	$row_so = $result_so->fetch_assoc();
	$taxing = $row_so['taxing'];
	$po_number = $row_so['po_number'];
?>
<div class='row'>
	<div class='col-sm-1' style='background-color:#ddd'>
	</div>
	<div class='col-sm-10' style='padding-top:50px;padding-right:50px;padding-left:50px' id='printable'>
		<div class='row'>
			<div class='col-sm-7'>
				<img src='../universal/images/Logo Agung.jpg' style='width:100%'>
				<p><strong>Nomor invoice:</strong> <?= $name ?></p>
				<?php
					if($faktur == 'NULL' || $faktur == ''){
					} else {
				?>
				<p><strong>Nomor faktur:</strong> <?= $faktur ?></p>
					<?php } ?>
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
		<hr><br><br>
		<table class='table' style='text-align:center'>
			<tr>
				<th style='width:5%;text-align:center'>Nomor</th>
				<th style='width:30%;text-align:center'>Barang</th>
				<th style='width:15%;text-align:center'>Jumlah</th>
				<th style='width:25%;text-align:center'>Harga satuan</th>
				<th style='width:25%;text-align:center'>Harga</th>
			</tr>
<?php
		$i = 1;
		$sql_count = "SELECT COUNT(*) AS counter FROM delivery_order WHERE do_id = '" . $do_id . "'";
		$result_count = $conn->query($sql_count);
		$row_count = $result_count->fetch_assoc();
		$counting = $row_count['counter'];
		if($counting <= 10){
			$max = 10;
		} else {
			$max = $counting;
		}
			for($i = 1; $i <= $max; $i++){
				$sql_table = "SELECT * FROM delivery_order WHERE do_id = '" . $do_id . "' LIMIT 1 OFFSET " . ($i - 1);
				$result_table = $conn->query($sql_table);
				$row_table = $result_table->fetch_assoc();
				if(empty($row_table['reference'])){
?>
			<tr style='height:40px'>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
<?php
			} else {
?>
			<tr style='height:40px'>
				<td><?= $i . '.' ?></td>
				<td><?php
					$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $row_table['reference'] . "'";
					$result_item = $conn->query($sql_item);
					$row_item = $result_item->fetch_assoc();
					echo $row_item['description'] . ' - ' . $row_table['reference'];
				?></td>
				<td><?= $row_table['quantity']; ?></td>
				<td><?php
					$sql_price = "SELECT price FROM sales_order WHERE so_id = '" . $so_id . "' AND reference = '" . $row_table['reference'] . "'";
					$result_price = $conn->query($sql_price);
					while($row_price = $result_price->fetch_assoc()){
						$price = $row_price['price'];
					}
					if($taxing == 1){
						echo ('Rp. ' . number_format($price * 10 /11,2));
					} else {
						echo ('Rp. ' . number_format($price,2));
					}
				?></td>
				<td><?php
					if($taxing == 1){
						echo('Rp. ' . number_format($price * $row_table['quantity'] * 10/11,2));
					} else {
						echo('Rp. ' . number_format($price * $row_table['quantity'],2));
					}
				?></td>
			</tr>
		<?php 
			}
		}
		if($taxing == 1){ 
		?>
			<tr>
				<td style='background-color:white;border-bottom:none;'></td>
				<td style='background-color:white;border-bottom:none;'></td>
				<td style='background-color:white;border-bottom:none;'></td>
				<td>Subtotal</td>
				<td><?= 'Rp. ' . number_format($value*10/11,2) ?></td>
			</tr>
			<tr>
				<td style='background-color:white;border-bottom:none;border-top:none'></td>
				<td style='background-color:white;border-bottom:none;border-top:none'></td>
				<td style='background-color:white;border-bottom:none;border-top:none'></td>
				<td>PPn 10%</td>
				<td><?= 'Rp. ' . number_format($value - $value*10/11,2) ?></td>
			</tr>
			<tr>
				<td style='background-color:white;border-bottom:none;border-top:none'></td>
				<td style='background-color:white;border-bottom:none;border-top:none'></td>
				<td style='background-color:white;border-bottom:none;border-top:none'></td>
				<td>Total</td>
				<td><?= 'Rp. ' . number_format($value,2) ?></td>
			</tr>
		<?php } else { ?>
			<tr>
				<td style='background-color:white;border-bottom:none;'></td>
				<td style='background-color:white;border-bottom:none;'></td>
				<td style='background-color:white;border-bottom:none;'></td>
				<td>Total</td>
				<td><?= 'Rp. ' . number_format($value,2) ?></td>
			</tr>
		<?php } ?>
		<?php
			if($ongkir == ''|| $ongkir == NULL || $ongkir == 0){
			} else {
		?>
			<tr>
				<td style='background-color:white;border:none;'></td>
				<td style='background-color:white;border:none;'></td>
				<td style='background-color:white;border:none;'></td>
				<td>Ongkos Kirim</td>
				<td><?= 'Rp. ' . number_format($ongkir,2) ?></td>
			</tr>
			<tr>
				<td style='background-color:white;border:none;'></td>
				<td style='background-color:white;border:none;'></td>
				<td style='background-color:white;border:none;'></td>
				<td>Grand total</td>
				<td><?= 'Rp. ' . number_format($ongkir + $value,2) ?></td>
			</tr>
			<?php } ?>
		</table>
		<br><br><br><br><br>
		<div class='col-sm-3 col-sm-offset-9' style='margin-bottom:150px'>
			<p style='text-align:right'>Hormat kami,</p>
			<?php
				if($taxing == 1){
			?>
			<div style='border:1px solid #ddd;width:110px;height:80px;position:absolute;right:0%'>
			</div>
			<?php
				}
			?>
		</div>
	</div>
	<div class='col-sm-1' style='background-color:#ddd'>
	</div>
</div>
<div class="row" style="background-color:#333;padding:30px">
	<div class="col-sm-2 offset-sm-5">
		<button class="btn btn-primary hidden-print" type="button" id="print" onclick="printing()">Print</button>
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
	