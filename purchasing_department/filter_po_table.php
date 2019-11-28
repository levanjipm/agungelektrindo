<?php
	include('../codes/connect.php');
	$sort_type = $_POST['sort_type'];
?>
<table class='table table-hover'>
	<tr>
		<th>
			Date
<?php
	if($sort_type != 1){
?>
			<button type='button' class='btn btn-table' id='filter_date_button_up'><i class="fa fa-filter" aria-hidden="true"></i></button>
<?php
	} else {
?>
			<button type='button' class='btn btn-table' id='filter_date_button_down'><i class="fa fa-filter" aria-hidden="true"></i></button>
<?php
	}
?>
		</th>
		<th>
			PO number
			<button type='button' class='btn btn-table' id='filter_po_button'><i class="fa fa-filter" aria-hidden="true"></i></button>
		</th>
		<th>Supplier<button type='button' class='btn btn-table' id='filter_supplier_button'><i class="fa fa-filter" aria-hidden="true"></i></button></th>
		<th></th>
	</tr>
<?php
if($sort_type == 1){
	$sql_po = "SELECT code_purchaseorder.date, code_purchaseorder.id, code_purchaseorder.name, supplier.name AS supplier_name FROM code_purchaseorder 
	JOIN supplier ON code_purchaseorder.supplier_id = supplier.id 
	ORDER BY date ASC";
} else if($sort_type == 2){
	$sql_po = "SELECT code_purchaseorder.date, code_purchaseorder.id, code_purchaseorder.name, supplier.name AS supplier_name FROM code_purchaseorder 
	JOIN supplier ON code_purchaseorder.supplier_id = supplier.id 
	ORDER BY date DESC";
}
	$result_po = $conn->query($sql_po);
	while($po = $result_po->fetch_assoc()){
?>
	<tr>
		<td><?= date('d M Y',strtotime($po['date'])) ?></td>
		<td><?= $po['name'] ?></td>
		<td><?= $po['supplier_name'] ?></td>
		<td><button type='button' class='btn btn-default'>View</button></td>
	</tr>
<?php
	}
?>