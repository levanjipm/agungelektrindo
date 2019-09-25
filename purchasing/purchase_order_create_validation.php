<?php
	include("../Codes/connect.php");
?>
<head>
	<link rel="stylesheet" href="../Universal/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="../Universal/jquery/jquery-3.3.0.min.js"></script>
	<script src="../Universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../Universal/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="purchasingstyle.css">
</head>
<style>
.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
	}
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
		box-shadow: 3px 4px 3px 4px #ddd;
	}
	.btn-confirm{
		background-color:#2bf076;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-x{
		background-color:transparent;
		border:none;
		outline:0!important;
	}
	.btn-x:focus{
		outline: 0!important;
	}
</style
<?php	
	$payement 			= mysqli_real_escape_string($conn,$_POST['top']);
	$po_date 			= mysqli_real_escape_string($conn,$_POST['today']);
	$vendor 			= mysqli_real_escape_string($conn,$_POST['selectsupplier']); //Supplier id//
		
	$sent_date 			= mysqli_real_escape_string($conn,$_POST['sent_date']);
	$delivery_date 		= mysqli_real_escape_string($conn,$_POST['delivery_date']);
		
	$note 				= mysqli_real_escape_string($conn,$_POST['note']);
	
	$dropship_name 		= mysqli_real_escape_string($conn,$_POST['dropship_name']);
	$dropship_address 	= mysqli_real_escape_string($conn,$_POST['dropship_address']);
	$dropship_city 		= mysqli_real_escape_string($conn,$_POST['dropship_city']);
	$dropship_phone 	= mysqli_real_escape_string($conn,$_POST['dropship_phone']);
	
	$sql_vendor 		= "SELECT name,address,city FROM supplier WHERE id='" . $vendor . "'";
	$r 					= $conn->query($sql_vendor);
	$rows 				= $r->fetch_assoc();
	$vendor_name 		= $rows['name'];
	$vendor_address 	= $rows['address'];
	$vendor_city 		= $rows['city'];
	
	$address_choice 	= $_POST['optradio'];
	$code_promo 		= $_POST['code_promo'];
	
	$reference_array	= $_POST['reference'];
	$price_array		= $_POST['price'];
	$discount_array		= $_POST['discount'];
	$quantity_array		= $_POST['quantity'];
	
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	$guid = GUID();
	
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
<body>
<body style='width:100%'>
<div class='row' style='margin:0'>
	<div class='col-sm-1' style='background-color:#333'>
	</div>
	<div class='col-sm-10' style='padding:12px'>
		<form action="purchase_order_create_input.php" method="POST" id='create_po_validation_form'>
			<h2 style="font-family:bebasneue">Purchase Order</h2>
			<p>Validate purchase order</p>
			<hr>
			<input type="hidden" value="<?= $po_number ?>" name="po_number">
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
					<h4 style='font-family:bebasneue'><?= $po_number ?></h4><br>
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
			<br>
			<hr>
			<label>GUID</label>
			<p><?= $guid ?></p>
			<input type='hidden' value='<?= $guid ?>' name='guid'>
			<label>Taxing option</label>
			<select class='form-control' name='taxing' id='taxing' style='width:50%'>
				<option value='0'>Please select taxing option for this purchase</option>
				<option value='1'>Tax</option>
				<option value='2'>Non-tax</option>
			</select>
			<hr>
			<table class="table table-hover">
				<thead>
					<th style='width:30%'>Item Description</th>
					<th style='width:10%'>Reference</th>
					<th style='width:15%'>Unit price</th>
					<th style='width:5%'>Discount</th>
					<th style='width:10%'>Quantity</th>
					<th style='width:15%'>Price after discount</th>
					<th style='width:15%'>Total price</th>
				</thead>	
				<tbody>
<?php
					$total = 0;
					$i = 1;
					foreach($reference_array as $reference){
						$key = key($reference_array);
						$price			= $price_array[$key];
						$discount		= $discount_array[$key];
						$quantity		= $quantity_array[$key];
						
						$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $reference . "'";
						$result_item	= $conn->query($sql_item);
						$item			= $result_item->fetch_assoc();
						
						$net_price 		= $price * (100 - $discount) * 0.01;
						$total_price	= $quantity * $net_price;
						
						$total += $total_price;
						
						$description	= $item['description'];
?>

					<tr>
						<td><?= $description ?></td>
						<td>
							<?= $reference ?>
							<input class="hidden" for="reference" value= "<?=$reference?>" readonly name='reference[<?=$i?>]'>
						</td>
						<td>
							Rp. <?= number_format($price,0) ?>
							<input class="hidden" value="<?= $price?>" name='price[<?=$i?>]'>
						</td>
						<td>
							<?= $discount ?> %
							<input type='hidden' for="discount" value="<?= $discount ?>" readonly name='discount[<?=$i?>]'>
						</td>
						<td style="width:5%">
							<?= number_format($quantity,0) ?>
							<input type="hidden" value="<?=$quantity?>" name='quantity[<?=$i?>]'>
						</td>
						<td>Rp. <?= number_format($net_price,2) ?></td>
						<td>Rp. <?= number_format($total_price,2) ?></td>
					</tr>
<?php
						$i++;
						next($reference_array);
					}
?>
				</tbody>
				<tr>
					<td style='background-color:white;border:none' colspan='5'></td>
					<td>Grand Total</td>
					<td>Rp. <?= number_format($total,2) ?></td>
				</tr>
			</table>
			<br>
			<?= $note ?>
			<div class="row" style="top:50px;padding:20px">
				<button type="button" class="button_default_dark" onclick='taxing_check()'>Proceed</button>
			</div>
		</form>
	</div>
	<div class='col-sm-1' style='background-color:#333'>
	</div>
</div>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this purchase order</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-confirm' id='confirm_button'>Confirm</button>
	</div>
</div>
</body>
</html>
<script>
	function taxing_check(){
		if($('#taxing').val() == 0){
			alert('Insert taxing option');
			return false;
		} else {
			$('#confirm_notification').fadeIn();
		}
	}
	$('.btn-back').click(function(){
		$('#confirm_notification').fadeOut();
	});
	$('#confirm_button').click(function(){
		$('#create_po_validation_form').submit();
	});
</script>
