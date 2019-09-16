<?php
	include('../../codes/connect.php');
	$x							= 1;
	$month 						= $_POST['month'];
	$year 						= $_POST['year'];
	$sql_search 				= "SELECT * FROM purchases WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "' AND isconfirm = '1'";
	$result_search 				= $conn->query($sql_search);
	while($row_search 			= $result_search->fetch_assoc()){
		$total_value 			= 0;
		$document_name			= $row_search['name'];
		if($row_search['faktur'] == ''){
			$tax_document		= 'Non taxable';
		} else {
			$tax_document		= $row_search['faktur'];
		}
		
		$sql_supplier 			= "SELECT name FROM supplier WHERE id = '" . $row_search['supplier_id'] . "'";
		$result_supplier 		= $conn->query($sql_supplier);
		$supplier 				= $result_supplier->fetch_assoc();
		
		$supplier_name			= $supplier['name'];
		
		$sql 					= "SELECT id FROM code_goodreceipt WHERE invoice_id = '" . $row_search['id'] . "'";
		$result 				= $conn->query($sql);
		
		if(mysqli_num_rows($result) > 0){
			while($row 				= $result->fetch_assoc()){
				$sql_gr 			= "SELECT quantity, billed_price FROM goodreceipt WHERE gr_id = '" . $row['id'] . "'";
				$result_gr 			= $conn->query($sql_gr);
				while($gr			= $result_gr->fetch_assoc()){		
					$quantity 		= $gr['quantity'];
					$billed_price 	= $gr['billed_price'];
					$total_value 	+= $quantity * $billed_price;
				}
			}
		} else {
			$total_value			= $row_search['value'];
		}
?>
	<tr>
		<td><?= date('d M Y',strtotime($row_search['date'])); ?></td>
		<td><?= $tax_document ?></td>
		<td><?= $document_name ?></td>
		<td><?= $supplier_name ?></td>
		<td>Rp. <?= number_format($total_value,2) ?></td>
		<input type='hidden' value='<?= $total_value ?>' id='value<?= $x ?>'>
	</tr>
<?php
	$x ++;
	}
?>