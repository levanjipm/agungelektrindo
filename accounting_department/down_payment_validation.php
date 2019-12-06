<?php
	include('accountingheader.php');
	$customer_id = mysqli_real_escape_string($conn,$_POST['select_customer']);
	$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	
	$reference_array = $_POST['reference'];
	$quantity_array = $_POST['qty'];
	$vat_array = $_POST['vat'];
	$pl_array = $_POST['pl'];
	$disc_array = $_POST['disc'];
	
	$taxing = $_POST['taxing'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Random Invoice</h2>
	<p>Validate down payment invoice</p>
	<hr>
	<form action='down_payment_input.php' method='POST' id='down_payment_form'>
	<h4 style='font-family:bebasneue'><?= $customer['name'] ?></h4>
	<input type='hidden' value='<?= $customer_id ?>' name='customer' readonly>
	<input type='hidden' value='<?= mysqli_real_escape_string($conn,$_POST['purchaseordernumber']) ?>' name='po_number' readonly>
	<p><strong>PO number</strong>: <?= mysqli_real_escape_string($conn,$_POST['purchaseordernumber']) ?></p>
	<table class='table table-hover'>
		<tr>
			<th style='width:30%'>Reference</th>
			<th style='width:20%'>Quantity</th>
			<th style='width:25%'>Unit price</th>
			<th style='width:25%'>Total price</th>
		</tr>
<?php
	$i = 1;
	$grand_total = 0;
	foreach($reference_array as $reference_escape){
		$key = array_search($reference_escape, $reference_array);
		$quantity = $quantity_array[$key];
		$vat = $vat_array[$key];
		$pl = $pl_array[$key];
		$disc = $disc_array[$key];
		$total = $vat * $quantity;
		$reference = mysqli_real_escape_string($conn,$reference_escape);
?>
		<tr>
			<td>
				<?= $reference ?>
				<input type='hidden' value='<?= $reference ?>' name='reference[<?= $i ?>]' readonly>
			</td>
			<td>
				<?= $quantity ?>
				<input type='hidden' value='<?= $quantity ?>' name='quantity[<?= $i ?>]' readonly>
			</td>
			<td>
				Rp. <?php if($taxing == 1){ echo number_format($vat/1.1,2); } else { echo number_format($vat,2);}  ?>
				<input type='hidden' value='<?= $vat ?>' name='vat[<?= $i ?>]' readonly>
				<input type='hidden' value='<?= $pl ?>' name='pl[<?= $i ?>]' readonly>
				<input type='hidden' value='<?= $disc ?>' name='disc[<?= $i ?>]' readonly>
			</td>
			<td>
				Rp. <?php if($taxing == 1){ echo number_format($total/1.1,2); } else { echo number_format($total,2);}  ?>
			</td>
		</tr>
<?php
	$grand_total = $grand_total + $total;
	$i++;
	}
	if($taxing == 1){
?>
		<tr>
			<td style='background-color:white;border:none' colspan='2'></td>
			<td>Sub total</td>
			<td>Rp. <?= number_format($grand_total/1.1,2) ?></td>
		</tr>
		<tr>
			<td style='background-color:white;border:none' colspan='2'></td>
			<td>PPn</td>
			<td>Rp. <?= number_format($grand_total - $grand_total/1.1,2) ?></td>
		</tr>
<?php
	}
?>
		<tr>
			<td style='background-color:white;border:none' colspan='2'></td>
			<td>Total</td>
			<td>Rp. <?= number_format($grand_total,2) ?></td>
		</tr>
		<tr>
			<td style='background-color:white;border:none' colspan='2'></td>
			<td>Down payment</td>
			<td><input type='number' class='form-control' step='0.01' name='down_payment_value' id='down_payment_value' max='<?= $grand_total ?>'></td>
		</tr>
	</table>
	</form>
	<button type='button' class='btn btn-default' id='submit_down_payment'>Submit</button>
</div>
<script>
	$('#submit_down_payment').click(function(){
		if($('#down_payment_value').val() >= <?= $grand_total ?>){
			alert('Exceed maximum down payment!');
			return false;
		} else if($('#down_payment_value').val() == 0 || $('#down_payment_value').val() == ''){
			alert('Cannot insert blank value!');
			return false;
		} else {
			$('#down_payment_form').submit();
		}
	});
</script>