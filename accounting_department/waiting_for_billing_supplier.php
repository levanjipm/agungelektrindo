<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	$sql = "SELECT * FROM code_goodreceipt WHERE isinvoiced = '0' ORDER BY date ASC";
	$result = $conn->query($sql);
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase Invoice</h2>
	<p>Waiting for billing</p>
	<div id='naming'></div>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Supplier</th>
			<th>Document Number</th>
			<th>Value</th>
			<th></th>
		</tr>
<?php
	$i						= 0;
	$uninvoiced_value 		= 0;
	$gr_array				= [];
	while($row 				= $result->fetch_assoc()){
		$code_gr_id			= $row['id'];
		$supplier_id 		= $row['supplier_id'];
		$sql_supplier 		= "SELECT name FROM supplier WHERE id = '" . $supplier_id . "'";
		$result_supplier 	= $conn->query($sql_supplier);
		$row_supplier 		= $result_supplier->fetch_assoc();
		$supplier_name 		= $row_supplier['name'];
		
		$total 				= 0;
		$sql_initial 		= "SELECT * FROM goodreceipt WHERE gr_id = '" . $row['id'] . "'";
		$result_initial 	= $conn->query($sql_initial);
		while($row_initial 	= $result_initial->fetch_assoc()){
			$received_id 	= $row_initial['received_id'];
			$quantity 		= $row_initial['quantity'];
			$sql_price 		= "SELECT unitprice FROM purchaseorder WHERE id = '" . $received_id . "'";
			$result_price 	= $conn->query($sql_price);
			$row_price 		= $result_price->fetch_assoc();
			$price 			= $row_price['unitprice'];
			$total 			+= $quantity * $price;
		}
		
		$uninvoiced_value 	+= $total;
		
		$gr_array[$i]		= $code_gr_id;
		$i++;
?>
		<tr>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $supplier_name ?></td>
			<td><?= $row['document']?></td>
			<td><?= 'Rp.' . number_format($total,2); ?></td>
			<td>
				<button type='button' class='button_success_dark' onclick='show_detail_pending(<?= $code_gr_id ?>)'>
					<i class="fa fa-eye" aria-hidden="true"></i>
				</button>
			</td>
		</tr>
<?php
	}
	
	$gr_array_js	= json_encode($gr_array);
?>
	</table>
</div>
<style>
	#view_pending_bills_wrapper{
		position:fixed;
		width:100%;
		height:100%;
		top:0;
		background-color:rgba(20,20,20,0.8);
		z-index:30;
		display:none;
	}
	
	#view_pending_bills_box{
		width:80%;
		height:80%;
		background-color:white;
		z-index:35;
		position:absolute;
		top:10%;
		left:10%;
		padding:30px;
		overflow-y:scroll;
	}
</style>
<div id='view_pending_bills_wrapper'>
	<div id='view_pending_bills_box'>
	</div>
</div>
<script src='../universal/Numeral-js-master/numeral.js'></script>
<script>
	var gr_array		= <?= $gr_array_js ?>;
	var gr_array_length = <?= $i - 1 ?>;
	
	$(document).ready(function(){
		var uninvoiced_value = numeral(<?= $uninvoiced_value?>).format('0,0.00');
		$('#naming').text('Rp. ' + uninvoiced_value);
	});
	
	function show_detail_pending(n){
		if(n == gr_array_length){
			var next_view	= 0;
		} else {
			var next_view	= n + 1;
		}
		
		if(n == 0){
			var prev_view	= gr_array_length;
		} else {
			var prev_view	= n - 1;
		}
		
		$.ajax({
			url:'waiting_for_billing_view.php',
			data:{
				code_gr:n,
				next_view: next_view,
				prev_view: prev_view,
			},
			type:'POST',
			beforeSend:function(){
				$('#view_pending_bills_box').html('');
			},
			success:function(response){
				$('#view_pending_bills_box').html(response);
				setTimeout(function(){
					$('#view_pending_bills_wrapper').fadeIn();
				},200);
			}
		});
	}
	
	function change_slide(n){
		$('#view_pending_bills_box').fadeOut(150);
		$('#view_pending_bills_box').html('');
		setTimeout(function(){
			show_detail_pending(n);
		},150);
		
		setTimeout(function(){
			$('#view_pending_bills_box').fadeIn();
		},450);
	};
</script>