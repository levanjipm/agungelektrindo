<?php
	include('../codes/connect.php');
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
<?php
	$do_id 						= $_POST['id'];
	
	$sql_delivery_order			= "SELECT date,customer_id,name,so_id FROM code_delivery_order WHERE id = '" . $do_id . "'";
	$result_delivery_order 		= $conn->query($sql_delivery_order);
	$delivery_order 			= $result_delivery_order->fetch_assoc();
	
	$date 						= $delivery_order['date'];
	$customer_id 				= $delivery_order['customer_id'];
	$delivery_order_name 		= $delivery_order['name'];
	$so_id 						= $delivery_order['so_id'];
	
	$sql_po 					= "SELECT po_number,retail_address,retail_city,retail_phone,retail_name FROM code_salesorder WHERE id = '" . $so_id . "'";
	$result_po 					= $conn->query($sql_po);
	$po 						= $result_po->fetch_assoc();
	
	$po_name 					= $po['po_number'];
	
	if($customer_id != 0){
		$sql_customer 		= "SELECT name,address,city FROM customer WHERE id = '" . $customer_id . "'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		$name 				= $customer['name'];
		$address 			= $customer['address'];
		$city 				= $customer['city'];
	} else {
		$name 				= $po['retail_name'];
		$address 			= $po['retail_address'];
		$city 				= $po['retail_city'];
	}
?>
<head>
	<title><?= $delivery_order_name . " " . $name ?></title>
</head>
<body>
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
				<p><b>Tanggal: </b><?php echo date('d M Y',strtotime($date));?></p>
				<div style='line-height:1'>
					<p>Kepada Yth.</p>
					<p><b><?= $name ?></b></p>
					<p><?= $address ?></p>
					<p><?= $city ?></p>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-xs-12'>
				<p><b>Nomor DO:</b><?= $delivery_order_name ?></p>
				<p><b>Nomor PO:</b><?= $po_name ?></p>
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
	$sql 				= "SELECT * FROM delivery_order WHERE do_id = '" . $do_id . "'";
	$result 			= $conn->query($sql);
	while($row 			= $result->fetch_assoc()){
		$reference		= $row['reference'];
		$quantity		= $row['quantity'];
		$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . $row['reference'] . "'";
		$result_item 	= $conn->query($sql_item);
		$item			= $result_item->fetch_assoc();
		$description 	= $item['description'];
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