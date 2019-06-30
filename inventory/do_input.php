<?php
	include ("../codes/connect.php");
	session_start();
	
	$do_date = mysqli_real_escape_string($conn,$_POST['do_date']);
	$customer = mysqli_real_escape_string($conn,$_POST['customer']);
	$do_number = mysqli_real_escape_string($conn,$_POST['do_number']);
	$tax = mysqli_real_escape_string($conn,$_POST['tax']);
	$s = mysqli_real_escape_string($conn,$_POST['jumlah']);
	$do_name = mysqli_real_escape_string($conn,$_POST['do_name']);
	$so_id = mysqli_real_escape_string($conn,$_POST['so_id']);

	$sql_insert = "INSERT INTO code_delivery_order (date,number,tax,name,customer_id,sent,isdelete,so_id,created_by,created_date) 
	VALUES ('$do_date','$do_number','$tax','$do_name','$customer','0','0','$so_id','" . $_SESSION['user_id'] . "',CURDATE())";
	$r = $conn->query($sql_insert);	
	$sql_call = "SELECT * FROM code_delivery_order WHERE name = '" . $do_name . "'";
	$o = $conn->query($sql_call);
	$row_do = $o->fetch_assoc();
	$do_id = $row_do['id'];
	for($i = 1; $i <= $s; $i++){
		$item = $_POST['item' . $i];
		$qty = $_POST['qty' . $i];
		if($qty == '' || $qty == 0){
		} else {
			$sql_insert_to = "INSERT INTO delivery_order (reference,quantity,do_id) VALUES ('$item','$qty','$do_id')";
			$result = $conn->query($sql_insert_to);
			
			$sql_sent = "SELECT * FROM sales_order_sent WHERE so_id = '" . $so_id . "' AND reference = '" . $item . "'";
			$results = $conn->query($sql_sent);	
			
			$row_sent = $results->fetch_assoc();
			
			$sent = $row_sent['quantity'];
			$sent_new = $sent + $qty;
			$sql_update = "UPDATE sales_order_sent SET quantity = '" . $sent_new . "' WHERE so_id = '" . $so_id . "' AND reference = '" . $item . "'";
			$updated_results = $conn->query($sql_update);	
			
			$sql_ordered = "SELECT * FROM sales_order WHERE so_id = '" . $so_id . "' AND reference = '" . $item . "'";
			$result_status_one = $conn->query($sql_ordered);
			
			$row_o = $result_status_one->fetch_assoc();
			$quantity_one = $row_o['quantity'];
			$sql_sent = "SELECT * FROM sales_order_sent WHERE so_id = '" . $so_id . "'AND reference = '" . $item . "'";
			$result_status_two = $conn->query($sql_sent);
			$row_s = $result_status_two->fetch_assoc();
			$quantity_two = $row_s['quantity'];
			if ($quantity_one == $quantity_two){
				$sql_update_status = "UPDATE sales_order_sent SET status = '1' WHERE so_id = '" . $so_id . "' AND reference = '" . $item . "'";
				$result_udpate_status = $conn->query($sql_update_status);
			};
		}
	};
?>
<script src='../universal/Jquery/jquery-3.3.0.min.js'></script>
<body>
<form method="POST" id="po_id" action="do_print.php" target="_blank">
	<input type="hidden" name="id" value="<?= $do_id?>">
</form>
</body>
<script>
$(document).ready(function () {
    window.setTimeout(function () {
		$('#text').html('Creating print format');
	}, 200);
});
$(document).ready(function () {
    window.setTimeout(function () {
		$('#po_id').submit();
	}, 400);
	window.setTimeout("location = ('inventory.php');",500);
});
</script>