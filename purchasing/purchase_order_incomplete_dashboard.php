<?php
	include('purchasingheader.php');
?>
<style>
	.view_incomplete_po_wrapper{
		background-color:rgba(30,30,30,0.7);
		position:fixed;
		z-index:100;
		top:0;
		width:100%;
		height:100%;
		display:none;
	}
	
	#view_incomplete_po_box{
		position:absolute;
		width:90%;
		left:5%;
		top:10%;
		height:80%;
		background-color:white;
		overflow-y:scroll;
		padding:20px;
	}
	
	#button_close_incomplete_po{
		position:absolute;
		background-color:transparent;
		top:10%;
		left:5%;
		outline:none;
		border:none;
		color:#333;
		z-index:120;
	}
</style>
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
	<input type='text' class='form-control' id='search_incomplete_po'>
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
	$sql 		= "SELECT DISTINCT(purchaseorder_id) FROM purchaseorder WHERE status = '0'";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
		$po_id 	= $row['purchaseorder_id'];
		
		$sql_po 			= "SELECT name,supplier_id,date FROM code_purchaseorder WHERE id = '" . $po_id . "'";
		$result_po 			= $conn->query($sql_po);
		$row_po 			= $result_po->fetch_assoc();
		$supplier_id 		= $row_po['supplier_id'];
		$name 				= $row_po['name'];
		$date 				= $row_po['date'];
		
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
				</td style="width:50%">
			</tr>
<?php
	}
?>
		</tbody>
	</table>
</div>
<div class='view_incomplete_po_wrapper'>
	<button id='button_close_incomplete_po'>X</button>
	<div id='view_incomplete_po_box'>
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
				$('#view_incomplete_po_box').html(response);
				$('.view_incomplete_po_wrapper').fadeIn();
			}
		});
	}
	
	$('#button_close_incomplete_po').click(function(){
		$('.view_incomplete_po_wrapper').fadeOut();
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
</script>