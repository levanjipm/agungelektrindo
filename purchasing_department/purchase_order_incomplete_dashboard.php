<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
?>
<head>
	<title>Incomplete purchase order</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Incomplete Purchase Order</h2>
	<hr>
	<label>Search by item or purchase order name</label>
	<input type='text' class='form-control' id='search_incomplete_po'>
	<form action='purchase_order_incomplete_supplier' method='POST'>
		<label>View by supplier</label>
		<div class="input-group">
			<select class='form-control' name='supplier_id' style='width:300px'>
<?php
	$sql_incomplete_supplier	= "SELECT DISTINCT(code_purchaseorder.supplier_id), supplier.name FROM code_purchaseorder JOIN
								purchaseorder ON purchaseorder.purchaseorder_id = code_purchaseorder.id JOIN
								supplier ON code_purchaseorder.supplier_id = supplier.id
								WHERE purchaseorder.status = '0'";
	$result_incomplete_supplier	= $conn->query($sql_incomplete_supplier);
	while($incomplete_supplier	= $result_incomplete_supplier->fetch_assoc()){
?>
				<option value='<?= $incomplete_supplier['supplier_id'] ?>'><?= $incomplete_supplier['name'] ?></option>
<?php
	}
?>
			</select>
			<div class="input-group-append" style='width:100px'>
				<button class="button_default_dark" type="submit" style='width:100%;height:100%' id='search_incomplete_po_supplier_button'><i class='fa fa-search'></i></button>
			</div>
		</div>
	</form>
	<br>
	<table class="table table-bordered">
		<tr>
			<th style='width:20%'>Date</th>
			<th style='width:30%'>PO Number</th>
			<th style='width:30%'>Supplier</th>
			<th></th>
		</tr>
		<tbody id='incomplete_po_table'>
<?php
	$i			= 0;
	$sql 		= "SELECT DISTINCT(purchaseorder.purchaseorder_id), code_purchaseorder.name, code_purchaseorder.date,
					supplier.name as supplier_name, supplier.address, supplier.city
					FROM purchaseorder 
					JOIN code_purchaseorder ON purchaseorder.purchaseorder_id = code_purchaseorder.id
					JOIN supplier ON code_purchaseorder.supplier_id = supplier.id
					WHERE purchaseorder.status = '0'";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
		$purchase_order_id	= $row['purchaseorder_id'];
		$name 				= $row['name'];
		$date 				= $row['date'];
		
		$supplier_name		= $row['supplier_name'];
		$supplier_address	= $row['address'];
		$supplier_city		= $row['city'];
?>
			<tr>
				<td><?= date('d M Y',strtotime($date)) ?></td>
				<td><?= $name?></td>
				<td>
					<p style='font-family:museo'><?= $supplier_name ?></p>
					<p style='font-family:museo'><?= $supplier_address ?></p>
					<p style='font-family:museo'><?= $supplier_city ?></p>
				</td>
				<td>
					<button type='button' class="button_success_dark" onclick='showdetail(<?= $purchase_order_id ?>)'>
						<i class="fa fa-eye" aria-hidden="true"></i>
					</button>		
				</td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function showdetail(n){
		$.ajax({
			url:'purchase_order_incomplete.php',
			data:{
				purchaseorder_id: n,
			},
			type:'POST',
			success:function(response){
				$('.full_screen_box').html(response);
				$('.full_screen_wrapper').fadeIn();
			}
		});
	}
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#search_incomplete_po').change(function(){
		$.ajax({
			url:'purchase_order_incomplete_search.php',
			data:{
				term: $('#search_incomplete_po').val(),
			},
			type:'POST',
			success:function(response){
				$('#incomplete_po_table').html('');
				$('#incomplete_po_table').append(response);
			}
		});
	});
	
	function change_slide(n){
		$('.full_screen_box').fadeOut(150);
		$('.full_screen_box').html('');
		setTimeout(function(){
			showdetail(n);
		},150);
		
		setTimeout(function(){
			$('.full_screen_box').fadeIn();
		},450);
	};
</script>