<?php
	include('../codes/connect.php');
	$term		= $_POST['term'];
	if($term == ''){
		$sql 					= "SELECT DISTINCT(purchaseorder.purchaseorder_id), code_purchaseorder.name, code_purchaseorder.date,
									supplier.name as supplier_name, supplier.address, supplier.city
									FROM purchaseorder 
									JOIN code_purchaseorder ON purchaseorder.purchaseorder_id = code_purchaseorder.id
									JOIN supplier ON code_purchaseorder.supplier_id = supplier.id
									WHERE purchaseorder.status = '0'";
		$result 	= $conn->query($sql);
		while($row 	= $result->fetch_assoc()){
			$purchase_order_id	= $row['purchaseorder_id'];
			$po_name			= $row['name'];
			$date 				= $row['date'];
			
			$supplier_name		= $row['supplier_name'];
			$supplier_address	= $row['address'];
			$supplier_city		= $row['city'];
?>
			<tr>
				<td><?= date('d M Y',strtotime($date)) ?></td>
				<td><?= $po_name?></td>
				<td>
					<p style='font-family:museo'><?= $supplier_name ?></p>
					<p style='font-family:museo'><?= $supplier_address ?></p>
					<p style='font-family:museo'><?= $supplier_city ?></p>
				</td>
				<td>
					<button type='button' class="button_success_dark" onclick='showdetail(<?= $po_id ?>)' id="more_detail<?= $po_id ?>">View</button>		
				</td>
			</tr>
<?php
		}
	} else {
		$po_array				= array();
		$sql 					= "SELECT DISTINCT(purchaseorder.purchaseorder_id)
									FROM purchaseorder
									WHERE purchaseorder.status = '0'";
		$result					= $conn->query($sql);
		while($row 				= $result->fetch_assoc()){
			$po_id				= $row['purchaseorder_id'];
			array_push($po_array, $po_id);	
		}
		
		$po_string				= '(';
		foreach($po_array as $po){
			$po_string			.= $po . ',';
			next($po_array);
		}
		$po_string				= substr($po_string,0,-1) . ')';
		$strlen					= strlen($po_string);
		
		if($strlen				> 1){
			$sql				= "SELECT code_purchaseorder.date, code_purchaseorder.id, code_purchaseorder.name, supplier.name as supplier_name, supplier.address, supplier.city 
									FROM 
									(SELECT code_purchaseorder.id FROM code_purchaseorder INNER JOIN supplier ON supplier.id = code_purchaseorder.supplier_id WHERE supplier.name LIKE '%$term%' OR supplier.address LIKE '%$term%' OR supplier.city LIKE '%$term%' 
									 UNION SELECT DISTINCT(purchaseorder.purchaseorder_id) as id FROM purchaseorder JOIN itemlist ON purchaseorder.reference = itemlist.reference WHERE purchaseorder.reference LIKE '%$term%' OR itemlist.description LIKE '%$term%' AND purchaseorder.status = '0' 
									 UNION SELECT id FROM code_purchaseorder WHERE name LIKE '%$term%') as a 
									 JOIN code_purchaseorder ON a.id = code_purchaseorder.id 
									 JOIN supplier ON code_purchaseorder.supplier_id = supplier.id 
									 WHERE a.id IN $po_string
									 ORDER BY code_purchaseorder.id DESC";
									 echo $sql;
		$result					= $conn->query($sql);
			while($row				= $result->fetch_assoc()){
				$date				= $row['date'];
				$po_id				= $row['id'];
				$po_name			= $row['name'];
				$supplier_name		= $row['supplier_name'];
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
			<td>
				<button type='button' class="button_success_dark" onclick='showdetail(<?= $po_id ?>)'><i class='fa fa-eye'></i></button>		
			</td>
		</tr>
<?php
			}
		}
	}
?>