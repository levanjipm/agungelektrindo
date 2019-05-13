<DOCTYPE html>
<?php
	include('connect.php');
	$supplier_name = $_POST['supplier'];
	$sql_supplier = "SELECT id FROM supplier WHERE name = '" . $supplier_name . "'";
	$result = $conn->query($sql_supplier);
	while($row = $result->fetch_assoc()){
		$supplier_id = $row['id'];
	}
	$document = $_POST['document'];
	$jumlah_barang = $_POST['jumlah_barang'];
	$i = 1;
	for ($i = 1; $i <= $jumlah_barang; $i++){
		$reference = $_POST['reference' . $i];
		$quantity = $_POST['quantity' . $i];
		$sql_initial = "SELECT * FROM stock WHERE reference = '" . $reference . "'";
		$result_initial = $conn->query($sql_initial);
		if ($result_initial->num_rows >0){
			while($row_i = $result_initial->fetch_assoc()){
				$init_stock = $row_i['stock'];
			};
		} else {
			$init_stock = 0;
		}
		$end_stock = $init_stock + $quantity;
		$sql = "INSERT INTO stock (reference,transaction,quantity,stock,supplier_id,document) VALUES ('$reference','IN','$quantity','$end_stock','$supplier_id','$document')";
		echo $sql;
		$result_insert = $conn->query($sql);
	}
?>