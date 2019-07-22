<?php
	include('inventoryheader.php');
	$id = $_POST['id'];
	$sql = "SELECT * FROM code_salesorder WHERE id = '" . $id . "'";
	$result = $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
	<script>
		window.history.back();
	</script>
<?php
	}
	$row = $result->fetch_assoc();
	$customer_id = $row['customer_id'];
	$so_name = $row['name'];
	$taxing = $row['taxing'];
	$po_number = $row['po_number'];
	
	$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
?>
<div class='main'>
	<h2 style='font-family:bebasneue'><?= $so_name ?></h2>
	<h4 style='font-family:bebasneue'><?= $customer['name'] ?></h4>
	<p><?= $customer['address'] ?></p>
	<p><?= $customer['city'] ?></p>
	<hr>
	<form action='do_service_input.php' method='POST' id='do_service_form'>
		<label>Date</label>
		<input type='date' class='form-control' style='max-width:300px' name='service_date_send' id='service_date_send'>
		<br>
		<table class='table table-hover'>
			<tr>
				<td>Description</td>
				<td>Quantity</td>
				<td>Done</td>
			</tr>
			<input type='hidden' value='<?= $id ?>' name='id' readonly>
<?php
	$sql_detail = "SELECT * FROM service_sales_order WHERE so_id = '" . $id . "'";
	$result_detail = $conn->query($sql_detail);
	while($detail = $result_detail->fetch_assoc()){
		$quantity_max[$detail['id']] = $detail['quantity'] - $detail['done'];
?>
		<tr>
			<td><?= $detail['description'] ?></td>
			<td><?= $detail['quantity'] ?></td>
			<td><input type='number' class='form-control' name='quantity[<?= $detail['id'] ?>]' id='quantity<?= $detail['id'] ?>'></td>
		</tr>
<?php
	}
?>
		</form>
	</table>
	<button type='button' class='btn btn-secondary' id='service_send_button'>Send</button>
</div>
<script>
	quantity_array = <?= json_encode($quantity_max) ?>;
	function check_quantity(){
		var check_result = true;
		$('input[id^="quantity"]').each(function(){
			var key = $(this).attr('id').substr(-1);
			if($(this).val() > quantity_array[key]){
				alert('Cannot exceed quantity ordered');
				check_result = false;
			}
		})
		return check_result;
	}
	$('#service_send_button').click(function(){
		check_result = check_quantity();
		if($('#service_date_send').val() == ''){
			alert('Please insert valid date');
			$('#service_date_send').focus();
			return false;
		} else if(check_result == true){
			$('#do_service_form').submit();
		}
	});
</script>