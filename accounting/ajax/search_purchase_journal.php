<?php
	include('../../codes/connect.php');
	$month = $_POST['month'];
	$year = $_POST['year'];
	$sql_search = "SELECT * FROM purchases WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "' AND isconfirm = '1'";
	$result_search = $conn->query($sql_search);
	$x = 1;
	while($row_search = $result_search->fetch_assoc()){
?>
	<tr>
		<td><?= date('d M Y',strtotime($row_search['date'])); ?></td>
		<td><?php
			if($row_search['faktur'] == ''){
				echo ('Non pajak');
			} else {
				echo ($row_search['faktur']); 
			}?></td>
		<td><?= $row_search['name']; ?></td>
		<td><?php
			$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $row_search['supplier_id'] . "'";
			$result_supplier = $conn->query($sql_supplier);
			$supplier = $result_supplier->fetch_assoc();
			echo $supplier['name'];
		?></td>
		<td>
<?php
			$sql = "SELECT id FROM code_goodreceipt WHERE invoice_id = '" . $row_search['id'] . "'";
			$result = $conn->query($sql);
			$total_value 	= 0;
			while($row = $result->fetch_assoc()){
				$sql_gr 	= "SELECT quantity, billed_price FROM goodreceipt WHERE gr_id = '" . $row['id'] . "'";
				$result_gr 	= $conn->query($sql_gr);
				while($gr	= $result_gr->fetch_assoc()){		
					$quantity 		= $gr['quantity'];
					$billed_price 	= $gr['billed_price'];
					$total_value += $quantity * $billed_price;
				}
			}
?>
			Rp. <?= number_format($total_value,2) ?>
		</td>
		<input type='hidden' value='<?= $total_value ?>' id='value<?= $x ?>'>
	</tr>
<?php
	$x ++;
	}
?>