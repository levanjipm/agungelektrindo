<?php
	include("../codes/connect.php");
	session_start();
	$sql_user = "SELECT name,role,hpp FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user = $conn->query($sql_user);
	$row_user = $result_user->fetch_assoc();
	$name = $row_user['name'];
	
	$q_date 			= $_POST['quotation_date'];
	$dp 				= $_POST['dp'];
	$lunas 				= $_POST['lunas'];
	$terms 				= $_POST['terms'];

	$comment 			= mysqli_real_escape_string($conn,$_POST['comment']);
	$customer 			= $_POST['quote_person'];
	$sql_customer 		= "SELECT * FROM customer WHERE id='" . $customer . "'";
	$result 			= $conn->query($sql_customer);
	$row 				= $result->fetch_assoc();
	$customer_name 		= $row['name'];

	$reference_array	= $_POST['reference'];
	$price_array		= $_POST['price'];
	$discount_array		= $_POST['discount'];
	$quantity_array		= $_POST['quantity'];

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
<head>
	<title>Validate Quotation</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="salesstyle.css">
	<link rel="stylesheet" href="css/create_quotation.css">
</head>
<div class='top_navigation_bar'>
	<div class='col-lg-4 col-md-5 col-sm-6 col-xs-8'>
		<a href='../human_resource/user_dashboard.php' style='text-decoration:none'>
			<img src='../universal/images/agungelektrindo_header.png' style='height:50px;'>
		</a>
	</div>
	<div class='col-lg-2 col-md-3 col-sm-4 col-xs-4 col-lg-offset-6 col-md-offset-4 col-sm-offset-2 col-xs-offset-0' style='text-align:right'>
		<h3 style='font-family:Bebasneue'><?= $name ?> 
			<span style='display:inline-block'>
				<a href='../codes/logout.php' style='padding-left:10px;text-decoration:none;color:white;' title='log out'>
					 <i class="fa fa-sign-out" aria-hidden="true"></i>
				</a>
			</span>
		</h3>
	</div>
</div>
<body style="height:100%;overflow-x:hidden;">
	<form action="createquotation_input.php" method="POST" id="quotation_validate">
		<div class="row" style='height:100%;margin-top:70px'>
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
					$total 	= 0;
					$i 		= 1;
					foreach($reference_array as $reference){
						$key		= key($reference_array);
						$quantity 	= $quantity_array[$key];
						$price	 	= $price_array[$key];
						$discount 	= $discount_array[$key];
						
						$reference_escaped = mysqli_real_escape_string($conn,$reference);
						$netprice = $price * (1 - $discount * 0.01);
						$totprice = $netprice * $quantity;
						$sql = "SELECT description FROM itemlist WHERE reference='" . $reference_escaped . "'";
						$result = $conn->query($sql);
						$row = $result->fetch_assoc();
						if($row == false){
							$desc = " ";
						} else { 
							$desc = $row['description'];
						}
						
						$total += $totprice;
				?>
					<tr>	
						<td style="text-align:center"><?= $desc ?></td>
						<td style="text-align:center"><?= $reference ?></td>						
						<td style="text-align:center">Rp. <?= number_format($price,2) ?></td>
						<td style="text-align:center"><?= $discount . '%' ?></td>
						<td style="text-align:center"><?= $quantity ?></td>
						<td style="text-align:center">Rp. <?= number_format($netprice,2) ?></td>
						<td style="text-align:center">Rp. <?= number_format($totprice,2) ?></td>
					</tr>
					<input type="hidden" value="<?= $reference ?>" name="reference[<?=$i?>]">
					<input type="hidden" value="<?= $price ?>" name="price[<?=$i?>]">
					<input type="hidden" value="<?= $discount ?>" name="discount[<?=$i?>]">
					<input type="hidden" value="<?= $quantity ?>" name="quantity[<?=$i?>]">
				<?php
						next($reference_array);
						$i++;
					}
				?>
					</tbody>
					<tfoot>
						<tr>
							<td style="border:none" colspan='5'></td>
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
					<button type="button" class="button_add_row" id='proceed_button'>Proceed</button>
				</div>				
			</div>
			<div class='col-sm-1' style='background-color:#333'>
			</div>
		</div>
	</form>
</div>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this Quotation?</h2>
		<br>
		<button type='button' class='btn-back'>Back</button>
		<button type='button' class='btn-confirm' id='confirm_quotation_button'>Confirm</button>
	</div>
</div>
<script>
	$('#proceed_button').click(function(){
		$('#confirm_notification').fadeIn();
	});
	
	$('.btn-back').click(function(){
		$('#confirm_notification').fadeOut();
	});
	
	$('#confirm_quotation_button').click(function(){
		$('#quotation_validate').submit();
	});
</script>