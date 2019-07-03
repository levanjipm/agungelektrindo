<?php
	include("../Codes/connect.php");
	session_start();
	if($_SESSION['user_id'] === NULL){
		header('location:../landing_page.php');
	}
	$sql_user = "SELECT name, role FROM users WHERE id = " . $_SESSION['user_id'];
	$result_user = $conn->query($sql_user);
	$row_user = $result_user->fetch_assoc();
	if($_POST['id'] == NULL){
		header('location:purchasing.php');
	}
?>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<style>
	*{
		font-size:1.015em;
	}
	tr{
		font-size:1.2em;
	}
</style>
<?php
	$po_id = $_POST['id'];
?>

<body>
	<div class='row'>
		<div class='col-sm-1' style='background-color:#ddd'>
		</div>
		<div class='col-sm-10' id='printable'>
			<div class="row">
				<div class="col-sm-8 offset-sm-2">
					<img src="../universal/images/Logo Agung.png" style="width:100%">
				</div>
			</div>
			<br><br>
	<?php
		$sql = "SELECT * FROM code_purchaseorder WHERE id = '" . $po_id . "'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$po_name = $row['name'];
		$vendor = $row['supplier_id'];
		$po_date = $row['date'];
		$top = $row['top'];
		$tax = $row['taxing'];
		$promo = $row['promo_code'];
		$value = $row['value'];
		$send_date = $row['send_date'];
		$dropship_name = $row['dropship_name'];
		$dropship_address = $row['dropship_address'];
		$dropship_city = $row['dropship_city'];
		$dropship_phone = $row['dropship_phone'];
		$status = $row['status'];
		
		$sql_vendor = "SELECT * FROM supplier WHERE id = '" . $vendor . "'";
		$result = $conn->query($sql_vendor);
		$row = $result->fetch_assoc();
		$vendor_name = $row['name'];
		$vendor_address = $row['address'];
		$vendor_city = $row['city'];
		$vendor_phone = $row['phone'];	
	?>
			<div class="row">
				<div class="col-sm-5 offset-sm-1">
					<div class="col-sm-5">
						<b>Purchase order number</b>
					</div>
					<div class="col-sm-7">
						<?= $po_name?>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="col-sm-5">	
						<b>Vendor code</b>
					</div>
					<div class="col-sm-7">
						<?= ($vendor)?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-5 offset-sm-1">
					<div class="col-sm-5">	
						<b>Purchase order date</b>
					</div>
					<div class="col-sm-7">
						<?= $po_date?>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="col-sm-5">
						<b>Vendor name</b>
					</div>
					<div class="col-sm-7">
						<?= $vendor_name?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-5 offset-sm-1">
					<div class="col-sm-5">	
						<b>Status</b>
					</div>
					<div class="col-sm-7">
<?php
	if($status == "URGENT"){
?>
						<strong>Urgent</strong>
<?php
	} else if(date('Y',strtotime($send_date)) < '2000'){
	} else {
						echo date('d M Y',strtotime($send_date));
	}
?>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="col-sm-5">
					</div>
					<div class="col-sm-7">
						<?= $vendor_address . ", " . $vendor_city ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-5 offset-sm-1">
					<div class="col-sm-5">	
						<b>Delivery Address</b>
					</div>
					<div class="col-sm-7">
<?php
	if($dropship_name == ''){
?>
						<b>CV Agung Elektrindo</b>
						<p>Jalan Jamuju no. 18</p>
						<p>Bandung</p>
<?php
	} else {
?>
						<b><?= $dropship_name ?></b>
						<p><?= $dropship_address ?></p>
						<p><?= $dropship_city ?></p>
						<p><?= $dropship_phone ?></p>
<?php
	}
?>
					</div>
				</div>
				<div class="col-sm-5">
						<div class="col-sm-5">
							<b>Phone number :</b>
						</div>
						<div class="col-sm-7">
							<?= $vendor_phone ?>
						</div><br>
						<div class="col-sm-5">
							<b>Promo code :</b>
						</div>
						<div class="col-sm-7">
							<?= $promo ?>
						</div>
				</div>
			</div>
<?php
	$sql_po = "SELECT COUNT(*) AS sum FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "'";
	$result = $conn->query($sql_po);
	$row = $result->fetch_assoc();
	$x = $row['sum'];
