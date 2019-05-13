<?php
	//action return//
	include('salesheader.php');
	if(empty($_POST['return_id'])){
?>
	<script>
		window.history.back(1);
	</script>
<?php
	}
	$return_id = $_POST['return_id'];
	//Find out which form did the user submit//	
	$status = $_POST['status'];
	$sql_initial = "SELECT do_id FROM code_sales_return WHERE id = '" . $return_id . "'";
	$result_initial = $conn->query($sql_initial);
	$initial = $result_initial->fetch_assoc();
	$do_id = $initial['do_id'];
	
	$sql_do = "SELECT name,customer_id FROM code_delivery_order WHERE id = '" . $do_id . "'";
	$result_do = $conn->query($sql_do);
	$do = $result_do->fetch_assoc();

?>
<style>
.forming{
	border:none;
	border-bottom:2px solid #999;
	background-color:transparent;
	display:block;
	width:100%;
	-webkit-text-security: disc;
}
input::-webkit-inner-spin-button {
	-webkit-appearance: none;
	margin: 0;
}
input[type=number] {
    -moz-appearance:textfield; /* Firefox */
}
.forming:focus{
	outline-width: 0;
}
</style>
<?php
	//Case where would like to confirm the return//
	if($status == 1){
?>
	<div class='main'>
		<h3 id='demo'></h3>
		<h5><?php
			$sql_customer = "SELECT name FROM customer WHERE id = '" . $do['customer_id'] . "'";
			$result_customer = $conn->query($sql_customer);
			$customer = $result_customer->fetch_assoc();
			echo $customer['name']
		?></h5>
		<script>
		var t = 0;
		var txt = '<?= $do['name'] ?>';
		var speed = 50;
		$(document).ready(function(){
			typeWriter();
		});
		function typeWriter() {
			if (t < txt.length) {
				document.getElementById("demo").innerHTML += txt.charAt(t);
				t++;
				setTimeout(typeWriter, speed);
			}
		}
		</script>
		<table class='table'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
<?php
		$sql_table = "SELECT * FROM sales_return WHERE return_code = '" . $return_id . "'";
		$result_table = $conn->query($sql_table);
		while($return = $result_table->fetch_assoc()){
?>
			<tr>
				<td><?= $return['reference'] ?></td>
				<td><?php
					$sql_item = 'SELECT description FROM itemlist WHERE reference = "' . $return['reference'] . '"';
					$result_item = $conn->query($sql_item);
					$item = $result_item->fetch_assoc();
					echo $item['description'];
				?></td>
				<td><?= $return['quantity'] ?></td>
			</tr>
<?php
		}
?>
		</table>
		<div class='row'>
			<div class='col-sm-3'>
				<form action='action_return_input.php' method='POST' id='return_form'>
					<input type='hidden' value='<?= $return_id ?>' name='return_id'>
					<input type='hidden' value='<?= $status ?>' name='status'>
					<input type='hidden' value='<?= $_SESSION['user_id'] ?>' name='user_id'>
					<label>Input your pin</label>
					<input type='number' class='forming' pattern="[0-9]*" inputmode="numeric" id='pin' name='pin'>
					<br><br>
					<button type='button' class='btn' onclick='check_pin()'>Submit</button>
				</form>
			</div>
		</div>
	</div>
<?php
	}
?>
<script>
	function check_pin(){
		var pin = $('#pin').val();
		if(pin == ''){
			alert('Insert correct pin');
		} else if(pin.length != 6){
			alert('Pin consist of 6 digits');
		} else {
			$('#return_form').submit();
		}
	}
</script>