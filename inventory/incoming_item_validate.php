<DOCTYPE html>
<head>
<title>Inventory Department</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<?php
	include('connect.php');
	$supplier_name = $_POST['supplier'];
	$document = $_POST['document'];
	$jumlah_barang = $_POST['jumlah_barang'];
	$i = 1;
?>
<div class="row">
	<div class="col-lg-10 offset-lg-1">
		<h2>Input to stock table</h2>
			<form method="POST" action="incoming_item_input.php">
				<input type="hidden" value="<?= $supplier_name ?>" name="supplier">
				<input type="hidden" value="<?= $document ?>" name="document">
				<h3><?= $supplier_name ?></h3>
				<p>Document number: <?= $document ?></p>
				<input type="hidden" value="<?= $jumlah_barang ?>" name="jumlah_barang">
				<table class="table">
					<thead>
						<tr>
							<th>Reference</th>
							<th>Description</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
<?php
	for ($i = 1; $i <= $jumlah_barang; $i++){
		$reference = $_POST['reference' . $i];
		$quantity = $_POST['quantity' . $i];
		$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $reference . "'";
		$result = $conn->query($sql_item);
		if ($result->num_rows == 0){
			$description = '';
		} else{
			while($row_desc = $result->fetch_assoc()){
				$description = $row_desc['description'];
			}
		}
?>
						<tr>
							<td><input type="text" value="<?= $reference ?>" class="form-control" readonly name="<?= "reference" . $i ?>">
							<td><?= $description ?></td>
							<td><input type="text" value="<?= $quantity ?>" class="form-control" readonly name="<?= "quantity" . $i ?>">
						</tr>
<?php
	}
?>
					</tbody>
				</table>
				<button type="submit" class="btn btn-success">Submit Stock</button>