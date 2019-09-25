<?php
	include('../codes/connect.php');
	$term		= $_POST['term'];
	if($term == ''){
		$sql 		= "SELECT DISTINCT(purchaseorder_id) FROM purchaseorder WHERE status = '0'";
		$result 	= $conn->query($sql);
		while($row 	= $result->fetch_assoc()){
			$po_id 	= $row['purchaseorder_id'];
			
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
		$sql			= "SELECT code_purchaseorder.id FROM code_purchaseorder JOIN purchaseorder ON purchaseorder.purchaseorder_id = code_purchaseorder.id
						WHERE name LIKE '%" . $term . "' AND purchaseorder.status = '0' UNION
						(SELECT DISTINCT(purchaseorder.purchaseorder_id) as id FROM purchaseorder
						JOIN itemlist ON itemlist.reference = purchaseorder.reference
						WHERE purchaseorder.reference LIKE '%" . $term . "%' OR  itemlist.description LIKE '%" . $term . "%' AND status = '0')
						UNION
						(SELECT code_purchaseorder.id FROM code_purchaseorder JOIN supplier ON supplier.id = code_purchaseorder.supplier_id
						JOIN purchaseorder ON code_purchaseorder.id = purchaseorder.purchaseorder_id WHERE purchaseorder.status = '0' AND supplier.name LIKE '%" . $term . "%')";
		$result			= $conn->query($sql);
		while($row 		= $result->fetch_assoc()){			
			$po_id 		= $row['id'];
			
			$sql_code		= "SELECT name,date,supplier_id FROM code_purchaseorder WHERE id = '$po_id	'";
			$result_code	= $conn->query($sql_code);
			$code			= $result_code->fetch_assoc();
			
			$po_name	= $code['name'];
			$date		= $code['date'];
			$supplier_id		= $code['supplier_id'];
			
			$sql_supplier 		= "SELECT name,city FROM supplier WHERE id = '" . $supplier_id . "'";
			$result_supplier 	= $conn->query($sql_supplier);
			$supplier 			= $result_supplier->fetch_assoc();
			
			$supplier_name		= $supplier['name'];
?>
			<tr>
				<td><?= date('d M Y',strtotime($date)) ?></td>
				<td><?= $po_name ?></td>
				<td><?= $supplier_name ?></td>
				<td style="width:50%">
					<button type='button' class="button_success_dark" onclick='showdetail(<?= $po_id ?>)' id="more_detail<?= $po_id ?>">View</button>		
				</td style="width:50%">
			</tr>
<?php
		}
	}
?>