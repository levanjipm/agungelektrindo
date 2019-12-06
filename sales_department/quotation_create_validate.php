<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	$sql_user 			= "SELECT name,role,hpp FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user 		= $conn->query($sql_user);
	$row_user 			= $result_user->fetch_assoc();
	$name 				= $row_user['name'];
	
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
	
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	$guid = GUID();
?>
<body>
<div class='main'>
	<form action="quotation_create_input" method="POST" id="quotation_validate">
		<h2 style='font-family:bebasneue'>Quotation</h2>
		<p>Validate quotation</p>
		<hr>
		<input type="hidden" value="<?= $q_date ?>" name="today">
		<input type="hidden" value='<?= $customer?>' name="customer">
		<label>Customer</label>
		<p style='font-family:museo'><?= $customer_name ?></p>
		<label>Quotation date</label>
		<p style='font-family:museo'><?= date('d M Y',strtotime($q_date)) ?></p>
		<label>GUID</label>
		<p style='font-family:museo'><?= $guid?></p>
		<input type='hidden' value='<?= $guid ?>' name='GUID'>
		<br>
		<table class='table table-bordered'>
			<thead>
				<th style='text-align:center;width:20%'>Item Description</th>
				<th style='text-align:center;width:10%'>Reference</th>
				<th style='text-align:center;width:15%'>Unit price</th>
				<th style='text-align:center;width:5%'>Discount</th>
				<th style='text-align:center;width:10%'>Quantity</th>
				<th style='text-align:center;width:15%'>Price after discount</th>
				<th style='text-align:center;width:15%'>Total price</th>
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
					<td style="border:none" colspan='5'></td>
					<td style="padding-left:50px"><b>Additional Disc.</b></td>
					<td style="text-align:center">
						Rp. <?= number_format($_POST['add_discount'],2)?>
					</td>
				</tr>
				<tr>
					<td style="border:none" colspan='5'></td>
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
		<div class='row'>
			<div class='col-sm-12'>
				<h4 style='font-family:museo'>Note</h4>
				<ol>
					<li><p style='font-family:museo'><?= $note ?></p></li>
					<li><p style='font-family:museo'>Prices and availability are subject to change at any time without prior notice.</p></li>
					<li><p style='font-family:museo'>Prices mentioned above are tax-included.</p></li>
					<?php if(!empty($comment)){ ?>
					<li><p style='font-family:museo'><?= $comment ?></p>
					<?php } ?>
				</ol>
				<input type="hidden" name="dp" value="<?= $dp ?>">
				<input type="hidden" name="lunas" value="<?= $lunas ?>">
				<input type="hidden" name="terms" value="<?= $terms ?>">
				<input type="hidden" name="comment" value="<?= $comment ?>">
				<button type="button" class="button_success_dark" id='proceed_button'>Proceed</button>
			</div>
		</div>
	</form>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:3em;color:green'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to confirm this quotation?</p>
		<button type='button' class='button_danger_dark' id='close_notification_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_quotation_button'>Confirm</button>
	</div>
</div>
<script>
	$('#proceed_button').click(function(){
		var window_height			= $(window).height();
		var bar_height				= $('.full_screen_notif_bar').height();
		var difference				= window_height - bar_height;
		$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn();
	});
	
	$('#close_notification_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#confirm_quotation_button').click(function(){
		$('#quotation_validate').submit();
	});
</script>