?>	
			<br>
			<div style="padding:50px">
				<p>Please supply/manufacture and deliver the following items in accordance with the terms and conditions 
				of Purchase Order attached.</p>
				<br>
				<table class="table" style="text-align:center;font-size:0.9em;">
					<thead>	
						<th style="width:25%;text-align:center">Item Description</th>
						<th style="width:15%;text-align:center">Reference</th>
						<th style="width:20%;text-align:center">Unit price</th>
						<th style="width:5%;text-align:center">Discount</th>
						<th style="width:5%;text-align:center">Quantity</th>
						<th style="width:20%;text-align:center">Price after discount</th>
						<th style="width:25%;text-align:center">Total price</th>
					</thead>
					<tbody>
					<?php 
						
						$sql_item = "SELECT * FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "'";
						
						$result = $conn->query($sql_item);
						$i = 0;
						while($row = $result->fetch_assoc()){
							$disc[$i] = $row['discount'];
							$ref[$i] = $row['reference'];
							$price_list[$i] = $row['price_list'];
							$unitprice[$i] = $row['unitprice'];
							$quantity[$i] = $row['quantity'];
							$totprice[$i] = $row['unitprice'] * $row['quantity'];				
							$sql_desc = "SELECT description FROM itemlist WHERE reference = '" . $ref[$i] . "'";
							$r = $conn->query($sql_desc);
							$row = $r->fetch_assoc();
							$desc = $row['description'];
							if($tax == 1){
?>
							<tr>
								<td><?= $desc ?></td>
								<td><?= $ref[$i] ?></td>
								<td>Rp. <?= number_format($price_list[$i] * 10 /11,2) ?></td>
								<td><?= number_format($disc[$i],2) ?>%</td>
								<td><?= $quantity[$i] ?></td>
								<td>Rp. <?= number_format($unitprice[$i] * 10 /11,2) ?></td>
								<td>Rp.<?= number_format($totprice[$i] * 10 /11,2) ?></td>
							</tr>
<?php
} else {
?>
							<tr>
								<td><?= $desc ?></td>
								<td><?= $ref[$i] ?></td>
								<td>Rp. <?= number_format($price_list[$i],2) ?></td>
								<td><?= number_format($disc[$i],0) ?>%</td>
								<td><?= $quantity[$i] ?></td>
								<td>Rp. <?= number_format($unitprice[$i],2) ?></td>
								<td>Rp. <?= number_format($totprice[$i],2) ?></td>
							</tr>
							<?php
							}
							$i++;
						}
					?>	
					</tbody>
					<tfoot>
<?php
	if($tax == 1){
?>
						<tr>
							<td style="border-left:none;border-right:none;border-bottom:none"></td>
							<td style="border-left:none;border-right:none;border-bottom:none"></td>
							<td style="border-left:none;border-right:none;border-bottom:none"></td>
							<td style="border-left:none;border-right:none;border-bottom:none"></td>
							<td style="border-left:none;border-right:none;border-bottom:none"></td>
							<td style="text-align:left">Sub Total</td>
							<td style="text-align:left">Rp.<?= number_format($value * 10/11,2) ?></td>
						</tr>
						<tr>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="text-align:left">Tax</td>
							<td style="text-align:left">Rp.<?= number_format($value - $value * 10/11,2) ?></td>
						</tr>
						<tr>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="text-align:left">Grand Total</td>
							<td style="text-align:left">Rp.<?= number_format($value,2) ?></td>
						</tr>
<?php
	} else {
?>
						<tr>
							<td style="border-left:none;border-right:none;border-bottom:none"></td>
							<td style="border-left:none;border-right:none;border-bottom:none"></td>
							<td style="border-left:none;border-right:none;border-bottom:none"></td>
							<td style="border-left:none;border-right:none;border-bottom:none"></td>
							<td style="border-left:none;border-right:none;border-bottom:none"></td>
							<td style="text-align:left">Sub Total</td>
							<td style="text-align:left">Rp.<?= number_format($value,2) ?></td>
						</tr>
<?php
	}
?>
					</tfoot>
				</table>	
				<br><br>
				<div class="row" style="display:none" id="footer_print">
					<div class="col-sm-2">
						<strong>Supplier,</strong>
						<br><br><br><br><br>
						<hr style="border-top:2px solid #666">
						<?= $vendor_name ?>
					</div>
					<div class="col-sm-2 col-sm-offset-5">
						<strong>Issued by,</strong>
						<br><br><br><br><br>
						<hr style="border-top:2px solid #666">
						<?= $row_user['name']; ?>			
					</div>
					<div class="col-sm-2 col-sm-offset-1">
						<strong>Approved by,</strong>
						<br><br><br>
						<br><br>
						<hr style="border-top:2px solid #666">
					</div>
				</div>
			<br><br><br>
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
</body>

<script>
function printing(){
	var printContents = document.getElementById('printable').innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	$('#footer_print').show();
	window.print();
	document.body.innerHTML = originalContents;	
	$('#footer_print').hide();
}
</script>