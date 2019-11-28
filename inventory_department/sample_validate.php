<?php
	include('inventoryheader.php');
	$id = $_POST['id'];
	$sql_sample = "SELECT customer_id,date FROM code_sample WHERE id = '" . $id . "'";
	$result_sample = $conn->query($sql_sample);
	$sample = $result_sample->fetch_assoc();
	
	$sql_customer = "SELECT name,address FROM customer WHERE id = '" . $sample['customer_id'] . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-12'>
			<h2><?= $customer['name']; ?></h2>
			<p><?= $customer['address']; ?></p>
			<hr>
			<table class='table table-hover'>
				<tr>
					<th>Reference</th>
					<th>Item description</th>
					<th>Quantity</th>
					<th>Stock</th>
				</tr>
<?php
	$sql_detail = "SELECT * FROM sample WHERE code_id = '" . $id . "'";
	$result_detail = $conn->query($sql_detail);
	while($detail = $result_detail->fetch_assoc()){
		$sql_stock = "SELECT stock FROM stock WHERE reference = '" . $detail['reference'] . "' ORDER BY id DESC LIMIT 1";
		$result_stock = $conn->query($sql_stock);
		$stock = $result_stock->fetch_assoc();
			if($stock['stock'] < $detail['quantity']){
				echo ('<tr class="warning">');
			} else {
				echo ('<tr>');
			}
?>
					<td><?= $detail['reference'] ?></td>
					<td><?php
						$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $detail['reference'] . "'";
						$result_item = $conn->query($sql_item);
						$item = $result_item->fetch_assoc();
						echo $item['description'];
					?></td>
					<td><?= $detail['quantity'] ?></td>
					<td><?= $stock['stock'] ?></td>				</tr>
<?php
	}
?>
		</div>
	</div>
</div>