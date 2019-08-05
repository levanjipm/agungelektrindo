<?php
	include('accountingheader.php');
	if(empty($_POST['invoice_id'])){
?>
	<script>
		window.location.href='accounting.php';
	</script>
<?php
	}
	$invoice_id = $_POST['invoice_id'];
	$sql_invoice = "SELECT name,faktur,do_id FROM invoices WHERE id = '" . $invoice_id . "'";
	$result_invoice = $conn->query($sql_invoice);
	$invoice = $result_invoice->fetch_assoc();
	
	$sql_code_delivery_order = "SELECT customer_id, so_id FROM code_delivery_order WHERE id = '" . $invoice['do_id'] . "'";
	$result_code_delivery_order = $conn->query($sql_code_delivery_order);
	$code_do = $result_code_delivery_order->fetch_assoc();
	
	$so_id = $code_do['so_id'];
	$customer_id = $code_do['customer_id'];
	
	$sql_customer = "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	
	$faktur = $invoice['faktur'];
	$invoice_name = $invoice['name'];
?>
<script src='../Universal/Numeral-js-master/numeral.js'></script>
<style>
	.btn-transparent{
		border:none;
		background-color:transparent;
	}
</style>
<div class='main'>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
	<form method='POST' action='edit_invoice.php' id='myForm'>
	<h2 style='font-family:bebasneue'>Edit invoice</h2>
	<h3 style='font-family:bebasneue'><?= $customer['name'] ?></h3>
	<p><?= $invoice['name'] ?></p>
	<hr>
<?php
	if($faktur != ''){
?>
	<label>Faktur pajak</label>
	<input type='text' class='form-control' id='piash' name='faktur' value='<?= $faktur ?>'>
	<script>
		$("#piash").inputmask("999.999.99-99999999");
	</script>
<?php
	}
?>
	<br>
	<table class='table'>
		<tr>
			<th style='width:20%'>Reference</th>
			<th style='width:25%'>Description</th>
			<th style='width:10%'>Quantity</th>
			<th style='width:20%'>Price</th>
			<th style='width:20%'>Total</th>
		</tr>
<?php
	$total = 0;
	$i = 1;
	$sql_delivery = "SELECT ongkir FROM invoices WHERE id = '" . $invoice_id . "'";
	$result_delivery = $conn->query($sql_delivery);
	$delivery = $result_delivery->fetch_assoc();
	$delivery_fee = $delivery['ongkir'];
	$sql_do = "SELECT reference,quantity FROM delivery_order WHERE do_id = '" . $invoice['do_id'] . "'";
	$result_do = $conn->query($sql_do);
	while($do = $result_do->fetch_assoc()){		
		$sql_invoice = "SELECT price,price_list,discount FROM sales_order WHERE so_id = '" . $so_id . "' AND reference = '" . $do['reference'] . "'";
		$result_invoice = $conn->query($sql_invoice);
		$row_invoice = $result_invoice->fetch_assoc();
?>
		<tr>
			<td>
				<?= $do['reference']; ?>
			</td>
			<td><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $do['reference'] . "' LIMIT 1";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td>
				<?= $do['quantity'] ?>
			</td>
			<td>
				<p>Rp. <?= number_format($row_invoice['price'],2) ?></p>
			</td>
			<td>
				<p>Rp. <?= number_format($row_invoice['price'] * $do['quantity'],2) ?></p>
			</td>
		</tr>
<?php
	$total += $row_invoice['price'] * $do['quantity'];
	$i++;
	}
?>
		<tfoot>
			<tr>
				<td style='background-color:white;border:none' colspan='2'></td>
				<td colspan='2'>Sub total</td>
				<td>Rp. <?= number_format($total,2) ?></td>
			</tr>
			<tr>
				<td style='background-color:white;border:none' colspan='2'></td>
				<td colspan='2'>Delivery fee</td>
				<td>
					<button type='button' class='btn-transparent' id='delivery_fee_button'>Rp. <?= number_format($delivery_fee,2) ?></button>
					<input type='number' class='form-control' id='delivery_fee_input' style='display:none' onblur='hide_delivery_input()'>
				</td>
			</tr>
			<tr>
				<td style='background-color:white;border:none' colspan='2'></td>
				<td colspan='2'>Grand total</td>
				<td id='grand_total_invoice'>Rp. <?= number_format($delivery_fee + $total,2) ?></td>
			</tr>
		</tfoot>
	</table>
	<br>
	<input type='hidden' value='<?= $i ?>' name='x'>
	<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
	</form>
	<button type='button' class='btn btn-secondary' id='edit_invoice_button'>Edit Invoice</button>
</div>
<script>
var grand_total_value = 0;
$('#delivery_fee_button').click(function(){
	$(this).hide();
	$('#delivery_fee_input').show();
	$('#delivery_fee_input').focus();
});
function hide_delivery_input(){
	$('#delivery_fee_input').hide();
	$('#delivery_fee_button').show();
	var delivery_fee_value = $('#delivery_fee_input').val();
	grand_total_value = parseInt($('#delivery_fee_input').val()) + <?= $total ?>;
	$('#delivery_fee_button').text('Rp. ' + numeral(delivery_fee_value).format('0,0.00'));
	$('#grand_total_invoice').text('Rp. ' + numeral(grand_total_value).format('0,0.00'));
};
$('#edit_invoice_button').click(function(){
	$.ajax({
		url:'edit_invoice.php',
		data:{
			invoice_id : "<?= $invoice_id ?>",
			delivery : $('#delivery_fee_input').val(),
			faktur : $('#piash').val(),
		},
		success:function(){
			window.location.href='edit_invoice_dashboard.php';
		},
		type:'POST',
	})
});
</script>