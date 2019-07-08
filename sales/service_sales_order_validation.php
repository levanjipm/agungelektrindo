<?php
	include('salesheader.php');
	$customer_id = mysqli_real_escape_string($conn,$_POST['customer']);
	$sql_customer = "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	$po_number = mysqli_real_escape_string($conn,$_POST['po_name']);
	$date = $_POST['date'];
	$tax = $_POST['tax'];
	$seller = $_POST['seller'];
	
	$descriptions = $_POST['descriptions'];
	$quantities = $_POST['quantities'];
	$prices = $_POST['prices'];	
?>
<div class='main'>
	<form action='service_sales_order.php' method='POST' id='service_sales_order_form'>
	<input type='hidden' value='<?= $seller ?>' name='seller'>
	<input type='hidden' value='<?= $tax ?>' name='tax'>
	<input type='hidden' value='<?= $customer_id ?>' name='customer'>
	<input type='hidden' value='<?= $po_number ?>' name='po_number'>
	<input type='hidden' value='<?= $date ?>' name='date'>
	<h2 style='font-family:bebasneue'>Sales order</h2>
	<p>Service sales order validation</p>
	<hr>
	<?= date('d M Y',strtotime($date)) ?>
	<br>
	<strong>Customer :</strong><?= $customer['name'] ?>
	<br>
	<strong>Purchase Order number :</strong><?= $po_number ?>
	<table class='table'>
		<tr>
			<th>Service name</th>
			<th>Quantity</th>
			<th>Unit price</th>
			<th>Total Price</th>
		</tr>
		
<?php
	$total = 0;
	$i = 1;
	foreach($descriptions as $description){
		$key = array_search($description, $descriptions);
		$quantity = $quantities[$key];
		$price = $prices[$key];
?>
		<tr>
			<td>
				<?= $description ?>
				<input type='hidden' value='<?= $description ?>' name='descriptions[<?= $i ?>]'>
			</td>
			<td>
				<?= $quantity ?>
				<input type='hidden' value='<?= $quantity ?>' name='quantities[<?= $i ?>]'>
			</td>
			<td>
				Rp. <?= number_format($price,2) ?>
				<input type='hidden' value='<?= $price ?>' name='prices[<?= $i ?>]'>
			</td>
			<td>Rp. <?= number_format($quantity * $price,2) ?></td>
		</tr>
<?php
	$total = $total + $price * $quantity;
	$i++;
	}
?>
		<tr>
			<td colspan='2'></td>
			<td>Total</td>
			<td>Rp. <?= number_format($total,2) ?></td>
		</tr>
	</table>
	</form>
	<button type='button' class='btn btn-default'>Submit</button>
</div>
<script>
	$('.btn-default').click(function(){
		$('#service_sales_order_form').submit();
	});
</script>