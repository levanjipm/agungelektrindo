<?php
	include('../codes/connect.php');
	$return_id		= (int)$_POST['return_id'];
	$sql			= "SELECT * FROM code_purchase_return WHERE id = '$return_id' AND isconfirm = '1'";
	$result			= $conn->query($sql);
	if($result){
		$row			= $result->fetch_assoc();
			
		$created_by		= $row['created_by'];
		$supplier_id	= $row['supplier_id'];
		
		$sql_user		= "SELECT name FROM users WHERE id = '$created_by'";
		$result_user	= $conn->query($sql_user);
		$user			= $result_user->fetch_assoc();
		
		$created_by_name	= $user['name'];
		
		$sql_supplier	= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
		$result_supplier	= $conn->query($sql_supplier);
		$supplier			= $result_supplier->fetch_assoc();
		
		$supplier_name		= $supplier['name'];
		$supplier_address	= $supplier['address'];
		$supplier_city		= $supplier['city'];
?>
	<h2 style='font-family:bebasneue'>Purchasing return</h2>
	<hr>
	<label>Return date</label>
	<input type='date' class='form-control' id='send_date' value='<?= date('Y-m-d') ?>'>
	<h4 style='font-family:bebasneue'>Supplier data</h4>
	<label>Name</label>
	<p><?= $supplier_name ?></p>
	<label>Address</label>
	<p><?= $supplier_address ?></p>
	<label>City</label>
	<p><?= $supplier_city ?></p>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Unit price</th>
			</tr>
		</thead>
		<tbody>
<?php
		$total			= 0;
		$sql			= "SELECT * FROM purchase_return WHERE code_id = '$return_id'";
		$result			= $conn->query($sql);
		while($row		= $result->fetch_assoc()){
			$reference	= $row['reference'];
			$quantity	= $row['quantity'];
			$price		= $row['price'];
			
			$total		+=	$quantity * $price;
			
			$sql_item		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item	= $conn->query($sql_item);
			$item			= $result_item->fetch_assoc();
			
			$item_description	= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $item_description ?></td>
				<td><?= $quantity ?></td>
				<td>Rp. <?= number_format($price,2) ?></td>
			</tr>
<?php
		}
?>
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td colspan='2'><strong>Grand Total</strong></td>
				<td>Rp. <?= number_format($total,2) ?></td>
			</tr>
		</tfoot>
	</table>
	<button type='button' class='button_success_dark' onclick='input_purchasing_return(<?= $return_id ?>)' id='submit_button_view'>Submit</button>
	<br>
	<p style='font-size:0.8em'>Created by <?= $created_by_name ?></p>
<?php
	} else {
		echo ('Error on fetching data');
	}
?>