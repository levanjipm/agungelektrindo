<?php
	include('../codes/connect.php');
	$id		= $_POST['id'];
	
	$sql	= "SELECT code_sample_delivery_order.date, code_sample_delivery_order.name, customer.name AS customer_name, customer.address, customer.city
				FROM code_sample_delivery_order 
				JOIN code_sample ON code_sample_delivery_order.code_sample = code_sample.id
				JOIN customer ON customer.id = code_sample.customer_id
				WHERE code_sample_delivery_order.id = '$id'";
	$result	= $conn->query($sql);
	$row	= $result->fetch_assoc();
	
	$customer_name		= $row['customer_name'];
	$customer_address	= $row['address'];
	$customer_city		= $row['city'];
	
	$delivery_order_name			= $row['name'];
	$delivery_order_date			= $row['date'];
?>
<head>
	<script src='/agungelektrindo/universal/jquery/jquery-3.3.0.min.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/bootstrap/4.1.3/css/bootstrap.min.css'>
	<script src='/agungelektrindo/universal/bootstrap/4.1.3/js/bootstrap.min.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/fontawesome/css/font-awesome.min.css'>
	<link rel='stylesheet' href='/agungelektrindo/universal/bootstrap/3.3.7/css/bootstrap.min.css'>
	<script src='/agungelektrindo/universal/jquery/jquery-ui.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/jquery/jquery-ui.css'>
	<link rel="stylesheet" href='/agungelektrindo/css/style.css'>
</head>
<style>
	#print{
		position:fixed;
		top:50%;
		right:0;
	}
</style>
<head>
	<title><?= $delivery_order_name . " " . $customer_name ?></title>
</head>
<div class='row' style='background-color:#ccc;z-index:0;width:100%;height:100%;margin:0'>
	<div class='col-xs-10 col-xs-offset-1' id='printable' style='z-index:25;background-color:white;padding:0'>
		<div class='row'>
			<div class='col-xs-2'><img src="../universal/images/logogudang.jpg" style="width:100%;height:50%;padding-top:30px"></div>
			<div class='col-xs-5' style="line-height:0.6">
				<h3><b>Agung Elektrindo</b></h3>
				<p>Jalan Jamuju no. 18,</p>
				<p>Bandung, 40114</p>
				<p><b>Ph.</b>(022) - 7202747 <b>Fax</b>(022) - 7212156</p>
				<p><b>Email :</b>AgungElektrindo@gmail.com</p>
			</div>
			<div class='col-xs-4 col-xs-offset-1' style="padding:20px">
				<p><b>Tanggal: </b><?php echo date('d M Y',strtotime($delivery_order_date));?></p>
				<div style='line-height:1'>
					<p>Kepada Yth.</p>
					<p><b><?= $customer_name ?></b></p>
					<p><?= $customer_address ?></p>
					<p><?= $customer_city ?></p>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-xs-12'>
				<p><b>Nomor DO:</b><?= $delivery_order_name ?></p>
			</div>
		</div>
		<table class='table' style='text-align:center'>
			<thead>
				<tr>
					<th style='text-align:center'>Referensi</th>
					<th style='text-align:center'>Deskripsi</th>
					<th style='text-align:center'>Quantity</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sql 				= "SELECT sample.reference, itemlist.description, sample_delivery_order.quantity
							FROM sample_delivery_order
							JOIN sample ON sample_delivery_order.sample_id = sample.id
							JOIN itemlist ON sample.reference = itemlist.reference
							WHERE sample_delivery_order.delivery_order_id = '$id'";
	$result 			= $conn->query($sql);
	while($row 			= $result->fetch_assoc()){
		$reference		= $row['reference'];
		$quantity		= $row['quantity'];
		$description 	= $row['description'];
?>
				<tr>
					<td><?= $reference ?></td>
					<td><?= $description ?></td>
					<td><?= $quantity ?></td>
				</tr>
<?php
	}
?>
			</tbody>
		</table>
		<div style='padding-top:50px;padding-bottom:50px'>
			<div class='col-xs-4' style='text-align:center'><p>Penerima,</p><br><br><hr style='border:1px solid #333;width:60%'></div>
			<div class='col-xs-4' style='text-align:center'><p>Pengirim,</p><br><br><hr style='border:1px solid #333;width:60%'></div>
			<div class='col-xs-4' style='text-align:center'><p>Hormat kami,</p><br><br><hr style='border:1px solid #333;width:60%'></div>
		</div>
	</div>
</div>
<button class='button_default_dark hidden-print' id='print' onclick='printing("printable")'><i class="fa fa-print" aria-hidden="true"></i></button>
<style>
@media print {
	body * {
		visibility: hidden;
	}
	
	#printable, #printable *{
		visibility:visible!important;
	}
	
	#printable{
		position: absolute;
		left: 0;
		top: 0;
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