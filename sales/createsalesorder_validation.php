<?php
	include("../codes/connect.php");
?>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="salesstyle.css">
</head>
<?php
$so_date		= $_POST['today'];
$taxing 		= $_POST['taxing'];
$po_number 		= mysqli_real_escape_string($conn,$_POST['purchaseordernumber']);
$customer 		= $_POST['select_customer'];
$total_so		= $_POST['total'];
if($customer == 0){
	$address 	= $_POST['retail_address'];
	$city 		= $_POST['retail_city'];
	$phone 		= $_POST['retail_phone'];
	$name 		= $_POST['retail_name'];
} else {
	$address 	= '';
	$city 		= '';
	$phone 		= '';
	$name 		= '';
}
$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $customer . "'";
$result_customer 	= $conn->query($sql_customer);
$customer_row		= $result_customer->fetch_assoc();
$customer_name 		= $customer_row['name'];
?>
<body style='overflow-x:hidden'>
	<form action="createsalesorder_input.php" method="POST" name="salesorder_validate">
		<div class="row">
			<div class='col-sm-1' style='background-color:#333'>
			</div>
			<div class='col-sm-10'>
				<h2 style='font-family:bebasneue'>Sales Order</h2>
				<p>Validate Sales Order</p>
				<hr>
				<input type='hidden' value='<?= $address ?>' name='retail_address'>
				<input type='hidden' value='<?= $city ?>' name='retail_city'>
				<input type='hidden' value='<?= $phone ?>' name='retail_phone'>
				<input type='hidden' value='<?= $name ?>' name='retail_name'>
				
				<input type='hidden' value="<?= $so_date ?>" class="form-control" readonly>
				<input type='hidden' value="<?= $so_date ?>" name="today">
				<input type='hidden' value="<?= $customer?>" name="customer">
<?php
				if($customer == 0){
?>
				<h3 style="font-family:bebasneue">Retail</h3>
<?php
				} else {
?>
				<h3 style="font-family:bebasneue"><?= $customer_name ?></h3>
<?php
				}
			if($customer == 0){
?>
				<p><?= $address ?></p>
				<p><?= $city ?></p>
				<p><?= $phone ?></p>
<?php
			}
?>
				<p><strong>Purchase order number</strong></p>
				<p><?= $po_number ?></p>
				<input type="hidden" class="form-control" value="<?= $po_number ?>" readonly name="purchaseordernumber">
				<label>Taxing Option</label>
<?php
				if($customer == 0){
?>
				<p>Retail may not receive tax document</p>
				<input type="hidden" class="form-control" value="0" readonly name="taxing" style='display:none'>
<?php
				} else {
					if($taxing == 1){
?>
				<p><strong>Taxable</strong> sales</p>
<?php
					} else {
?>
				<p>Untaxable sales</p>
<?php
					}
?>
				<input type="hidden" class="form-control" value="<?= $taxing ?>" readonly name="taxing">
<?php
				}
?>
				<div class="row">
					<div class="col-sm-12">
						<table class="table">
							<thead>
								<tr style="text-align:center">
									<th>Reference</th>
									<th>V.A.T.</th>
									<th>Discount</th>
									<th>Quantity</th>
									<th>Price List</th>
									<th>Total price</th>
								</tr>
							</thead>	
							<tbody>
						<?php
							$x = $_POST['jumlah_barang'];
						?>
							<input type='hidden' name="jumlah_barang" value=" <?= $x ?>">
						<?php
							$i = 1;
							for ($i = 1; $i <= $x; $i++){
								$ref		= $_POST["reference" . $i ];
								$vat 		= $_POST["vat" . $i ];
								$disc 		= $_POST["disc" . $i ];
								$qty 		= $_POST["qty" . $i ];
								$pl 		= $_POST["pl" . $i ];
								$totprice 	= $_POST["total" . $i];
								
								$sql 		= "SELECT description FROM itemlist WHERE reference='" . $ref . "'";
								$result 	= $conn->query($sql) or die($conn->error);
								$row 		= $result->fetch_assoc();
								
								if($row == false){
									$desc = " ";
								} else {
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
							<input type='hidden' value="<?= $ref ?>" 	name="reference[<?=$i?>]">
							<input type='hidden' value="<?= $vat ?>" 	name="value_after_tax[<?=$i?>]">
							<input type='hidden' value="<?= $disc ?>" 	name="discount[<?=$i?>]">
							<input type='hidden' value="<?= $qty ?>" 	name="quantity[<?=$i?>]">
							<input type='hidden' value="<?= $pl ?>" 	name="price_list[<?=$i?>]">
						<?php
							}
						?>
							</tbody>
							<tfoot>
								<tr>
									<td style="border:none" colspan='4'></td>
									<td style="padding-left:50px"><b>Grand Total</b></td>
									<td style="text-align:center">
										Rp. <?= number_format($total_so,2)?>
										<input type='hidden' value="<?= $total_so ?>" name="total_so">
									</td>
								</tr>
							</tfoot>
						</table>
						<label>Note</label>
						<textarea name="sales_order_note" class='form-control' style='resize:none' rows='5'></textarea>
					</div>
				</div>
				<br><br>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Approve</button>
				<br>
				<br>
			</div>
			<div class='col-sm-1' style='background-color:#333'>
		</div>
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
</body>