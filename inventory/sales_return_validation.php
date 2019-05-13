<?php
	include('inventoryheader.php');
	if(empty($_POST['id'])){
		header('location:inventory.php');
	}
	$return_id = $_POST['id'];
	$sql_code = "SELECT * FROM code_sales_return WHERE id = '" . $return_id . "'";
	$result_code = $conn->query($sql_code);
	$code = $result_code->fetch_assoc();
	
	$sql_return = "SELECT * FROM sales_return WHERE return_code = '" . $return_id . "'";
	$result_return = $conn->query($sql_return);
?>
<div class='main'>
	<div class='container'>
	<form method='POST' action='sales_return_input.php' id='myForm'>
<?php
	$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $code['customer_id'] . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
?>
		<h2><?= $customer['name'] ?></h2>
		<p><?= $customer['address'] ?></p>
		<p><?= $customer['city'] ?></p>
		<label>Document number</label>
		<div class="input-group">
			<input type='text' class='form-control' style='width:50%'  id='document' name='document' required>
			<div class="input-group-append">
				<button class="btn btn-primary" type="submit">Don't find any document? Click here</button> 
			</div>
		</div>
	</div>
	<table class='table-hover'>
		<tr>
			<th style='width:20%'>Reference</th>
			<th style='width:40%'>Description</th>
			<th style='width:15%'>Return quantity</th>
			<th style='width:15%'>Received quantity</th>
		</tr>
<?php
	$i = 1;
	while($return = $result_return->fetch_assoc()){
?>
		<tr>
			<td><?= $return['reference'] ?></td>
			<input type='hidden' value='<?= $return['id'] ?>' name='id<?= $i ?>'>
			<td><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $return['reference'] . "'";
				$result_item =  $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td><?= $return['quantity'] - $return['received'] ?></td>
			<td>
				<input type='number' value='0' id='received<?= $i ?>' name='received<?= $i ?>' class='form-control'>
			</td>
		</tr>
<?php
	$quantity[$i] = $return['quantity'] - $return['received'];
	$i++;
	}
?>
	</table>
	<input type='hidden' value='<?= $i ?>' name='x'>
	<button type='button' class='btn btn-default' onclick='check()'>Next</button>
</div>
<script>
	function check(){
		var total = 0;
		var nilai = 0;
		var maximum = <?= json_encode($quantity) ?>;
		if($('#document').val() == ''){
			alert('Insert document name!');
			return false;
		}
		for(i = 1; i < <?= $i ?>; i++){
			if(parseInt($('input[id= received' + i + ']').val()) > maximum[i]){
				alert('Cannot insert higher than maximum quantity!');
				nilai ++;
				return false;
			} else {
				total = total + parseInt($('#received' + i).val());
			}
		}
		console.log(total);
		if(total <= 0){
			alert('Cannot insert blank document!');
			return false;
		}
		if(nilai == 0 && total > 0){
			$('#myForm').submit();
		}
	}
</script>