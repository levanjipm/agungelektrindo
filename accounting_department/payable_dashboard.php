<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<style>
	.garis_wrapper{
		transition:0.3s all ease;
		margin-top:10px;
	}
	
	.garis_wrapper:hover{
		background-color:#afdfe6;
		transition:0.3s all ease;
	}

	.garis{
		height:20px;
		box-shadow: 2px 2px 4px 2px rgba(20,20,20,0.4);
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
	
	$number					= mysqli_num_rows($result_initial);
	
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
	<hr>
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
	$timeout 				= 0;
	$i						= 1;
	$sql_invoice 			= "SELECT supplier.id ,SUM(purchases.value) AS jumlah,supplier.name
								FROM purchases 
								JOIN supplier ON purchases.supplier_id = supplier.id
								WHERE purchases.isdone = '0' GROUP BY supplier_id ORDER BY jumlah DESC";
	$result_invoice 		= $conn->query($sql_invoice);
	while($invoice 			= $result_invoice->fetch_assoc()){
		$supplier_name		= $invoice['name'];
		$supplier_id		= $invoice['id'];
		$sql_paid 			= "SELECT SUM(payable.value) AS paid FROM payable 
								JOIN purchases ON payable.purchase_id = purchases.id
								WHERE purchases.supplier_id = '$supplier_id' AND purchases.isdone = 0";
		$result_paid 		= $conn->query($sql_paid);
		$paid 				= $result_paid->fetch_assoc();
		$dibayar 			= $paid['paid'];
			
		$width 				= max(($invoice['jumlah'] - $dibayar) * 100/ $maximum,0);
		
		$r		= ($i * 161 / $number) + 14;
		$g		= ($i * 160 / $number) + 63;
		$b		= ($i * 128 / $number) + 102;
		$rgb	= $r . ',' . $g . ',' . $b;
?>
	<a href='/agungelektrindo/accounting_department/supplier_view.php?id=<?= $supplier_id ?>' style='text-decoration:none;color:black'>
	<div class='row garis_wrapper'>
		<div class='col-sm-3'><?= $supplier_name ?></div>
		<div class='col-sm-6'><div class='row garis' style='width:0%;background-color:rgb(<?= $rgb ?>)' id='garis<?= $supplier_id ?>'></div></div>
		<div class='col-sm-2'>Rp. <?= number_format($invoice['jumlah'] - $dibayar,2) ?></div>
	</div>
	</a>
	<script>
		setTimeout(function(){
			$("#garis<?= $supplier_id ?>").animate({
				width: '<?= $width ?>%'
			})
		},<?= $timeout ?>)
	</script>
<?php
		$i++;
		$timeout = $timeout + 50;
	}
?>