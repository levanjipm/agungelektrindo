<DOCTYPE html>
<?php
	include('../codes/connect.php');
	$id = $_POST['id'];
	$sql_first = "SELECT * FROM code_sample WHERE id = '" . $id . "'";
	$result_first = $conn->query($sql_first);
	$first_row = $result_first->fetch_assoc();
	$date = $first_row['date'];
	$customer_id = $first_row['customer_id'];
	
	$sql_customer = "SELECT name, address, city FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	$customer_name = $customer['name'];
	$customer_address = $customer['address'];
	$customer_city = $customer['city'];
?>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="row">
	<div class="col-xs-1" style="background-color:gray">
	</div>
	<div class="col-xs-10" id="printable">
		<div class="row" style="height:100px">
			<div class="col-xs-2">
				<img src="../universal/images/logogudang.jpg" style="width:100%;height:70%;padding-top:30px">
			</div>
			<div class="col-xs-5" style="line-height:0.6">
				<h3><b>Agung Elektrindo</b></h3>
				<p>Jalan Jamuju no. 18,</p>
				<p>Bandung, 40114</p>
				<p><b>Ph.</b>(022) - 7202747 <b>Fax</b>(022) - 7212156</p>
				<p><b>Email :</b>AgungElektrindo@gmail.com</p>
			</div>
			<div class="col-xs-4 offset-lg-1" style="padding:20px">
				<div class="col-xs-3">
					<p><b>Tanggal:</b></p>
				</div>
				<div class="col-xs-6"><?php echo date('d M Y',strtotime($date));?></div>
				<div class="col-xs-12">
					<p>Kepada Yth. <b><?= $customer_name ?></b></p>
					<p><?= $customer_address ?></p>
					<p><?= $customer_city ?></p>
				</div>
			</div>
		</div>
		<br><br><br>
		<div class="row">
			<div class="col-xs-8 col-xs-offset-2">
				<h3 style='text-align:center'>SAMPLE</h3>
			</div>
		</div>
		<br><br><br>
		<div class="row">
			<div class="col-xs-12">
				<table class="table" style="text-align:center">
					<thead>
						<tr>
							<th style="text-align:center">Referensi</th>
							<th style="text-align:center">Deskripsi</th>
							<th style="text-align:center">Quantity</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$sql = "SELECT * FROM sample WHERE code_id = '" . $id . "'";
						$result = $conn->query($sql);
						while($row = $result->fetch_assoc()){
					?>
						<tr>
							<td><?= $row['reference'] ?></td>
							<?php
								$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $row['reference'] . "'";
								$result_item = $conn->query($sql_item);
								while($row_item = $result_item->fetch_assoc()){
									$description = $row_item['description'];
								}
							?>
							<td><?= $description ?></td>
							<td><?= $row['quantity'] ?></td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
				<br>
				<p><strong>Note</strong></p>
				<p>Sample yang telah dikirimkan mohon untuk dikembalikan dalam kurun waktu maksimal 7 hari</p>
				<p>Sample akan ditagihkan apabila </p>
				<ul>
					<li>Barang yang dikembalikan tidak dalam kondisi baik.</li>
					<li>Barang yang dikembalikan digunakan tidak sebagaimana mestinya.</li>
					<li>Barang dikembalikan melewati batas peminjaman sampel</li>
				</ul>
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-4" style="text-align:center;height:100px">
				Penerima,
			</div>
			<div class="col-xs-4" style="text-align:center">
				Pengirim,
			</div>
			<div class="col-xs-4" style="text-align:center">
				Hormat kami,
			</div>
		</div>
	</div>
	<div class="col-xs-1" style="background-color:gray">
	</div>
</div>
	<div class="row" style="background-color:#333;padding:20px">
		<br><br><br>
		<div class="col-xs-2 offset-sm-5">
			<button class="btn btn-primary hidden-print" type="button" id="print" onclick="printing('printable')">Print</button>
		</div>
	</div>
<style>
@media print {
	html, body {
		display: block; 
		margin: 0;
	}

	@page {
	  size: 21.59cm 13.97cm;
	}
}
</style>
<script>
function printing(divName) {
     window.print();
}
</script>
