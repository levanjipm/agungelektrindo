<?php
	include('../../codes/connect.php');
	$month = $_POST['month'];
	$year = $_POST['year'];
	$sql_search = "SELECT * FROM invoices WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "' AND isconfirm = '1'";
	$result_search = $conn->query($sql_search);
	$x = 1;
	while($row_search = $result_search->fetch_object()){
?>
	<tr>
		<td><?= date('d M Y',strtotime($row_search->date)); ?></td>
		<td><?php
			if($row_search->faktur == ''){
				echo ('Non pajak');
			} else {
				echo ($row_search->faktur); 
			}?></td>
		<td><?= $row_search->name; ?></td>
		<td><?php
			$sql_customer = "SELECT name FROM customer WHERE id = '" . $row_search->customer_id . "'";
			$result_customer = $conn->query($sql_customer);
			$customer = $result_customer->fetch_assoc();
			echo $customer['name'];
		?></td>
		<td>Rp. <?= number_format($row_search->value,2) ?></td>
		<input type='hidden' value='<?= $row_search->value ?>' id='value<?= $x ?>'>
	</tr>
<?php
	$x ++;
	}
?>