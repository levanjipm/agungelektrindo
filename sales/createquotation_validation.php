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
$q_date = $_POST['today'];
$dp = $_POST['dp'];
$lunas = $_POST['lunas'];
$terms = $_POST['terms'];

$total = $_POST['total'];
$comment = $_POST['comment'];
$customer = $_POST['quote_person'];
$sql_customer = "SELECT * FROM customer WHERE id='" . $customer . "'";
$result = $conn->query($sql_customer);
$row = $result->fetch_assoc();
$customer_name = $row['name'];

if ($terms == 1){
	$note = "Payment must be done before delivery";
} else if($terms == 2){
	$note = "Payment will be done using cheque in " . $lunas . " day(s) since the delivery date";
} else if($terms == 3){
	$note = "Due date of the payment is in " . $lunas . " day(s) after delivery date";
} else if($terms == 4){
	$note = $dp . "% down payment upon confirmation and full payment after " . $lunas . " day(s)";
}
?>
<body style="height:100%;overflow-x:hidden;">
	<form action="createquotation_input.php" method="POST" name="quotation_validate">
		<div class="row" style='height:100%'>
			<div class='col-sm-1' style='background-color:#333'>
			</div>
			<div class='col-sm-10'>
				<h2 style='font-family:bebasneue'>Quotation</h2>
				<p>Validate quotation</p>
				<hr>
				<input type="hidden" value="<?= $q_date ?>" name="today">
				<input type="hidden" value='<?= $customer?>' name="customer">
				<h3><?= $customer_name ?></h3>
				<p><?= date('d M Y',strtotime($q_date)) ?></p>
				<br><br><br>
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-hover">
							<thead>
								<th style="text-align:center;width:20%">Item Description</th>
								<th style="text-align:center;width:10%">Reference</th>
								<th style="text-align:center;width:15%">Unit price</th>
								<th style="text-align:center;width:5%">Discount</th>
								<th style="text-align:center;width:10%">Quantity</th>
								<th style="text-align:center;width:15%">Price after discount</th>
								<th style="text-align:center;width:15%">Total price</th>
							</thead>	
							<tbody>
						<?php
							$x = $_POST['jumlah_barang'];
							$i = 1;
							for ($i = 1; $i <= $x; $i++){
								$ref = mysqli_real_escape_string($conn,$_POST["reference" . $i ]);
								$price = $_POST["price" . $i ];
								$disc = $_POST["discount" . $i ];
								$qty = $_POST["quantity" . $i ];
								$netprice = $_POST["unitprice" . $i ];
								$totprice = $_POST["totalprice" . $i];
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
								<td style="text-align:center"><?= $desc ?></td>
								<td style="text-align:center"><?= $ref ?></td>						
								<td style="text-align:center">Rp. <?= number_format($price,2) ?></td>
								<td style="text-align:center"><?= $disc . '%' ?></td>
								<td style="text-align:center"><?= $qty ?></td>
								<td style="text-align:center">Rp. <?= number_format($netprice,2) ?></td>
								<td style="text-align:center">Rp. <?= number_format($totprice,2) ?></td>
							</tr>
							<input type="hidden" value="<?= $ref ?>" name="item[<?=$i?>]">
							<input type="hidden" value="<?= $price ?>" name="price[<?=$i?>]">
							<input type="hidden" value="<?= $disc ?>" name="disc[<?=$i?>]">
							<input type="hidden" value="<?= $qty ?>" name="qty[<?=$i?>]">
							<input type="hidden" value="<?= $netprice ?>" name="netprice[<?=$i?>]">
							<input type="hidden" value="<?= $totprice ?>" name="totprice[<?=$i?>]">
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
									<td style="border:none"></td>
									<td style="padding-left:50px"><b>Total</b></td>
									<td style="text-align:center">
										Rp. <?= number_format($total,2)?>
									</td>
								</tr>
								<input type='hidden' value='<?= $_POST['add_discount'] ?>' name='add_discount'>
<?php
	if($_POST['add_discount'] > 0){
?>
								<tr>
									<td style="border:none"></td>
									<td style="border:none"></td>
									<td style="border:none"></td>
									<td style="border:none"></td>
									<td style="border:none"></td>
									<td style="padding-left:50px"><b>Additional Disc.</b></td>
									<td style="text-align:center">
										Rp. <?= number_format($_POST['add_discount'],2)?>
									</td>
								</tr>
								<tr>
									<td style="border:none"></td>
									<td style="border:none"></td>
									<td style="border:none"></td>
									<td style="border:none"></td>
									<td style="border:none"></td>
									<td style="padding-left:50px"><b>Grand Total</b></td>
									<td style="text-align:center">
										Rp. <?= number_format($total - $_POST['add_discount'],2)?>
									</td>
								</tr>
<?php
	}
?>
							</tfoot>
						</table>
					</div>
				</div>
				<div style="padding-left:40px">
					<div class="row">
						<div class="col-sm-6">
							<h4><b>Note</b></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<p><b>1.  </b><?= $note ?></p>
							<input type="hidden" name="dp" value="<?= $dp ?>">
							<input type="hidden" name="lunas" value="<?= $lunas ?>">
							<input type="hidden" name="terms" value="<?= $terms ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<p><b>2. </b>Prices and availability are subject to change at any time without prior notice.</p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<p><b>3. </b>Prices mentioned above are tax-included.</p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<input type='hidden' name="comment" value='<?= $comment ?>'>
							<?= $comment ?>
						</div>
					</div>
				</div>
				<br>
				<div class="row" style="top:50px;padding-left:50px">
					<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">Proceed</button>
				</div>				
				<div id="myModal" class="modal" role="dialog">
					<div class="modal-dialog">	
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Proceeding Quotation</h4>
							</div>
							 <div class="modal-body">
								<h3>Disclaimer</h3>
								<p>By clicking on submit button, you are responsible for any risk quoting this quotation</p>
								<p><b>Please check a couple of times if you must</b></p>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success">Submit</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class='col-sm-1' style='background-color:#333'>
			</div>
		</div>
	</form>
</div>