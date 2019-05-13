<?php
	//editing Sales order//
	include('salesheader.php');
	$so_id = $_POST['id'];
	if($so_id == NULL){
		header('location:sales.php');
	}
?>
<link rel='stylesheet' href='../jquery-ui.css'>
<script src='../jquery-ui.js'></script>
<script>
$( function() {
	$('input[id^="reference"]').autocomplete({
		source: "search_item.php"
	 })
});
</script>
	<div class='main'>
	<h2>Edit sales Order</h2>
	<form method='POST' action='edit_so_input.php'>
<?php
		$sql_initial =  "SELECT name,customer_id,po_number FROM code_salesorder WHERE id = '" . $so_id . "'";
		$result_initial = $conn->query($sql_initial);
		$row_initial = $result_initial->fetch_assoc();
		echo $row_initial['name'];
?><br><?php
		$sql_customer = "SELECT name FROM customer WHERE id = '" . $row_initial['customer_id'] . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
		echo $customer['name'];
?><input type='text' class='form-control' value='<?= $row_initial['po_number']; ?>'>
<br><br>
<?php
	$tt = 1;
	$sql_so = "SELECT id,reference,quantity,price,price_list FROM sales_order WHERE so_id = '" . $so_id . "'";
	$result_so = $conn->query($sql_so);
	while($so = $result_so->fetch_assoc()){
		$min_qty = 0;
		$sql_code_do = "SELECT id FROM code_delivery_order WHERE so_id = '" . $so_id . "'";
		$result_code_do = $conn->query($sql_code_do);
		while($row_code_do = $result_code_do->fetch_assoc()){
			$do_id = $row_code_do['id'];
			$sql_do = "SELECT quantity FROM delivery_order WHERE do_id = '" . $do_id . "' AND reference = '" . $so['reference'] . "'";
			$result_do = $conn->query($sql_do);
			$do = $result_do->fetch_assoc();
			$min_qty = $min_qty + $do['quantity'];
		}
?>
	<div class='row'>
		<input type='hidden' value ='<?= $so['id']; ?>' name='id_<?= $tt ?>'>
		<div class='col-lg-2'>
			<input type='text' disabled value='<?= $so['reference']; ?>' class='form-control'>
		</div>
		<div class='col-lg-3'>
			<input type='number' value='<?= $so['quantity']; ?>' class='form-control' min='<?= $min_qty ?>' name='existingqty<?= $tt ?>'>
			
		</div>
		<div class='col-lg-3'>
			<input type='number' value='<?= $so['price']; ?>' class='form-control' name='existingprice<?= $tt ?>'>
		</div>
		<div class='col-lg-3'>
			<input type='number' value='<?= $so['price_list']; ?>' class='form-control' name='existingpl<?= $tt ?>'>
		</div>
		<br><br>
	</div>
<?php
	$tt++;
	};
	for($x = 1; $x <= 5; $x++){
?>
	<div class='row' style='display:none' id='row<?= $x ?>'>
		<div class='col-lg-2'>
			<input type='text' class='form-control' id='reference<?= $x ?>' name='reference<?= $x ?>'>
		</div>
		<div class='col-lg-3'>
			<input type='number' value='<?= $so['quantity']; ?>' class='form-control' min='0' name='quantity<?= $x ?>' id='quantity<?= $x ?>'>
		</div>
		<div class='col-lg-3'>
			<input type='number' value='<?= $so['price']; ?>' class='form-control' min='0' name='price<?= $x ?>' id='price<?= $x ?>'>
		</div>
		<div class='col-lg-3'>
			<input type='number' value='<?= $so['price_list']; ?>' class='form-control' min='0' name='pl<?= $x ?>' id='pl<?= $x ?>'>
		</div>
		<br><br>
	</div>
<?php
	}
?>
	<hr>
<?php
	$x = 1;
	for($x = 1; $x <= 5; $x++){
		if($x == 1){
?>
	<div class='row'>
		<div class='col-lg-10'>
		</div>
		<div class='col-lg-1'>
			<button type='button' class='btn btn-default' onclick='plus(<?= $x ?>)' id='button<?= $x?>'>+</button>
		</div>
	</div>
<?php
		} else {
?>
	<div class='row'>
		<div class='col-lg-10'>
		</div>
		<div class='col-lg-1'>
			<button type='button' class='btn btn-default' onclick='plus(<?= $x ?>)' style='display:none' id='button<?= $x?>'>+</button>
		</div>
	</div>
<?php
		}
	}
?>
	<input type='hidden' value='<?= $tt ?>' name='tt'>
	<input type='hidden' value='<?= $so_id ?>' name='id_so'>
	<button type='submit' class='btn btn-primary' onclick='ceksent()'>Next</button>
	</form>
	<script>
		function plus(n){
		var id_baru = n
		var id_lebih_baru = 0 + 1 + n;
		$('#row' + id_baru).show();
		$('#button' + id_baru).hide();
		$('#button' + id_lebih_baru).show();
		}
	</script>