<?php
	include('../codes/connect.php');
	
	$quotation_id 			= $_POST['id'];
	$sql 					= "SELECT code_quotation.*, customer.name as customer_name, customer.address, customer.city
								FROM code_quotation 
								JOIN customer ON code_quotation.customer_id = customer.id
								WHERE code_quotation.id = '$quotation_id'";
	$result 				= $conn->query($sql);
	$code 					= $result->fetch_assoc();
	$additional_discount 	= $code['additional_discount'];
	$note 					= $code['note'];
	$quotation_name			= $code['name'];
	$quotation_date			= $code['date'];
	
	$customer_name			= $code['customer_name'];
	$customer_address		= $code['address'];
	$customer_city			= $code['city'];
?>
	<label>Quotation</label>
	<p style='font-family:museo'><?= $quotation_name ?></p>
	<p style='font-family:museo'><?= date('d M Y',strtotime($quotation_date)) ?></p>
	
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<table class='table table-bordered'>
		<tr>
			<th style='width:10%'>Reference</th>
			<th style='width:15%'>Description</th>
			<th style='width:20%'>Price list</th>
			<th style='width:5%'>Disc.</th>
			<th style='width:20%'>Price</th>
			<th style='width:5%'>Qty</th>
			<th style='width:20%'>Total price</th>
		</tr>
<?php
	$total = 0;
	$sql_detail 		= "SELECT quotation.*, itemlist.description FROM quotation
							JOIN itemlist ON quotation.reference = itemlist.reference
							WHERE quotation.quotation_code = '$quotation_id'";
	$result_detail 		= $conn->query($sql_detail);
	while($detail 		= $result_detail->fetch_assoc()){
		$reference		= $detail['reference'];
		$description	= $detail['description'];
		$price_list		= $detail['price_list'];
		$discount		= $detail['discount'];
		$quantity		= $detail['quantity'];
		$net_price		= $detail['net_price'];
		
		$total_price	= $net_price * $quantity;
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td>Rp. <?= number_format($price_list,2) ?></td>
			<td><?= number_format($discount,2) ?>%</td>
			<td>Rp. <?= number_format($net_price,2) ?></td>
			<td><?= $quantity ?></td>
			<td>Rp. <?= number_format($total_price,2) ?></td>
		</tr>
<?php
		$total = $total + $detail['quantity'] * $detail['net_price'];
	}
?>
		<tr>
			<td style='border:none' colspan='4'></td>
			<td colspan='2'>Total</td>
			<td><strong>Rp. <?= number_format($total,2) ?></td>
		</tr>
<?php
	if($additional_discount > 0){
?>
		<tr>
			<td style='border:none' colspan='4'></td>
			<td colspan='2'>Add. Disc.</td>
			<td><strong>Rp. <?= number_format($additional_discount,2) ?></td>
		</tr>
		<tr>
			<td style='border:none' colspan='4'></td>
			<td colspan='2'>Grand Total</td>
			<td><strong>Rp. <?= number_format($total - $additional_discount,2) ?></td>
		</tr>
<?php
	}
?>
	</table>
	<label>Note</label>
	<p style='font-family:museo'><?= $note ?></p>
	
	<form action='quotation_create_print' method='POST' target='_blank'>
		<input type='hidden' value='<?= $quotation_id ?>' name='id'>
		<button type='submit' class='button_success_dark' id='print_quotation_button'><i class='fa fa-print'></i></button>
	</form>