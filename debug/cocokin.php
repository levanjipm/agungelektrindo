<?php
	//cocokin stock gudang dan stock_value//
	include('../codes/connect.php');
?>
	<table border='1'>
		<tr>
			<th>Reference</th>
			<th>Stock Gudang</th>
			<th>Stock value</th>
			<th>Stock value sisa</th>
		</tr>
<?php
	$sql_reference = "SELECT DISTINCT(reference) AS reference FROM stock";
	$result_reference = $conn->query($sql_reference);
	while($row_reference = $result_reference->fetch_assoc()){
		$reference = $row_reference['reference'];
		
		$sql_stock  = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
		$result_stock = $conn->query($sql_stock);
		$stock = $result_stock->fetch_assoc();
		
		$sql_value_in = "SELECT SUM(quantity) AS in_quantity FROM stock_value_in WHERE reference = '" . $reference . "'";
		$result_value_in = $conn->query($sql_value_in);
		$value_in = $result_value_in->fetch_assoc();
		
		$sql_value_out = "SELECT SUM(stock_value_out.quantity) AS out_quantity FROM stock_value_out
		JOIN stock_value_in ON stock_value_in.id = stock_value_out.in_id
		WHERE stock_value_in.reference = '" . $reference . "'";
		$result_value_out = $conn->query($sql_value_out);
		$value_out = $result_value_out->fetch_assoc();
		
		$sql_sisa = "SELECT SUM(sisa) AS sisa_value FROM stock_value_in WHERE reference = '" . $reference . "'";
		$result_sisa = $conn->query($sql_sisa);
		$sisa = $result_sisa->fetch_assoc();
		
		if($stock['stock'] == ($value_in['in_quantity'] - $value_out['out_quantity']) && $stock['stock'] == $sisa['sisa_value']){
		} else {
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $stock['stock'] ?></td>
			<td><?= $value_in['in_quantity'] - $value_out['out_quantity'] ?></td>
			<td><?= $sisa['sisa_value'] ?></td>
		</tr>
<?php
		}
	}
?>
