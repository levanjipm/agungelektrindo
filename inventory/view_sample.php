<?php
	include('../codes/connect.php');
	$id = $_POST['id'];
?>
	<table class='table-hover'>
		<tr>
			<th>Reference</th>
			<th>Quantity</th>
			<th>Stock</th>
		</tr>
<?php
	$sql = "SELECT * FROM sample WHERE code_id = '$id'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_stock = "SELECT stock FROM stock WHERE reference = '" . $row['reference'] . "'";
		$result_stock = $conn->query($sql_stock);
		$stock = $result_stock->fetch_assoc();
?>
		<tr>
			<td><?= $row['reference']; ?></td>
			<td><?= $row['quantity']; ?></td>
			<td><?php
				if($stock['stock'] == NULL){
					echo (0);
				} else {
					echo ($stock['stock']);
				}
			?></td>
		</tr>
<?php
	}
?>
	</table>
	<br>
<?php
	$sql_code = "SELECT * FROM code_sample WHERE id = '" . $id . "'";
	$result_code = $conn->query($sql_code);
	$code = $result_code->fetch_assoc();
	
	$sql = "SELECT name FROM users WHERE id = '" . $code['confirmed_by'] . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$confirmed_by = $row['name'];
?>	
	<p>Confirmed by <?= $confirmed_by ?></p>