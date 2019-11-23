<?php
	include('purchasingheader.php');
?>
<style>
@media print {
  body * {
    visibility: hidden;
  }
  #print_page, #print_page * {
    visibility: visible;
  }
  #print_page {
    position: absolute;
    left: 0;
    top: 0;
	width:100%;
  }
}
</style>
<div class='main'>
<?php
	$supplier_id 		= $_POST['report_supplier'];
	$year 				= $_POST['report_year'];
	$month				= $_POST['report_month'];
	
	$sql_supplier 		= "SELECT name,address,city FROM supplier WHERE id = '" . $supplier_id . "'";
	$result_supplier 	= $conn->query($sql_supplier);
	$supplier 			= $result_supplier->fetch_assoc();	
	
	$supplier_name		= $supplier['name'];
	$supplier_address	= $supplier['address'];
	$supplier_city		= $supplier['city'];
?>
	<div id='print_page'>
		<h2 style='font-family:bebasneue'>Purchase Report</h2>
		<p>Create purchasing report</p>
		<hr>
		<h3 style='font-family:bebasneue'><?= $supplier_name?></h2>
		<p><?= $supplier_address ?></p>
		<p><?= $supplier_city ?></p>
<?php
		if($month != 0){
?>
		<p><?= date('F',mktime(0,0,0,$month,1,$year)) ?></p>
<?php
		}
?>
		<p><?= $year ?></p>
		<hr>
		<table class='table table-bordered'>
			<tr>
				<th>Date</th>
				<th>Purchase order</th>
				<th>Invoice name</th>
				<th>Value</th>
			</tr>
			<tbody>
<?php
	$total_value				= 0;
	if($month	== 0){
		$sql_purchase 			= "SELECT * FROM purchases WHERE supplier_id = '$supplier_id' AND YEAR(date) = '$year' ORDER BY date ASC, name ASC";
	} else {
		$sql_purchase 			= "SELECT * FROM purchases WHERE supplier_id = '$supplier_id' AND YEAR(date) = '$year' AND MONTH(date) = '$month' ORDER BY date ASC, name ASC";
	}
	$result_purchase 			= $conn->query($sql_purchase);
	while($purchase 			= $result_purchase->fetch_assoc()){
		$invoice_id				= $purchase['id'];
		$invoice_date			= $purchase['date'];
		$invoice_name			= $purchase['name'];
		$invoice_value			= $purchase['value'];
		
		$sql_good_receipt		= "SELECT po_id FROM code_goodreceipt WHERE invoice_id = '$invoice_id'";
		$result_good_receipt	= $conn->query($sql_good_receipt);
		$good_receipt			= $result_good_receipt->fetch_assoc();
		
		$po_id					= $good_receipt['po_id'];
		
		$sql_po					= "SELECT name FROM code_purchaseorder WHERE id = '$po_id'";
		$result_po				= $conn->query($sql_po);
		$po						= $result_po->fetch_assoc();
		
		$po_name				= $po['name'];
		
		$total_value			+= $invoice_value;
?>
				<tr>
					<td><?= date('d M Y',strtotime($invoice_date)); ?></td>
					<td><?= $po_name ?></td>
					<td><?= $invoice_name ?></td>
					<td>Rp. <?= number_format($invoice_value,2) ?></td>
				</tr>
<?php
	}
?>
			</tbody>
<?php
	$categories					= array();
	$item_list_category_array	= $_POST['item_category'];
	
	$sql_item_category			= "SELECT id FROM itemlist_category";
	$result_item_cageory		= $conn->query($sql_item_category);
	while($item_category		= $result_item_cageory->fetch_assoc()){
		if(empty($item_list_category_array[$item_category['id']])){
			array_push($categories,$item_category['id']);
		}
	};
	$where						= ' AND ';
	if(!empty($categories)){
		foreach($categories as $category){
			$where					.= "itemlist.type = '" . $category . "' OR ";
			
			next($item_list_category_array);
		}
				
		
		$where				= substr($where,0,-3);
		if($month	== 0){
			$sql					= "SELECT itemlist.type, goodreceipt.quantity, goodreceipt.billed_price FROM goodreceipt 
										JOIN code_goodreceipt ON goodreceipt.gr_id = code_goodreceipt.id
										JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
										JOIN itemlist ON purchaseorder.reference = itemlist.reference
										WHERE YEAR(code_goodreceipt.date) = '$year' AND code_goodreceipt.supplier_id = '$supplier_id'" . $where;
		} else {
			$sql					= "SELECT itemlist.type, goodreceipt.quantity, goodreceipt.billed_price FROM goodreceipt 
										JOIN code_goodreceipt ON goodreceipt.gr_id = code_goodreceipt.id
										JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
										JOIN itemlist ON purchaseorder.reference = itemlist.reference
										WHERE YEAR(code_goodreceipt.date) = '$year' AND MONTH(code_goodreceipt.date) = '$month' AND code_goodreceipt.supplier_id = '$supplier_id'" . $where;
		}
		$deduction					= 0;
		$result						= $conn->query($sql);
		while($row					= $result->fetch_assoc()){
			$deduction				+= $row['billed_price'] * $row['quantity'];
		}
	}
?>
			<tfoot>
				<tr>
					<td colspan='2'></td>
					<td><strong>Total</strong></td>
					<td>Rp. <?= number_format($total_value,2) ?></td>
				</tr>
<?php
	if(!empty($categories)){
?>
				<tr>
					<td colspan='2'></td>
					<td><strong>Deduction</strong></td>
					<td>Rp. <?= number_format($deduction,2) ?></td>
				</tr>
				<tr>
					<td colspan='2'></td>
					<td><strong>Grand Total</strong></td>
					<td>Rp. <?= number_format($total_value - $deduction,2) ?></td>
				</tr>
<?php
	}
?>
			</tfoot>
		</table>
<?php
	if(!empty($categories)){
?>
		<p><strong>Note</strong></p>
		<p>Laporan pembelian di atas tidak termasuk dengan barang dengan kategori</p>
		<ul>
<?php
			foreach($categories as $category){
				$sql_category		= "SELECT name FROM itemlist_category WHERE id = '$category'";
				$result_category 	= $conn->query($sql_category);
				$category			= $result_category->fetch_assoc();
				
				$category_name		= $category['name'];
?>				
				<li><?= $category_name ?></li>
<?php			
				next($categories);
			}
	}
?>
	</div>
	<div class='row'>
		<div class='col-xs-12' style='text-align:center'>
			<button type='button' class='button_default_dark' id='print_button'><i class="fa fa-print" aria-hidden="true"></i></button>
		</div>
	</div>
</div>
<script>
	$('#print_button').click(function(){
		window.print();
	});
</script>