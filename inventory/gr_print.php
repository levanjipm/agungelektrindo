<DOCTYPE html>
<?php
	include('../codes/connect.php');
	$code_goodreceipt_id = $_POST['id'];
	$sql_first = "SELECT * FROM code_goodreceipt WHERE id = '" . $code_goodreceipt_id . "'";
	$result_first = $conn->query($sql_first);
	$first_row = $result_first->fetch_assoc();
	
	$date = $first_row['date'];
	$supplier_id = $first_row['supplier_id'];
	$document = $first_row['document'];
	$po_id = $first_row['po_id'];
	
	$sql_code_purchase_order = "SELECT name FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_code_purchase_order = $conn->query($sql_code_purchase_order);
	$code_purchase_order = $result_code_purchase_order->fetch_assoc();
	$po_name = $code_purchase_order['name'];
	
	$sql_customer = "SELECT name, address, city FROM supplier WHERE id = '" . $supplier_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	
	$customer_name = $customer['name'];
	$customer_address = $customer['address'];
	$customer_city = $customer['city'];
?>
<head>
	<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="../universal/jquery/jquery-3.3.0.min.js"></script>
	<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="inventorystyle.css">
</head>
<body style='width:100%;overflow-x:hidden'>
<div class="row" style='height:100%'>
	<div class="col-xs-1" style="background-color:#333">
	</div>
	<div class="col-xs-10" id="printable">
		<h2 style='font-family:bebasneue'>Good Receipt</h2>
		<p><b>Tanggal:</b><?php echo date('d M Y',strtotime($date));?></p>
		<br>
		<div class="row">
			<div class="col-xs-8">
				<div class="col-xs-4">
					<p><b>Nomor DO:</b></p>
					<p><b>Nomor PO:</b></p>
				</div>
				<div class="col-xs-4">
					<p><?= $document ?></p>
					<p><?= $po_name ?></p>
				</div>
			</div>
		</div>
		<div class="row" style='padding:15px'>
			<div class="col-xs-12">
				<table class="table table-bordered" style="text-align:center">
					<thead>
						<tr>
							<th style="text-align:center">Referensi</th>
							<th style="text-align:center">Deskripsi</th>
							<th style="text-align:center">Quantity</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$sql = "SELECT goodreceipt.quantity, purchaseorder_received.reference
						FROM goodreceipt 
						JOIN purchaseorder_received ON purchaseorder_received.id = goodreceipt.received_id
						WHERE goodreceipt.gr_id = '" . $code_goodreceipt_id . "'";
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
			</div>
		</div>
	</div>
	<div class="col-xs-1" style="background-color:#333">
	</div>
</div>
<script>
function printing(divName) {
     window.print();
}
</script>
