<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<style>
	.garis{
		height:20px;
		background-color:#2b64bf;
		box-shadow: 2px 2px 4px 2px #888888;
		margin-top:10px;
		position:relative;
	}
</style>
<head>
	<title>Payable dashboard</title>
</head>
<?php
	$maximum 				= 0;
	$total 					= 0;
	$sql_initial 			= "SELECT supplier_id,SUM(value) AS maximum FROM purchases WHERE isdone = '0' GROUP BY supplier_id";
	$result_initial			= $conn->query($sql_initial);
	while($initial 			= $result_initial->fetch_assoc()){
		$supplier_id		= $initial['supplier_id'];
		$sql_pengurang 		= "SELECT SUM(payable.value) AS pengurang FROM payable 
								JOIN purchases ON purchases.id = payable.purchase_id
								WHERE purchases.supplier_id = '$supplier_id' AND purchases.isdone = '0'";
		$result_pengurang 	= $conn->query($sql_pengurang);
		$pengurang 			= $result_pengurang->fetch_assoc();
		
		$paid 				= $pengurang['pengurang'];
		if(($initial['maximum'] - $paid) > $maximum){
			$maximum 		= $initial['maximum'] - $paid;
		}
		$total 				= $total + $initial['maximum'] - $paid;
	}
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-4'>
			<h2 style='font-family:bebasneue'>Account of receivable</h2>
			<p>Rp. <?= number_format($total,2) ?></p>
		</div>
		<div class='col-sm-4'>
			<br>
			<select class='form-control' onchange='change_supplier()' id='seleksi'>
				<option value='0'>Please insert supplier name to view</option>
<?php
	$sql_select 	= 'SELECT id,name FROM supplier';
	$result_select = $conn->query($sql_select);
	while($select = $result_select->fetch_assoc()){
?>
				<option value='<?= $select['id'] ?>'><?= $select['name'] ?></option>
<?php
	}
?>
			</select>
			<form action='supplier_view' method='POST' id='supplier_form'>
				<input type='hidden' id='supplier_to_view' name='supplier'>
			</form>
		</div>
		<div class='col-sm-2'>
			<br>
			<button type='button' class='button_default_dark' onclick='submiting()'>
				<i class="fa fa-search" aria-hidden="true"></i>
			</button>
		</div>		
		<hr>
	</div>
	<script>
		function change_supplier(){
			$('#supplier_to_view').val($('#seleksi').val());
		}
		function submiting(){
			if($('#supplier_to_view').val() == 0){
				alert('Please insert a supplier!');
				return false;
			} else {
				$('#supplier_form').submit();
			}
		}
	</script>
<?php
	$timeout 			= 0;
	$sql_invoice 		= "SELECT id,SUM(value) AS jumlah,supplier_id FROM purchases WHERE purchases.isdone = '0' GROUP BY supplier_id ORDER BY jumlah DESC";
	$result_invoice 	= $conn->query($sql_invoice);
	while($invoice 		= $result_invoice->fetch_assoc()){
		$supplier_id	= $invoice['supplier_id'];
		$sql_paid 		= "SELECT SUM(payable.value) AS paid FROM payable 
							JOIN purchases ON payable.purchase_id = purchases.id
							WHERE purchases.supplier_id = '$supplier_id' AND purchases.isdone = 0";
		$result_paid 	= $conn->query($sql_paid);
		$paid 			= $result_paid->fetch_assoc();
		$dibayar 		= $paid['paid'];
		
		$width 			= max(($invoice['jumlah'] - $dibayar) * 100/ $maximum,0);
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
			<div class='garis' style='width:0%' id='garis<?= $invoice['supplier_id'] ?>'>			
			</div>
		</div>
		<div class='col-sm-2' id='nominal<?= $invoice['supplier_id'] ?>'>
			Rp. <?= number_format($invoice['jumlah'] - $dibayar,2) ?>
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