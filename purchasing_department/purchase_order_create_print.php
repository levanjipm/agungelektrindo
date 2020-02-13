<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/head.php');
	if($_POST['id'] == NULL){
		header('location:/agungelektrindo/purchasing');
	}
	
	$po_id 				= $_POST['id'];
	
	$sql 				= "SELECT code_purchaseorder.*, supplier.name as supplier_name, supplier.address, supplier.city, supplier.phone, supplier.phone,
							users.name as creator
							FROM code_purchaseorder 
							JOIN supplier ON code_purchaseorder.supplier_id = supplier.id
							JOIN users ON code_purchaseorder.created_by = users.id
							WHERE code_purchaseorder.id = '$po_id'";
	$result 			= $conn->query($sql);
	$row 				= $result->fetch_assoc();
	
	$po_name 			= $row['name'];
	$vendor 			= $row['supplier_id'];
	$po_date 			= $row['date'];
	$top 				= $row['top'];
	$tax 				= $row['taxing'];
	$promo 				= $row['promo_code'];
	$send_date 			= $row['send_date'];
	$dropship_name 		= $row['dropship_name'];
	$dropship_address 	= $row['dropship_address'];
	$dropship_city 		= $row['dropship_city'];
	$dropship_phone 	= $row['dropship_phone'];
	$status 			= $row['status'];
	$supplier_name 		= $row['supplier_name'];
	$supplier_address 	= $row['address'];
	$supplier_city 		= $row['city'];
	$supplier_phone 	= $row['phone'];
	$creator			= $row['creator'];
?>
<head>
	<title><?= $po_name . ' ' . $supplier_name ?></title>
</head>
<style>
	*{
		font-size:12pt;
	}
	
	label{
		font-size:12pt;
	}
	
	tr{
		font-size:12pt;
	}
	
	hr{
		border-top:2px solid black;
	}
	
	#print{
		position:fixed!important;
		top:50%!important;
		right:0;
	}
	
	table{
		width:100%;
		font-size:12pt;
	}
	
	table > thead > tr > th{
		width:33%;
	}
	
	table, tr, td {
		border: 1px solid black;
		padding:10px;
	}
	
	table, tr, th {
		border: 1px solid black;
		padding:5px;
	}
</style>
<div class='row' style='background-color:#ddd;width:100%;margin:0'>
	<div class='col-sm-10 col-sm-offset-1' id='printable' style='background-color:white;'>
		<div class='row'>
			<div class='col-sm-8 offset-sm-2'>
				<img src='/agungelektrindo/universal/images/Logo Agung.jpg' style='width:100%'>
			</div>
		</div>
		<div style="padding:50px">
		<table id='head_table'>
			<thead>
				<tr>	
					<th>To</th>
					<th>Ship to</th>
					<th>Purchase Order</th>
				</tr>
			</thead>
			<tr>
				<td valign='top'>
					<label><?= $supplier_name ?></label>
					<p><?= $supplier_address ?></p>
					<p><?= $supplier_city ?></p>
					<p><?= $supplier_phone ?></p>
				</td>
				<td valign='top'>	
<?php
	if($dropship_name == ''){
?>
					<label>CV Agung Elektrindo</label>
					<p>Jalan Jamuju no. 18</p>
					<p>Bandung</p>
					<p>(022) 7202747 </p>
<?php
	} else {
?>
					<label><?= $dropship_name ?></label>
					<p><?= $dropship_address ?></p>
					<p><?= $dropship_city ?></p>
					<p><?= $dropship_phone ?></p>
<?php
	}
?>
				</td>
					<td valign='top'>
						<label>[<?= $po_name ?>]</label>
						<br>
						<label>Date</label>
						<p><?= date('d M Y',strtotime($po_date)) ?></p>
						
						<label>Delivery date</label>
<?php
	if($status == "URGENT"){
?>
						<p>Urgent</strong></p>
<?php
	} else if(!empty($send_date)){
?>
						<p><?= date('d M Y',strtotime($send_date)); ?></p>
<?php
	}
	
	if($promo != ''){
?>
						<label>Promo code</label>
						<p><?= $promo ?></p>
<?php
	}
