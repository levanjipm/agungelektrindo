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
	$sql_initial = "SELECT SUM(value) AS maximum FROM purchases WHERE isdone = '0' GROUP by supplier_id";
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
	$sql_select = 'SELECT id,name FROM supplier';
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
	$sql_invoice = "SELECT SUM(value) AS jumlah,supplier_id FROM purchases WHERE isdone = '0' GROUP BY supplier_id ORDER BY jumlah DESC";
	$result_invoice = $conn->query($sql_invoice);
	while($invoice = $result_invoice->fetch_assoc()){
		$width = max($invoice['jumlah'] * 100/ $maximum,2);
?>
	<div class='row'>
		<div class='col-sm-3'>
<?php
	$sql_customer = "SELECT name FROM supplier WHERE id = '" . $invoice['supplier_id'] . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	echo $customer['name'];
?>
		</div>
		<div class='col-sm-6'>
			<div class='row garis' style='width:0%' id='garis<?= $invoice['supplier_id'] ?>'>			
			</div>
		</div>
		<div class='col-sm-2' id='nominal<?= $invoice['supplier_id'] ?>'>
			Rp. <?= number_format($invoice['jumlah'],2) ?>
		</div>
	</div>
	<script>
		setTimeout(function(){
			$("#garis<?= $invoice['supplier_id'] ?>").animate({
				width: '<?= $width ?>%'
			})
		},<?= $timeout ?>)
	</script>
<?php
	$timeout = $timeout + 50;
	}
?>