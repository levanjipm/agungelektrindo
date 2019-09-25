<?php
	include ("../codes/connect.php");
	session_start();
	$created_by = $_SESSION['user_id'];
	
	$do_date 		= mysqli_real_escape_string($conn,$_POST['do_date']);
	$customer 		= mysqli_real_escape_string($conn,$_POST['customer']);
	$do_number 		= mysqli_real_escape_string($conn,$_POST['do_number']);
	$tax 			= mysqli_real_escape_string($conn,$_POST['tax']);
	$do_name 		= mysqli_real_escape_string($conn,$_POST['do_name']);
	$so_id 			= mysqli_real_escape_string($conn,$_POST['so_id']);
	$guid			= $_POST['guid'];
	
	$sql			= "SELECT id FROM code_delivery_order WHERE guid = '$guid'";
	$result			= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){

		$sql_insert 	= "INSERT INTO code_delivery_order (date,number,tax,name,customer_id,sent,isdelete,so_id,created_by,created_date,guid) 
						VALUES ('$do_date','$do_number','$tax','$do_name','$customer','0','0','$so_id','$created_by',CURDATE(),'$guid')";
		$conn->query($sql_insert);	
		
		$sql_get_id			= "SELECT id FROM code_delivery_order WHERE name = '" . $do_name . "'";
		$result_get_id		= $conn->query($sql_get_id);
		$get_id				= $result_get_id->fetch_assoc();
		
		$do_id				= $get_id['id'];
		
		$reference_array	= $_POST['reference'];
		$quantity_array 	= $_POST['quantity'];
		
		foreach($reference_array as $reference){
			$key = key($reference_array);
			$quantity = $quantity_array[$key];
			
			if($quantity == '' || $quantity == 0){
			} else {
				$sql_insert_delivery_order 		= "INSERT INTO delivery_order (reference,quantity,do_id) VALUES ('$reference','$quantity','$do_id')";
				$conn->query($sql_insert_delivery_order);
				
				$sql_sales_order 				= "SELECT * FROM sales_order WHERE id = '" . $key . "'";
				$result_sales_order				= $conn->query($sql_sales_order);	
				$sales_order					= $result_sales_order->fetch_assoc();
				
				$ordered_quantity				= $sales_order['quantity'];
				$sent_quantity_before			= $sales_order['sent_quantity'];
				$sent_quantity_updated			= $sent_quantity_before + $quantity;
				
				$sql_update 					= "UPDATE sales_order SET sent_quantity = '" . $sent_quantity_updated . "' WHERE id = '" . $key . "'";
				$conn->query($sql_update);
				
				if($sent_quantity_updated == $ordered_quantity){
					$sql_update					= "UPDATE sales_order SET status = '1' WHERE id = '" . $key . "'";
					$conn->query($sql_update);
				}
			}
			next($reference_array);
		};
?>
	<script src='../universal/Jquery/jquery-3.3.0.min.js'></script>
	<body>
	<form method="POST" id="po_id" action="delivery_order_print.php" target="_blank">
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
<?php
	} else {
		header('location:inventory.php');
	}
?>