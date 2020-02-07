<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	
	$supplier_id	= $_POST['supplier_id'];
	$sql 			= "SELECT * FROM code_goodreceipt WHERE isinvoiced = '0'  AND supplier_id = '$supplier_id' ORDER BY date ASC";
	$result 		= $conn->query($sql);
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase Invoice</h2>
	<p style='font-family:museo'>Waiting for billing</p>
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
		$sql_supplier 		= "SELECT name FROM supplier WHERE id = '$supplier_id'";
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

<div class='full_screen_wrapper'>
	<button type='button' class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'>
	</div>
</div>

<script>
	var gr_array		= <?= $gr_array_js ?>;
	var gr_array_length = <?= $i - 1 ?>;
	
	$(document).ready(function(){
		var uninvoiced_value = numeral(<?= $uninvoiced_value?>).format('0,0.00');
		$('#naming').text('Rp. ' + uninvoiced_value);
	});
	
	function show_detail_pending(n){
		$.ajax({
			url:'waiting_for_billing_view.php',
			data:{
				code_gr:n,
			},
			type:'POST',
			beforeSend:function(){
				$('.full_screen_box').html('');
			},
			success:function(response){
				$('.full_screen_box').html(response);
				setTimeout(function(){
					$('.full_screen_wrapper').fadeIn();
				},200);
			}
		});
	}
	
	$('.full_screen_close_button').click(function(){
		$(this).parent().fadeOut();
	});
</script>