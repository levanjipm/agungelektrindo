<script src='../universal/Jquery/jquery-3.3.0.min.js'></script>
<?php
	include('../codes/connect.php');
	$x = $_POST['i'];
	$do_id = $_POST['do_id'];
	$i = 1;
	for($i = 1; $i < $x; $i++){
		//Check if user has intentionally change the front-end security//
		$reference = $_POST['reference' . $i];
		$quantity = $_POST['quantity' . $i];
		$sql_code_so = "SELECT so_id FROM code_delivery_order WHERE id = '" . $do_id . "'";
		$result_code_so = $conn->query($sql_code_so);
		$code_so = $result_code_so->fetch_assoc();
		$sql_so = "SELECT id,quantity FROM sales_order WHERE so_id = '" . $code_so['so_id'] . "' AND reference = '" . $reference . "'";
		$result_so = $conn->query($sql_so);
		$so = $result_so->fetch_assoc();
		$ordered = $so['quantity'];
		$sql_sent = "SELECT quantity FROM sales_order_sent WHERE id = '" . $so['id'] . "'";
		$result_sent = $conn->query($sql_sent);
		$sent_so = $result_sent->fetch_assoc();
		$sent = $sent_so['quantity'];
		if($quantity + $sent <= $ordered){
			
		} else {
			header('location:edit_delivery_order.php');
		}
	}
	$y = 1;
	for($y = 1; $y < $x; $y++){
		$reference = $_POST['reference' . $y];
		$quantity = $_POST['quantity' . $y];
		$sql_code_so = "SELECT so_id FROM code_delivery_order WHERE id = '" . $do_id . "'";
		$result_code_so = $conn->query($sql_code_so);
		$code_so = $result_code_so->fetch_assoc();
		$sql_so = "SELECT id,quantity FROM sales_order WHERE so_id = '" . $code_so['so_id'] . "' AND reference = '" . $reference . "'";
		$result_so = $conn->query($sql_so);
		$so = $result_so->fetch_assoc();
		$ordered = $so['quantity'];
		$sql_sent = "SELECT quantity FROM sales_order_sent WHERE id = '" . $so['id'] . "'";
		$result_sent = $conn->query($sql_sent);
		$sent_so = $result_sent->fetch_assoc();
		$sent = $sent_so['quantity'];
		
		$sql_before = "SELECT quantity FROM delivery_order WHERE reference = '" . $reference . "' AND do_id = '" . $do_id . "'";
		$result_before = $conn->query($sql_before);
		$before = $result_before->fetch_assoc();
		$quantity_before = $before['quantity'];
		//Update the data on sales order sent//
		if($quantity + $sent - $quantity_before < $ordered){
			$sql_sent_updated = "UPDATE sales_order_sent SET quantity = '" . ($quantity + $sent - $quantity_before) . "',status = '0'
			WHERE id = '" . $so['id'] . "' AND reference = '" . $reference . "'";
		} else {
			$sql_sent_updated = "UPDATE sales_order_sent SET quantity = '" . ($quantity + $sent - $quantity_before) . "', status = '1'
			WHERE id = '" . $so['id'] . "' AND reference = '" . $reference . "'";
		}
		$result_sent_updated = $conn->query($sql_sent_updated);
		
		$sql_delete = "DELETE FROM delivery_order WHERE do_id = '" . $do_id . "'";
		$result_delete = $conn->query($sql_delete);
		
		$sql_insert = "INSERT INTO delivery_order (reference,quantity,do_id) VALUES ('$reference','$quantity','$do_id')";
		$result_insert = $conn->query($sql_insert);
	}
?>
	<form method='POST' action='do_print.php' id='print_form' target='_blank'>
		<input type='hidden' value='<?= $do_id ?>' name='id'>
	</form>
	<script>
		$(document).ready(function(){
			$('#print_form').submit();
		});
		setTimeout(function(){
			window.location.replace("inventory.php");
		},500)
	</script>