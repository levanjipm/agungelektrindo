<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/administrator_header.php');
	$good_receipt_id			= $_POST['id'];
	
	
	$sql_good_receipt			= "SELECT * FROM code_goodreceipt WHERE id = '$good_receipt_id'";
	$result_good_receipt		= $conn->query($sql_good_receipt);
	$good_receipt				= $result_good_receipt->fetch_assoc();
	
	$gr_name					= $good_receipt['document'];
	$gr_date					= $good_receipt['date'];
	$supplier_id				= $good_receipt['supplier_id'];
	
	$detail_array			= array();
	$sql_detail				= "SELECT id FROM goodreceipt WHERE gr_id = '$good_receipt_id'";
	$result_detail			= $conn->query($sql_detail);
	while($detail			= $result_detail->fetch_assoc()){
		array_push($detail_array, $detail['id']);
	};
	
	$array						= implode("','",$detail_array);
	
	$sql_status					= "SELECT id FROM stock_value_in WHERE supplier_id = '$supplier_id' AND gr_id IN ('" . $array . "') 
									AND (stock_value_in.quantity = stock_value_in.sisa)";
	$result_status				= $conn->query($sql_status);
	$status						= mysqli_num_rows($result_status);
	
	if(empty($_POST['id']) || $status == 0){
?>
	<script>
		window.location.href='delivery_order_delete_dashboard';
	</script>
<?php
	}
?>
<head>
	<title>Delete <?= $gr_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Good receipt</h2>
	<p style='font-family:museo'>Delete good receipt</p>
	<hr>
	<label>Good receipt date</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($gr_date)) ?></p>
	
	<label>Good receipt name</label>
	<p style='font-family:museo'><?= $gr_name ?></p>
	
	<label>Detail</label>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
	$sql			= "SELECT purchaseorder.reference, goodreceipt.quantity, itemlist.description FROM goodreceipt
						JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
						JOIN itemlist ON purchaseorder.reference = itemlist.reference	
						WHERE goodreceipt.gr_id = '$good_receipt_id'";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$reference		= $row['reference'];
		$description	= $row['description'];
		$quantity		= $row['quantity'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity) ?></td>
		</tr>
<?php
	}
?>
	</table>
	<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class='fa fa-exclamation'></i></h1>
		<p style='font-family:museo'>Are you sure to delete this good receipt?</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Submit</button>
	</div>
</div>
<form action='good_receipt_delete_input' method='POST' id='good_receipt_delete_form'>
	<input type='hidden' value='<?= $good_receipt_id ?>' name='id'>
</form>
<script>
	$('#submit_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		
		$('.full_screen_notif_bar').css('top', 0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn(300);
	});
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
	});
	
	$('#confirm_button').click(function(){
		$('#good_receipt_delete_form').submit();
	});
</script>