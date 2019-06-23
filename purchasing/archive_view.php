<?php
	include('purchasingheader.php');
?>
<div class='main'>
	<h2>Purchase Order</h2>
	<p>Archives</p>
	<hr>
	<div class='col-sm-4 col-sm-offset-2'>
		<div class="input-group">
			<span class="input-group-addon">
				<button type='button' class='btn btn-default' style='width:100%;padding:0;background-color:transparent;border:none'
				onclick='search_quotation()'>
					<i class="fa fa-search" aria-hidden="true"></i>
				</button>
			</span>
			<input type="text" id="search" name="search" class="form-control" placeholder="Search here">
		</div>
		<hr>
	</div>
	<div class='col-sm-2'>
		<label>Sort by</label>
	</div>
	<div class='inputs'>
		<table class='table table-hover'>
			<tr>
				<th>Date</th>
				<th>PO number</th>
				<th>Supplier</th>
				<th></th>
			</tr>
<?php
	$sql_po = "SELECT code_purchaseorder.date, code_purchaseorder.id, code_purchaseorder.name, supplier.name AS supplier_name FROM code_purchaseorder 
	JOIN supplier ON code_purchaseorder.supplier_id = supplier.id 
	ORDER BY date ASC";
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
		</table>
	</div>
</div>