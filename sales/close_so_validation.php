<?php
	include('salesheader.php');
	if(empty($_POST['id'])){
		header('location:sales.php');
	}
	$sql_initial = "SELECT name,customer_id FROM code_salesorder WHERE id = '" . $_POST['id'] . "'";
	$result_initial = $conn->query($sql_initial);
	$initial = $result_initial->fetch_assoc();
?>
<div class='main'>
	<div class='container'>
		<h2><?= $initial['name'] ?></h2>
		<p><?php
			$sql_customer = "SELECT name FROM customer WHERE id = '" . $initial['customer_id'] . "'";
			$result_customer = $conn->query($sql_customer);
			$customer = $result_customer->fetch_assoc();
			echo $customer['name'];
		?></p>
	</div>
	<table class='table'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity closed</th>
		</tr>
<?php
	$so_id = $_POST['id'];
	$sql_show = "SELECT reference,quantity FROM sales_order WHERE so_id = '" . $so_id . "'";
	$result_show = $conn->query($sql_show);
	while($show = $result_show->fetch_assoc()){
?>
		<tr>
			<td><?= $show['reference']; ?></td>
			<td><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $show['reference'] . "'";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td><?= $show['quantity'] ?></td>
		</tr>
<?php
	}
?>
	</table>
	<style>
	#pin {
		-webkit-text-security: disc;
		width:100%;
	}
	#pin::-webkit-inner-spin-button, 
	#pin::-webkit-outer-spin-button { 
		-webkit-appearance: none; 
		margin: 0; 
	}
	#pin_wrapper{
		height:100%;
		width:100%;
		background-color:rgba(117,117,177,0.9);
		z-index:50;
		position:absolute;
		top:0;
		display:none;
	}
	</style>
	<form action='close_so.php' method='POST' id='myForm'>
		<input type='hidden' value='<?= $so_id ?>' name='id'>
		<button type='button' class='btn btn-success' onclick='show_pin()'>Close Sales Order</button>
		<div class='row' id='pin_wrapper'>
			<div class='col-sm-4 col-sm-offset-3' style='position:absolute;top:40%'>
				<label>Input your pin</label><br>
				<input type='number' class='forming' name='pin' id='pin'><br><br>
				<button type='button' class='btn btn-default' onclick='check_pin()'>Confirm</button>
				<button type='button' class='btn btn-default'>Cancel</button>
			</div>
		</div>
	</form>
</div>
<script>
	function show_pin(){
		$('#pin_wrapper').fadeIn();
	}
	function check_pin(){
		var pin = $('#pin').val();
		if(pin == ''){
			alert('Insert correct pin!');
		} else if(pin.length != 6){
			alert('Invalid pin!');
		} else {
			$('#myForm').submit();
		}
	}
</script>