<?php
	include('../codes/connect.php');
	$term			= mysqli_real_escape_string($conn, $_GET['term']);
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Customer</th>
		</tr>
<?php	
	$sql			= "SELECT id FROM code_goodreceipt WHERE document LIKE '%$term%' AND code_goodreceipt.isinvoiced = '0'
						UNION (SELECT code_goodreceipt.id FROM code_goodreceipt 
							JOIN supplier ON code_goodreceipt.supplier_id = supplier.id
							WHERE supplier.name LIKE '%$term%' OR supplier.city LIKE '%$term%' OR supplier.address LIKE '%$term%'
							AND code_goodreceipt.isinvoiced = '0')
						UNION (SELECT goodreceipt.gr_id as id FROM goodreceipt 
							JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
							JOIN itemlist ON purchaseorder.reference = itemlist.reference
							JOIN code_goodreceipt ON goodreceipt.gr_id = code_goodreceipt.id
							WHERE purchaseorder.reference LIKE '%$term%' OR itemlist.description LIKE '%$term%' AND code_goodreceipt.isinvoiced = '0')";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$good_receipt_id		= $row['id'];
		$sql_good_receipt		= "SELECT document, date, supplier_id FROM code_goodreceipt WHERE id = '$good_receipt_id'";
		$result_good_receipt	= $conn->query($sql_good_receipt);
		$good_receipt			= $result_good_receipt->fetch_assoc();
		
		$gr_name				= $good_receipt['document'];
		$gr_date				= $good_receipt['date'];
		$supplier_id			= $good_receipt['supplier_id'];

		$sql_supplier			= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
		$result_supplier		= $conn->query($sql_supplier);
		$supplier				= $result_supplier->fetch_assoc();
		
		$supplier_name			= $supplier['name'];
		$supplier_address		= $supplier['address'];
		$supplier_city			= $supplier['city'];
		
		$detail_array			= array();
		$sql_detail				= "SELECT id FROM goodreceipt WHERE gr_id = '$good_receipt_id'";
		$result_detail			= $conn->query($sql_detail);
		while($detail			= $result_detail->fetch_assoc()){
			array_push($detail_array, $detail['id']);
		};
		
		$array						= implode("','",$detail_array);
		
		$sql_status					= "SELECT id FROM stock_value_in WHERE supplier_id = '$supplier_id' AND gr_id IN ('" . $array . "') 
										AND (stock_value_in.quantity = stock_value_in.sisa)";
		$result_status				= $conn->query($sql_status);
		$status						= mysqli_num_rows($result_status);
?>
		<tr>
			<td><?= date('d M Y',strtotime($gr_date)) ?></td>
			<td><?= $gr_name  ?></td>
			<td>
				<p style='font-family:museo'><?= $supplier_name ?></p>
				<p style='font-family:museo'><?= $supplier_address ?></p>
				<p style='font-family:museo'><?= $supplier_city ?></p>
			</td>
			<td>
<?php
	if($status	> 0){
?>
				<button type='button' class='button_success_dark' onclick='delete_good_receipt(<?= $good_receipt_id ?>)'><i class='fa fa-trash'></i></button>
<?php
	}
?>
			</td>
		</tr>
<?php
	}
?>
	</table>
	<form action='good_receipt_delete_validate' id='good_receipt_delete_form' method='POST'>
		<input type='hidden' id='good_receipt_id' name='id'>
	</form>
	<script>
		function delete_good_receipt(n){
			$('#good_receipt_id').val(n);
			$('#good_receipt_delete_form').submit();
		}
	</script>