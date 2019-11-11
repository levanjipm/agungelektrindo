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
$reference_array	= $_POST['reference'];
$quantity_array		= $_POST['quantity'];
$vat_array			= $_POST['vat'];
$pl_array			= $_POST['pl'];

$so_date			= $_POST['today'];
$taxing 			= $_POST['taxing'];
$po_number 			= mysqli_real_escape_string($conn,$_POST['purchaseordernumber']);
$customer 			= $_POST['select_customer'];
if($customer == NULL){
	$address 		= $_POST['retail_address'];
	$city 			= $_POST['retail_city'];
	$phone 			= $_POST['retail_phone'];
	$name 			= $_POST['retail_name'];
} else {
	$address 		= '';
	$city 			= '';
	$phone 			= '';
	$name 			= '';
}
$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $customer . "'";
$result_customer 	= $conn->query($sql_customer);
$customer_row		= $result_customer->fetch_assoc();
$customer_name 		= $customer_row['name'];
?>
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
		padding:5px 10px;
		border:none;
		outline:none;
	}
	
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
		padding:5px 10px;
		border:none;
		outline:none;
	}
</style>
<body style='overflow-x:hidden'>
	<form action="sales_order_create_input" method="POST" id='sales_order_form'>
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
						<table class="table table-bordered">
							<thead>
								<tr>
									<th style='text-align:center'>Reference</th>
									<th style='text-align:center'>V.A.T.</th>
									<th style='text-align:center'>Discount</th>
									<th style='text-align:center'>Quantity</th>
									<th style='text-align:center'>Price List</th>
									<th style='text-align:center'>Total price</th>
								</tr>
							</thead>	
							<tbody>
<?php
							$i = 1;
							$total_sales_order = 0;
							foreach($reference_array as $reference){
								$key 		= key($reference_array);
								$quantity 	= $quantity_array[$key];
								$vat 		= $vat_array[$key];
								$pl 		= $pl_array[$key];
								
								$discount	= 100 - ($vat * 100/$pl);
								$total_price = $vat * $quantity;
?>
							<tr style="text-align:center">	
								<td><?= $reference ?></td>						
								<td>Rp. <?= number_format($vat,2) ?></td>
								<td><?= number_format($discount,2) . '%' ?></td>
								<td><?= $quantity ?></td>
								<td>Rp. <?= number_format($pl,2) ?></td>
								<td>Rp. <?= number_format($total_price,2) ?></td>
							</tr>
							<input type='hidden' value="<?= $reference ?>" 	name="reference[<?=$i?>]">
							<input type='hidden' value="<?= $vat ?>" 		name="value_after_tax[<?=$i?>]">
							<input type='hidden' value="<?= $quantity ?>" 	name="quantity[<?=$i?>]">
							<input type='hidden' value="<?= $pl ?>" 		name="price_list[<?=$i?>]">
						<?php
								$i++;
								$total_sales_order += $total_price;
								next($reference_array);
							}
						?>
							</tbody>
							<tfoot>
								<tr>
									<td style="border:none" colspan='4'></td>
									<td style="padding-left:50px"><b>Grand Total</b></td>
									<td style="text-align:center">Rp. <?= number_format($total_sales_order,2)?></td>
								</tr>
							</tfoot>
						</table>
						<label>Note</label>
						<textarea name="sales_order_note" class='form-control' style='resize:none' rows='5'></textarea>
					</div>
				</div>
				<br><br>
				<button type="button" class="button_success_dark" id='next_button'>Next</button>
				<br>
				<br>
			</div>
			<div class='col-sm-1' style='background-color:#333'>
		</div>
		</div>
	</form>
</body>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this Sales Order?</h2>
		<br>
		<button type='button' class='btn-back'>Back</button>
		<button type='button' class='btn-confirm' id='confirm_sales_order_button'>Confirm</button>
	</div>
</div>
<script>
	$('#next_button').click(function(){
		$('#confirm_notification').fadeIn();
	});
	
	$('.btn-back').click(function(){
		$('#confirm_notification').fadeOut();
	});
	
	$('#confirm_sales_order_button').click(function(){
		$('#sales_order_form').submit();
	});
</script>