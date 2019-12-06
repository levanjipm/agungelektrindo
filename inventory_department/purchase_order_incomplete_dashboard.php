<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Pending purchase order</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Incomplete Purchase Order</h2>
	<hr>
	<style>
		input[type=text] {
			padding:10px;
			width: 130px;
			-webkit-transition: width 0.4s ease-in-out;
			transition: width 0.4s ease-in-out;
		}
		input[type=text]:focus {
			width: 100%;
		}
	</style>
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
				<button class="button_default_dark" type="submit" style='width:100%;height:100%' id='search_incomplete_po_supplier_button'>Search</button>
			</div>
		</div>
	</form>
	<br>
	<table class="table table-bordered">
		<tr>
			<th style="width:20%;font-size:1em">Date</th>
			<th style="width:30%;font-size:1em">PO Number</th>
			<th style="width:30%;font-size:1em">Supplier</th>
			<th></th>
		</tr>
		<tbody id='incomplete_po_table'>
<?php
	$i						= 0;
	$sql 					= "SELECT DISTINCT(purchaseorder_id) FROM purchaseorder WHERE status = '0'";
	$result 				= $conn->query($sql);
	while($row 				= $result->fetch_assoc()){
		$po_id 				= $row['purchaseorder_id'];
		
		$sql_po 			= "SELECT id,name,supplier_id,date FROM code_purchaseorder WHERE id = '" . $po_id . "'";
		$result_po 			= $conn->query($sql_po);
		$row_po 			= $result_po->fetch_assoc();
		$purchase_order_id	= $row_po['id'];
		$supplier_id 		= $row_po['supplier_id'];
		$name 				= $row_po['name'];
		$date 				= $row_po['date'];
		
		$po_array[$i]		= $purchase_order_id;
		
		$sql_supplier 		= "SELECT name,city FROM supplier WHERE id = '" . $supplier_id . "'";
		$result_supplier 	= $conn->query($sql_supplier);
		$supplier 			= $result_supplier->fetch_assoc();
		
		$supplier_name		= $supplier['name'];
?>
			<tr>
				<td><?= date('d M Y',strtotime($date)) ?></td>
				<td><?= $name?></td>
				<td><?= $supplier_name ?></td>
				<td style="width:50%">
					<button type='button' class="button_success_dark" onclick='showdetail(<?= $po_id ?>)' id="more_detail<?= $po_id ?>">
						<i class="fa fa-eye" aria-hidden="true"></i>
					</button>		
				</td>
			</tr>
<?php
		$i++;
	}
	
	$purchase_order_array	= json_encode($po_array);
?>
		</tbody>
	</table>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	var purchase_order_array		= <?= $purchase_order_array ?>;
	var purchase_order_array_length	= <?= $i - 1 ?>;
	
	function showdetail(n){
		if(n == purchase_order_array_length){
			var next_view	= 0;
		} else {
			var next_view	= n + 1;
		}
		
		if(n == 0){
			var prev_view	= purchase_order_array_length;
		} else {
			var prev_view	= n - 1;
		}
		
		$.ajax({
			url:'purchase_order_incomplete.php',
			data:{
				purchaseorder_id: n,
				next_view: next_view,
				prev_view: prev_view,
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
		$('#view_incomplete_po_box').fadeOut(150);
		$('#view_incomplete_po_box').html('');
		setTimeout(function(){
			showdetail(n);
		},150);
		
		setTimeout(function(){
			$('#view_incomplete_po_box').fadeIn();
		},450);
	};
</script>