<?php
	include("../Codes/connect.php");
?>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<?php	
	$payement = mysqli_real_escape_string($conn,$_POST['top']);
	$po_date = mysqli_real_escape_string($conn,$_POST['today']);
	$vendor = mysqli_real_escape_string($conn,$_POST['selectsupplier']); //Supplier id//
	
	$sent_date = mysqli_real_escape_string($conn,$_POST['sent_date']);
	$delivery_date = mysqli_real_escape_string($conn,$_POST['delivery_date']);
	
	$note = mysqli_real_escape_string($conn,$_POST['note']);
	
	$dropship_name = mysqli_real_escape_string($conn,$_POST['dropship_name']);
	$dropship_address = mysqli_real_escape_string($conn,$_POST['dropship_address']);
	$dropship_city = mysqli_real_escape_string($conn,$_POST['dropship_city']);
	$dropship_phone = mysqli_real_escape_string($conn,$_POST['dropship_phone']);
	
	$sql_vendor = "SELECT name,address,city FROM supplier WHERE id='" . $vendor . "'";
	$r = $conn->query($sql_vendor);
	$rows = $r->fetch_assoc();
	$vendor_name = $rows['name'];
	$vendor_address = $rows['address'];
	$vendor_city = $rows['city'];
	
	$total = mysqli_real_escape_string($conn,$_POST['total']);
	$address_choice = $_POST['optradio'];
	$code_promo = $_POST['code_promo'];
	
	$sql = " SELECT COUNT(*) AS jumlah FROM code_purchaseorder WHERE MONTH(date) = MONTH('" . $po_date . "') AND YEAR(date) = YEAR('" . $po_date . "')";
	$result = $conn->query($sql);
	if(mysqli_num_rows($result) > 0){	
		$row = $result->fetch_assoc();
		$jumlah = $row['jumlah'];
	} else {
		$jumlah = 0;
	}
	$jumlah++;
	
	if (date('m',strtotime($po_date)) == '01'){
		$month = 'I';
	} else if(date('m',strtotime($po_date)) == '02'){
		$month = 'II';
	} else if(date('m',strtotime($po_date)) == '03'){
		$month = 'III';
	} else if(date('m',strtotime($po_date)) == '04'){
		$month = 'IV';
	} else if(date('m',strtotime($po_date)) == '05'){
		$month = 'V';
	} else if(date('m',strtotime($po_date)) == '06'){
		$month = 'VI';
	} else if(date('m',strtotime($po_date)) == '07'){
		$month = 'VII';
	} else if(date('m',strtotime($po_date)) == '08'){
		$month = 'VIII';
	} else if(date('m',strtotime($po_date)) == '09'){
		$month = 'IX';
	} else if (date('m',strtotime($po_date)) == '10'){
		$month = 'X';
	} else if(date('m',strtotime($po_date)) == '11'){
		$month = 'XI';
	} else {
		$month = 'XII';
	}
	$po_number = "PO-AE-" . str_pad($jumlah,2,"0",STR_PAD_LEFT) . "." . date("d",strtotime($po_date)). "-" . $month . "-" . date("y",strtotime($po_date));
?>
<body style='overflow-x:hidden'>
<div class='row'>
	<div class='col-sm-1' style='background-color:#ddd'>
	</div>
	<div class='col-sm-10' style='padding:12px'>
		<form action="createpurchaseorder_input.php" method="POST">
			<div class="row">
				<div class="col-lg-6 offset-lg-3">
					<h2 style="text-align:center"><?= $po_number?></h2>
					<input type="hidden" value="<?= $po_number ?>" name="po_number">
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<input type='hidden' value='<?= $dropship_name ?>' name='dropship_name'>
					<input type='hidden' value='<?= $dropship_address ?>' name='dropship_address'>
					<input type='hidden' value='<?= $dropship_city ?>' name='dropship_city'>
					<input type='hidden' value='<?= $dropship_phone ?>' name='dropship_phone'>
					<input type='hidden' value='<?= $note ?>' name='note'>
					<input type='hidden' value='<?= $sent_date ?>' name='sent_date'>
					<input type='hidden' value='<?= $delivery_date ?>' name='delivery_date'>
					<input type='hidden' value='<?= $address_choice ?>' name='address_choice'>
					<input type='hidden' value='<?= $note ?>' name='note'>
					<input type='hidden' value= "<?= $vendor ?>" readonly name="vendor">
					<input type='hidden' value="<?= $payement ?>" readonly name="top">
					<input type="hidden" for="promo_code"value = "<?= $code_promo ?>" readonly name="code_promo">
					<input type="hidden" for="po_date"value = "<?= $po_date ?>" readonly name="po_date">
					<strong><?= $vendor_name ?></strong><br>
					<?= $vendor_address ?><br>
					<?= $vendor_city ?><br>
					<strong>Payment terms:</strong> <?= $payement ?> days.<br>
					<strong>Promo code:</strong> <?= $code_promo ?><br>

				<strong>Delivery date: </strong><?php if($sent_date == 1){ echo (date('d M Y',strtotime($delivery_date))); } ?>
				<br>
				<strong>Delivery address: </strong>
