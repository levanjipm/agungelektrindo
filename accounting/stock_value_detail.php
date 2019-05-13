<?php
	include('accountingheader.php');
	$date = $_POST['date'];
?>
<div class='main'>
	<table class='table table-hover'>
		<tr>
			<th>Item name</th>
			<th>Description</th>
			<th>In quantity</th>
			<th>Out quantity</th>
			<th>Value per pcs</th>
			<th></th>
		</tr>
<?php
	$sql = "SELECT id,reference,quantity,price FROM stock_value_in WHERE date <= '" . $date . "' ORDER BY id ASC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
		<tr>
			<td><?= $row['reference'] ?></td>
			<td><?php
			$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $row['reference'] . "'";
			$result_item = $conn->query($sql_item);
			$item = $result_item->fetch_assoc();
			echo $item['description'];
			?></td>
			<td><?= $row['quantity'] ?></td>
			<td><?php
				$sql_out = "SELECT SUM(quantity) AS quantity_out FROM stock_value_out WHERE date <= '" . $date . "' AND in_id = '" . $row['id'] . "'";
				$result_out = $conn->query($sql_out);
				$out = $result_out->fetch_assoc();
				if($out['quantity_out'] == ''){
			?>
			0</td>
			<td>Rp. <?= number_format($row['price'],2) ?></td>
			<td></td>
			<?php
				} else {
			?>
			<?= $out['quantity_out'] ?></td>
			<td>Rp. <?= number_format($row['price'],2) ?></td>
			<td><button type='button' class='btn btn-default' onclick='show_who(<?= $row['id'] ?>)'>Show</button></td>
			<?php
				}
			?>
		</tr>
<?php
	}
?>