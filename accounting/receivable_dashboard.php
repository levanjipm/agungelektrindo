<?php
	include('accountingheader.php');
?>
<style>
	.garis{
		height:20px;
		background-color:#2b64bf;
		box-shadow: 2px 2px 4px 2px #888888;
		margin-top:10px;
	}
</style>
<?php
	$maximum = 0;
	$total = 0;
	$sql_initial = "SELECT SUM(value) AS maximum FROM invoices WHERE isdone = '0' GROUP by customer_id";
	$result_initial = $conn->query($sql_initial);
	while($initial = $result_initial->fetch_assoc()){
		if($initial['maximum'] > $maximum){
			$maximum = $initial['maximum'];
		}
		$total = $total + $initial['maximum'];
	}
?>
<div class='main'>
	<div class='container'>
		<div class='row'>
			<div class='col-sm-4'>
				<h2>Account of receivable</h2>
				<p>Rp. <?= number_format($total,2) ?></p>
			</div>
			<div class='col-sm-4'>
				<br>
				<select class='form-control' onchange='change_customer()' id='seleksi'>
					<option value='0'>Please insert customer name to view</option>
<?php
	$sql_select = 'SELECT id,name FROM customer';
	$result_select = $conn->query($sql_select);
	while($select = $result_select->fetch_assoc()){
?>
					<option value='<?= $select['id'] ?>'><?= $select['name'] ?></option>
<?php
	}
?>
				</select>
				<form action='customer_view.php' method='POST' id='customer_form'>
					<input type='hidden' id='customer_to_view' name='customer'>
				</form>
			</div>
			<div class='col-sm-2'>
				<br>
				<button type='button' class='btn btn-default' onclick='submiting()'>
					<i class="fa fa-search" aria-hidden="true"></i>
				</button>
			</div>
		</div>			
		<hr>
	</div>
	<script>
		function change_customer(){
			$('#customer_to_view').val($('#seleksi').val());
		}
		function submiting(){
			if($('#customer_to_view').val() == 0){
				alert('Please insert a customer!');
				return false;
			} else {
				$('#customer_form').submit();
			}
		}
	</script>
<?php
	$timeout = 0;
	$sql_invoice = "SELECT SUM(value + ongkir) AS jumlah,customer_id,id FROM invoices GROUP BY customer_id ORDER BY jumlah DESC";
	$result_invoice = $conn->query($sql_invoice);
	while($invoice = $result_invoice->fetch_assoc()){
		$sql_receive = "SELECT SUM(receivable.value) AS bayar_total, code_delivery_order.customer_id FROM receivable 
		JOIN invoices ON receivable.invoice_id = invoices.id 
		JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
		WHERE code_delivery_order.customer_id = '" . $invoice['customer_id'] . "'";
		$result_receive = $conn->query($sql_receive);
		$receive = $result_receive->fetch_assoc();
		$width = max(($invoice['jumlah'] - $receive['bayar_total']) * 100/ $maximum,2);	
?>
	<div class='row'>
		<div class='col-sm-3'>
<?php
	$sql_customer = "SELECT name FROM customer WHERE id = '" . $invoice['customer_id'] . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	echo $customer['name'];
?>
		</div>
		<div class='col-sm-6'>
			<div class='row garis' style='width:0%' id='garis<?= $invoice['customer_id'] ?>'>			
			</div>
		</div>
		<div class='col-sm-2' id='nominal<?= $invoice['customer_id'] ?>'>
			Rp. <?= number_format($invoice['jumlah'] - $receive['bayar_total'],2) ?>
		</div>
	</div>
	<script>
		setTimeout(function(){
			$("#garis<?= $invoice['customer_id'] ?>").animate({
				width: '<?= $width ?>%'
			})
		},<?= $timeout ?>)
	</script>
<?php
	$timeout = $timeout + 10;
	}
?>