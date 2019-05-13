<head>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
</head>
<?php
	//Closing statement letter//
	include('../codes/connect.php');
	if(empty($_POST['po_id'])){
		header('location:purchasing.php');
	} else{
?>
	<div class='row'>
		<div class='col-sm-2' style='background-color:#eee'>
		</div>
		<div class='col-sm-8' style='padding:50px' id='printable'>
			<div class='row'>
				<div class='col-sm-6 col-sm-offset-3'>
					<img src='../universal/Logo Agung.jpg' style='width:100%'>
				</div>
			</div>
			<br><br>
			<p style='text-align:right'>Bandung, <?= date('d M Y'); ?></p>
			<p>Kepada yth.</p>
<?php
				$sql_initial = "SELECT supplier_id,name FROM code_purchaseorder WHERE id = '" . $_POST['po_id'] . "'";
				$result_initial = $conn->query($sql_initial);
				$initial = $result_initial->fetch_assoc();
				
				$sql_supplier = "SELECT name,address,city FROM supplier WHERE id = '" . $initial['supplier_id'] . "'";
				$result_supplier = $conn->query($sql_supplier);
				$supplier = $result_supplier->fetch_assoc();
?>
			<p><?= $supplier['name'] ?></p>
			<p><?= $supplier['address'] ?></p>
			<p><?= $supplier['city'] ?></p>
			<br>
			<strong>Perihal: Penutupan order pembelian</strong>
			<br><br><br>
			<p>Bersama ini, kami ingin menginformasikan bahwa <i>Purchase order</i> dengan nomor <?= $initial['name'] ?> telah ditutup.
			<p>Rincian barang yang ditutup adalah sebagai berikut:</p>
			<table class='table'>
				<tr>
					<th>Referensi</th>
					<th>Deskripsi</th>
					<th>Jumlah</th>
				</tr>
			<?php
				$sql_table = "SELECT id,reference,quantity FROM purchaseorder WHERE purchaseorder_id = '" . $_POST['po_id'] . "'";
				$result_table = $conn->query($sql_table);
				while($table = $result_table->fetch_assoc()){
					$reference = $table['reference'];
					$order = $table['quantity'];
					$id = $table['id'];
					$sql_close = "SELECT quantity FROM purchaseorder_received WHERE id = '" . $id . "'";
					$result_close = $conn->query($sql_close);
					$close = $result_close->fetch_assoc();
					$received = $close['quantity'];
			?>
				<tr>
					<td><?= $reference ?></td>
					<td><?php
						$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $reference . "'";
						$result_item = $conn->query($sql_item);
						$item = $result_item->fetch_assoc();
						echo $item['description'];
					?></td>
					<td><?= ($order - $received) ?></td>
				</tr>
			<?php
				}
			?>
			</table>
			<p>Demikian surat ini kami buat, atas perhatian bapak/ibu, kami ucapkan terima kasih.</p>
			<br><br><br>
			<p style='text-align:right'>Hormat kami,</p>
			<br><br><br>
			<p style='text-align:right'><strong>CV Agung Elektrindo</strong></p>
		</div>
		<div class='col-sm-2' style='background-color:#eee'>
		</div>
	</div>
	<div class="row" style="background-color:#333;padding:30px">
		<div class="col-sm-2 offset-sm-5">
			<button class="btn btn-primary hidden-print" type="button" id="print" onclick="printing()">Print</button>
		</div>
	</div>
<script>
function printing(){
	var printcon = document.getElementById('printable').innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printcon;
	window.print();
	document.body.innerHTML = originalContents;
}
</script>
<?php
	}
?>