?>	
						<label>Term of payment</label>
						<p><?= $top ?></p>
					</td>
				</tr>
			</table>
<?php
	$sql_po 		= "SELECT COUNT(*) AS sum FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "'";
	$result 		= $conn->query($sql_po);
	$row 			= $result->fetch_assoc();
	$x 				= $row['sum'];
?>	
			<br>
				<p>Please supply/manufacture and deliver the following items in accordance with the terms and conditions 
				of Purchase Order attached.</p>
				<br>
				<table>
					<thead>
						<tr>	
							<th style='color:black;width:25%;text-align:center'>Item Description</th>
							<th style='color:black;width:15%;text-align:center'>Reference</th>
							<th style='color:black;width:20%;text-align:center'>Unit price</th>
							<th style='color:black;width:5%;text-align:center'>Discount</th>
							<th style='color:black;width:5%;text-align:center'>Quantity</th>
							<th style='color:black;width:20%;text-align:center'>Price after discount</th>
							<th style='color:black;width:25%;text-align:center'>Total price</th>
						</tr>
					</thead>
					<tbody>
					<?php 
						
						$sql_item 	= "SELECT purchaseorder.*, itemlist.description FROM purchaseorder
										JOIN itemlist ON purchaseorder.reference = itemlist.reference
										WHERE purchaseorder.purchaseorder_id = '$po_id'";
						$result 	= $conn->query($sql_item);
						$value 		= 0;
						while($row 			= $result->fetch_assoc()){
							$reference		= $row['reference'];
							$price_list	 	= $row['price_list'];
							$unitprice		= $row['unitprice'];
							$quantity	 	= $row['quantity'];
							$totprice	 	= $row['unitprice'] * $row['quantity'];	
							$discount		= 100 * (1 - ($unitprice / $price_list));

							$value 			+= $unitprice * $quantity;
							
							$description	= $row['description'];
							if($tax == 1){
					?>
							<tr>
								<td><?= $description ?></td>
								<td><?= $reference ?></td>
								<td>Rp. <?= number_format($price_list * 10 /11,2) ?></td>
								<td><?= number_format($discount,2) ?>%</td>
								<td><?= number_format($quantity,0) ?></td>
								<td>Rp. <?= number_format($unitprice * 10 /11,2) ?></td>
								<td>Rp.<?= number_format($totprice * 10 /11,2) ?></td>
							</tr>
					<?php
							} else {
					?>
							<tr>
								<td><?= $description ?></td>
								<td><?= $reference ?></td>
								<td>Rp. <?= number_format($price_list,2) ?></td>
								<td><?= number_format($discount,2) ?>%</td>
								<td><?= number_format($quantity) ?></td>
								<td>Rp. <?= number_format($unitprice,2) ?></td>
								<td>Rp. <?= number_format($totprice,2) ?></td>
							</tr>
					<?php
							}
						}
					?>	
					</tbody>
					<tfoot>
<?php
	if($tax == 1){
?>
						<tr>
							<td colspan='5'></td>
							<td style="text-align:left">Sub Total</td>
							<td style="text-align:left">Rp.<?= number_format($value * 10/11,2) ?></td>
						</tr>
						<tr>
							<td colspan='5'></td>
							<td style="text-align:left">Tax</td>
							<td style="text-align:left">Rp.<?= number_format($value - $value * 10/11,2) ?></td>
						</tr>
						<tr>
							<td colspan='5'></td>
							<td style="text-align:left">Grand Total</td>
							<td style="text-align:left">Rp.<?= number_format($value,2) ?></td>
						</tr>
<?php
	} else {
?>
						<tr>
							<td style="border-left:none;border-right:none;border-bottom:none" colspan='5'></td>
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
						<?= $supplier_name ?>
					</div>
					<div class="col-sm-2 col-sm-offset-5">
						<strong>Issued by,</strong>
						<br><br><br><br><br>
						<hr style="border-top:2px solid #666">
						<?= $creator; ?>			
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
	</div>
<button class="button_default_dark hidden-print" type="button" id="print" onclick="printing()"><i class='fa fa-print'></i></button>

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