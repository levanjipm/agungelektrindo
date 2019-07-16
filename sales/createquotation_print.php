<?php
	include("../codes/connect.php");
	$q_id = $_POST['id'];
	$sql = "SELECT * FROM code_quotation WHERE id = '" . $q_id . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$q_name = $row['name'];
	$customer = $row['customer_id'];
	$q_date = $row['date'];
	$additional_discount = $row['additional_discount'];
	$payment_id = $row['payment_id'];
	$dp = $row['down_payment'];
	$lunas = $row['repayment'];
	$note = $row['note'];
	
	$sql_customer = "SELECT * FROM customer WHERE id = '" . $customer . "'";
	$result = $conn->query($sql_customer);
	$row = $result->fetch_assoc();
	$customer_name = $row['name'];
	$customer_address = $row['address'];
	$customer_city = $row['city'];
	$customer_phone = $row['phone'];
	$customer_pic_prefix = $row['prefix'];
	$customer_pic = $row['pic'];
?>
<head>
	<title><?= strtoupper($q_name . " " .$customer_name) ?></title>
	<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
	<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
</head>
<body>
	<div class="row">
		<div class="col-sm-2" style="background-color:#eee">
		</div>
		<div class="col-sm-8" id="printable">
			<div class="row">
				<div class="col-sm-8 offset-sm-2">
					<img src="../universal/images/Logo Agung.jpg" style="width:100%"></img>
				</div>
			</div>
			<?php				
				
			?>
			<div class="row">
				<div class="col-sm-6 offset-sm-3">
					<h2 style="text-align:center"><b>Quotation</b></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 offset-sm-3">
					<h4 style="text-align:center"><?= $q_name?></h4>
				</div>
			</div>
			<br><br><br>
			<div class="container">
				<div class="row">
					<div class="col-sm-5">
						<p>Kepada Yth. <b><?= $customer_name?></b></p>
						<p><?= $customer_address?></p>
						<p><?= $customer_city?></p>
						<p><?= $customer_phone?></p>
						<p>Untuk perhatian:<?php echo($customer_pic_prefix . ' ' . $customer_pic) ?>
					</div>
				</div>
			</div>
			<br><br><br>
			<table class="table">
				<thead>	
					<th style="width:20%;text-align:center">Item Description</th>
					<th style="width:20%;text-align:center">Reference</th>
					<th style="width:20%;text-align:center">Unit price</th>
					<th style="width:20%;text-align:center">Quantity</th>
					<th style="width:30%;text-align:center">Total price</th>
				</thead>
				<tbody>
				<?php 
					$sql_item = "SELECT * FROM quotation WHERE quotation_code = '" . $q_id . "'";
					$result = $conn->query($sql_item);
					$i = 0;
					$total = 0;
					while($row = $result->fetch_assoc()){
						$ref[$i] = $row['reference'];;
						$net_price[$i] = $row['net_price'];
						$quantity[$i] = $row['quantity'];
						$total_price[$i] = $row['quantity'] * $row['net_price'];
						
						$sql_desc = "SELECT description FROM itemlist WHERE reference = '" . $ref[$i] . "'";
						$r = $conn->query($sql_desc);
						$row = $r->fetch_assoc();
						$desc = $row['description'];
						?>
						<tr>
							<td style="text-align:center"><?php if(isset($desc)) echo $desc ?></td>
							<td style="text-align:center"><?= $ref[$i] ?></td>
							<td style="text-align:center">Rp. <?= number_format($net_price[$i],2) ?></td>
							<td style="text-align:center"><?= $quantity[$i] ?></td>
							<td style="text-align:center">Rp. <?= number_format($total_price[$i],2) ?></td>
						</tr>
						<?php
						$total = $total + $total_price[$i];
						$i++;
					}
				?>	
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td><b>Total</b></td>
						<td style="text-align:center">Rp.<?= number_format($total,2) ?></td>
					</tr>
<?php
	if($additional_discount > 0){
?>
					<tr>
						<td style="border:none"></td>
						<td style="border:none"></td>
						<td style="border:none"></td>
						<td>Add. Discount</td>
						<td style="text-align:center">Rp.<?= number_format($additional_discount,2) ?></td>
					</tr>
					<tr>
						<td style="border:none"></td>
						<td style="border:none"></td>
						<td style="border:none"></td>
						<td>Grand Total</td>
						<td style="text-align:center">Rp.<?= number_format($total - $additional_discount,2) ?></td>
					</tr>
<?php
	}
?>	
				</tfoot>
			</table>
			<div class="row">
				<div class="col-sm-12">
					<h4><b>Note</b></h6>
					<p><b>1. </b>
					<?php
						if($payment_id == 1){
							echo ('Cash before delivery');
						} else if($payment_id == 2){
							echo ('Check with ' . $lunas . 'days due date after delivery');
						} else if($payment_id == 3){
							echo ('Payment at ' . $lunas . 'days after delivery');
						} else {
							echo ($dp . '% down payment and repayment after' . $lunas . 'days');
						}
					?>
					</p>
					<p><b>2. </b>Prices and availability are subject to change at any time without prior notice.</p>
					<p><b>3. </b>Prices mentioned above are tax-included.</p>
					<p><?= $note ?></p>
				</div>
			</div>
			<br><br><br><br>
			<div class="row">
				<div class="col-sm-4 offset-sm-1">
					Menyetujui,
				</div>
				<div class="col-sm-3 offset-sm-4">
					Hormat kami,
				</div>
			</div>
			<br><br><br><br>
			<div class="row">
				<div class="col-sm-4 offset-sm-1">
					<?= $customer_name ?>
				</div>
				<div class="col-sm-3 offset-sm-4">
					Marketing Dept.
				</div>
			</div>
			<br><br><br><br>
		</div>
		<div class="col-sm-2" style="background-color:#eee">
		</div>
	</div>
	<div class="row" style="background-color:#333;padding:20px">
		<br><br><br>
		<div class="col-sm-2 offset-sm-5">
			<button class="btn btn-primary hidden-print" type="button" id="print" onclick="printing('printable')">Print</button>
		</div>
	</div>
</body>

<script>
function printing(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>