<?php
	if($address_choice == 1){
					echo ('Jalan Jamuju no. 18, Bandung');
	} else {
					echo ($dropship_name);
					echo ($dropship_address);
					echo ($dropship_city);
					echo ($dropship_phone);
	}
?>					
					
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
					<select class='form-control' name='taxing' id='taxing'>
						<option value='0'>Please select taxing option for this purchase</option>
						<option value='1'>Tax</option>
						<option value='2'>Non-tax</option>
					</select>
				</div>
				<br><br>
				<div class='col-sm-12'>
					<table class="table">
						<thead>
							<th>Item Description</th>
							<th>Reference</th>
							<th>Unit price</th>
							<th>Discount</th>
							<th>Quantity</th>
							<th>Price after discount</th>
							<th>Total price</th>
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
								<td style="width:30%">
									<?=$desc?>
								</td>
								<td style="width:10%">
									<?= $ref ?>
									<input class="hidden" for="ref" value= "<?=$ref?>" readonly name='item<?=$i?>'>
								</td>
								<td style="width:15%">
									Rp. <?= number_format($price,0) ?>
									<input class="hidden" value="<?= $price?>" name='price<?=$i?>'>
								</td>
								<td style="width:6%">
								<?= $disc ?> %
									<input type='hidden' for="disc" value="<?=$disc?>" readonly name='discount<?=$i?>'>
								</td>
								<td style="width:5%">
									<?= number_format($qty,0) ?>
									<input type="hidden" value="<?=$qty?>" name='quantity<?=$i?>'>
								</td>
								<td style="width:15%">
									Rp. <?= number_format($netprice,2) ?>
									<input type="hidden" name='netprice<?=$i?>' value="<?= $netprice ?>">
								</td>
								<td style="width:15%">
									Rp. <?= number_format($totprice,2) ?>
									<input type="hidden" value="<?= $totprice?>" name='totprice<?=$i?>'>
								</td>
							</tr>
		<?php
			}
		?>
						</tbody>
					</table>
				</div>
			</div>
			<div style="padding:5px;right:10px">
				<div class="row">
					<div class="col-lg-2 offset-lg-8">
						<h4 style="text-align:right"><b>Grand Total</b></h4>
					</div>
					<div class="col-lg-2">
						Rp. <?= number_format($total,2) ?>
						<input class="hidden" id="total" value=" <?= $total ?>" name='total'>
					</div>
				</div>
			</div>
			<br>
			<?= $note ?>
			<div class="row" style="top:50px;padding:20px">
				<button type="button" class="btn btn-primary" onclick='taxing_check()'>Proceed</button>
			</div>
			<div id="myModal" class="modal" role="dialog">
				<div class="modal-dialog">	
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Proceeding Purchase Order</h4>
						</div>
						 <div class="modal-body">
							<h3>Disclaimer</h3>
							<p>By clicking on submit button, you are responsible for any risk on ordering this purchase order</p>
							<p>Please check a couple of times if you must</p>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-success">Submit</button>
							<button type="button" class="btn btn-default" onclick='hide_modal()'>Close</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class='col-sm-1' style='background-color:#ddd'>
	</div>
</div>
</body>
</html>
<script>
	function taxing_check(){
		if($('#taxing').val() == 0){
			alert('Insert taxing option');
		} else {
			$('#myModal').show();
		}
	}
	function hide_modal(){
		$('#myModal').hide();
	}
</script>
