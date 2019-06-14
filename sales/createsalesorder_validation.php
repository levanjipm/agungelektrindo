<?php
	include("../codes/connect.php");
?>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<?php
$so_date = $_POST['today'];
$taxing = $_POST['taxing'];
$po_number = $_POST['purchaseordernumber'];
$customer = $_POST['select_customer'];
$total_so = $_POST['total'];
if($customer == 0){
	$address = $_POST['retail_address'];
	$city = $_POST['retail_city'];
	$phone = $_POST['retail_phone'];
	$name = $_POST['retail_name'];
};
$sql = " SELECT COUNT(*) AS jumlah FROM code_salesorder WHERE MONTH(date) = MONTH('" . $so_date . "') 
AND YEAR(date) = YEAR('" . $so_date . "')";
$result = $conn->query($sql);
if($result){	
	while($row = $result->fetch_assoc()) {
	   $jumlah = $row['jumlah'];
	}
} else {
	$jumlah = 0;
}
$jumlah++;
$so_number = "" . date("y",strtotime($so_date)) . date("m",strtotime($so_date)) . "-SO-" . str_pad($jumlah,3,"0",STR_PAD_LEFT);
$sql_customer = "SELECT * FROM customer WHERE id = '" . $customer . "'";
$r = $conn->query($sql_customer);
while($rows = $r->fetch_assoc()) {
	$customer_name = $rows['name'];
}
?>

<body style="width:99%">
	<form action="createsalesorder_input.php" method="POST" name="salesorder_validate">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<h2 style="text-align:center"><?= $so_number?></h2>
				<input type="hidden" value="<?= $so_number ?>" name="so_number">
			</div>
		</div>	
		<div class="row">
			<div class="col-lg-4 offset-lg-4">
				<input type="date" value="<?= $so_date ?>" class="form-control" readonly>
				<input type="hidden" value="<?= $so_date ?>" name="today">
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<label for="customer_name">Customer name: </label>
				<input type="hidden" value=<?= $customer?>" name="customer">
<?php
				if($customer == 0){
?>
				<p>Retail</p>
<?php
				} else {
?>
				<p><?= $customer_name ?></p>
<?php
				}
?>				
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<label>Delivery Address</label>
			<?php
			if($customer != 0){
			?>
				<select class="form-control" name="delivery_address">
			<?php
				$sql_delivery = "SELECT * FROM customer_deliveryaddress WHERE customer_id = '" . $customer . "'";
				$res = $conn->query($sql_delivery);
				while($rows = $res->fetch_assoc()) { 
			?>
					<option value="<?= $rows['id'] ?>"><?= $rows['address']?></option>
			<?php
				}
			?>
				</select>
			<?php
			} else {
				if($address == '' || $city == ''){
			?>
				<p>Data unavailable</p>
			<?Php
				} else {
			?>
				<p><?= $address ?></p>
				<p><?= $city ?></p>
				<p><?= $phone ?></p>
			<?php
				}
			}
			?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<label>Purchase Order number:</label>
				<input type="text" class="form-control" value="<?= $po_number ?>" readonly name="purchaseordernumber">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<label>Taxing (1 for yes, 0 for no):</label>
<?php
				if($customer == 0){
?>
				<p>Retail may not receive tax document</p>
				<input type="text" class="form-control" value="0" readonly name="taxing" style='display:none'>
<?php
				} else {
?>
				<input type="text" class="form-control" value="<?= $taxing ?>" readonly name="taxing">
<?php
				}
?>
			</div>
		</div>
		<br><br><br>
		<div class="row">
			<div class="col-lg-12">
				<table class="table">
					<thead>
						<th style="text-align:center">Reference</th>
						<th style="text-align:center">V.A.T.</th>
						<th style="text-align:center">Discount</th>
						<th style="text-align:center">Quantity</th>
						<th style="text-align:center">Price List</th>
						<th style="text-align:center">Total price</th>
					</thead>	
					<tbody>
				<?php
					$x = $_POST['jumlah_barang'];
				?>
					<input type="hidden" name="jumlah_barang" value=" <?= $x ?>">
				<?php
					$i = 1;
					for ($i = 1; $i <= $x; $i++){
						$ref = $_POST["reference" . $i ];
						$vat = $_POST["vat" . $i ];
						$disc = $_POST["disc" . $i ];
						$qty = $_POST["qty" . $i ];
						$pl = $_POST["pl" . $i ];
						$totprice = $_POST["total" . $i];
						$sql = "SELECT * FROM itemlist WHERE reference='" . $ref . "'";
						$result = $conn->query($sql) or die($conn->error);
						$row = $result->fetch_assoc();
						if($row == false){
							$desc = " ";
						} else { 
							$item_id = $row['id'];
							$desc = $row['description'];
						}
				?>
					<tr>	
						<td style="text-align:center"><?= $ref ?></td>						
						<td style="text-align:center">Rp. <?= number_format($vat,2) ?></td>
						<td style="text-align:center"><?= $disc . '%' ?></td>
						<td style="text-align:center"><?= $qty ?></td>
						<td style="text-align:center">Rp. <?= number_format($pl,2) ?></td>
						<td style="text-align:center">Rp. <?= number_format($totprice,2) ?></td>
					</tr>
					<input type="hidden" value="<?= $ref ?>" name="ref<?=$i?>">
					<input type="hidden" value="<?= $vat ?>" name="vat<?=$i?>">
					<input type="hidden" value="<?= $disc ?>" name="disc<?=$i?>">
					<input type="hidden" value="<?= $qty ?>" name="qty<?=$i?>">
					<input type="hidden" value="<?= $pl ?>" name="pl<?=$i?>">
					<input type="hidden" value="<?= $totprice ?>" name="totprice<?=$i?>">
				<?php
					}
				?>
					</tbody>
					<tfoot>
						<tr>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="padding-left:50px"><b>Grand Total</b></td>
							<td style="text-align:center">
								Rp. <?= number_format($total_so,2)?>
								<input type="hidden" value="<?= $total_so ?>" name="total_so">
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<br>
		<div class="row" style="top:50px;padding-left:50px">
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Approve</button>
		</div>				
		<div id="myModal" class="modal" role="dialog">
			<div class="modal-dialog">	
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Approving sales order</h4>
					</div>
					 <div class="modal-body">
						<h3>Disclaimer</h3>
						<p>By clicking on submit button, you are responsible for any risk issue this sales order</p>
						<p>Please confirm to corresponding customer about the term and condition</p>
						<p><b>And please check a couple of times if you must</b></p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Approve</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>