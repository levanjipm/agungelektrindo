<?php
	include('../codes/connect.php');
	$term		= $_POST['term'];
	if($term == ''){
		$sql 					= "SELECT DISTINCT(purchaseorder_id) FROM purchaseorder WHERE status = '0'";
		$result 				= $conn->query($sql);
		while($row 				= $result->fetch_assoc()){
			$po_id 				= $row['purchaseorder_id'];
			
			$sql_po 			= "SELECT name,supplier_id,date FROM code_purchaseorder WHERE id = '" . $po_id . "'";
			$result_po 			= $conn->query($sql_po);
			$row_po 			= $result_po->fetch_assoc();
			$supplier_id 		= $row_po['supplier_id'];
			$po_name			= $row_po['name'];
			$date 				= $row_po['date'];
			
			$sql_supplier 		= "SELECT name,city FROM supplier WHERE id = '" . $supplier_id . "'";
			$result_supplier 	= $conn->query($sql_supplier);
			$supplier 			= $result_supplier->fetch_assoc();
			
			$supplier_name		= $supplier['name'];
?>
			<tr>
				<td><?= date('d M Y',strtotime($date)) ?></td>
				<td><?= $po_name?></td>
				<td><?= $supplier_name ?></td>
				<td style="width:50%">
					<button type='button' class="button_success_dark" onclick='showdetail(<?= $po_id ?>)' id="more_detail<?= $po_id ?>">View</button>		
				</td style="width:50%">
			</tr>
<?php
		}
	} else {
		$po_array				= array();
		$sql					= "SELECT DISTINCT(purchaseorder.purchaseorder_id) as id FROM purchaseorder
									JOIN itemlist ON itemlist.reference = purchaseorder.reference
									WHERE purchaseorder.status = '0'";
		$result					= $conn->query($sql);
		while($row 				= $result->fetch_assoc()){
			$po_id				= $row['id'];
			array_push($po_array, $po_id);	
		}
		
		$po_string				= '(';
		foreach($po_array as $po){
			$po_string			.= $po . ',';
			next($po_array);
		}
		$po_string				= substr($po_string,0,-1) . ')';
		$strlen					= strlen($po_string);
		
		if($strlen				== 1){
			$sql				= "SELECT code_purchaseorder.date, code_purchaseorder.id, code_purchaseorder.name as po_name, supplier.name as name, supplier.address, supplier.city
									FROM code_purchaseorder 
									JOIN supplier ON code_purchaseorder.supplier_id = supplier.id
									WHERE code_purchaseorder.name LIKE '%$term%' OR supplier.name LIKE '%$term%' OR supplier.address LIKE '%$term%'
									OR supplier.name LIKE '%$term%'";
		} else {
			$po_where			= substr($po_string,0,-1) . ')';
			$sql				= "SELECT code_purchaseorder.date, code_purchaseorder.id, code_purchaseorder.name as po_name, supplier.name as name, supplier.address, supplier.city
									FROM code_purchaseorder 
									JOIN supplier ON code_purchaseorder.supplier_id = supplier.id
									WHERE code_purchaseorder.name LIKE '%$term%' OR supplier.name LIKE '%$term%' OR supplier.address LIKE '%$term%'
									OR supplier.name OR '%$term%' AND code_purchaseorder.id IN " . $po_where;
		}
		echo $sql;
		$result					= $conn->query($sql);
		while($row				= $result->fetch_assoc()){
			$date				= $row['date'];
			$po_id				= $row['id'];
			$po_name			= $row['po_name'];
			$supplier_name		= $row['name'];
			$supplier_address	= $row['address'];
			$supplier_city		= $row['city'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td><?= $po_name ?></td>
			<td>
				<p style='font-family:museo'><?= $supplier_name ?></p>
				<p style='font-family:museo'><?= $supplier_address ?></p>
				<p style='font-family:museo'><?= $supplier_city ?></p>
			</td>
		</tr>
<?php
		}
	}
?>