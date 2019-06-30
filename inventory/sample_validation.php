<?php
	include('inventoryheader.php');
	if(empty($_POST['id'])){
?>
<script>
	window.history.back();
</script>
<?php
	} else {
		$id = $_POST['id'];
		$sql_code = "SELECT * FROM code_sample WHERE id = '" . $id . "'";
		$result_code = $conn->query($sql_code);
		$code = $result_code->fetch_assoc();
		
		$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $code['customer_id'] . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
	}
?>
<div class='main'>
	<h2>Sample</h2>
	<p>Send sample</p>
	<hr>
	<h3><?= $customer['name'] ?></h3>
	<p><?= $customer['address'] ?></p>
	<p><?= $customer['city'] ?></p>
	<table class='table table-hover'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
	$point_stock = 1;
	$sql_detail = "SELECT * FROM sample WHERE code_id = '" . $id . "'";
	$result_detail = $conn->query($sql_detail);
	while($detail = $result_detail->fetch_assoc()){
		$sql_stock = "SELECT stock FROM stock WHERE reference = '" . $detail['reference'] . "' ORDER BY id DESC";
		$result_stock = $conn->query($sql_stock);
		$stock =  $result_stock->fetch_assoc();
		$stock_check = $stock['stock'];
		
		if($detail['quantity'] > $stock_check){
			$point_stock++;
		}
?>
		<tr>
			<td><?= $detail['reference'] ?></td>
			<td><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $detail['reference'] . "'";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td><?= $detail['quantity']; ?></td>
		</tr>
<?php
	}
?>
	</table>
	<button type='button' class='btn btn-warning'>Back</button>
<?php
	if($point_stock == 1){
?>
	<button type='button' class='btn btn-default' id='submitbutton'>Submit</button>
	<form action='sample_input.php' method='POST' id='submitform'>
		<input type='hidden' value='<?= $id ?>' name='id'>
	</form>
	<script>
		$('#submitbutton').click(function(){
			$('#submitform').submit();
		});
	</script>
<?php
	}
?>
</div>