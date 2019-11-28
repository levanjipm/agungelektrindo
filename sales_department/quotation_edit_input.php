<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<?php
	include('../codes/connect.php');
	$q_id 				= $_POST['id'];
	$sql_delete 		= "DELETE FROM quotation WHERE quotation_code = '" . $q_id . "'";
	$conn->query($sql_delete);
	$reference_array	= $_POST['reference'];
	$price_array		= $_POST['price'];
	$discount_array		= $_POST['discount'];
	$quantity_array		= $_POST['quantity'];
	
	foreach($reference_array as $reference){
		$key 		= key($reference_array);
		$price 		= $price_array[$key];
		$discount 	= $discount_array[$key];
		$quantity 	= $quantity_array[$key];
		
		$net_price = $price * (1 - $discount * 0.01);
		
		$sql_insert = "INSERT INTO quotation (reference,price_list,discount,net_price,quantity,quotation_code) 
					VALUES ('$reference','$price','$discount','$net_price','$quantity','$q_id')";
		$conn->query($sql_insert);
		
		next($reference_array);
	};

	$terms 		= $_POST['terms'];
	$dp 		= $_POST['dp'];
	$lunas 		= $_POST['lunas'];
	$comment	= mysqli_real_escape_string($conn,$_POST['comment']);
	$sql_update = "UPDATE code_quotation SET payment_id = '" . $terms . "', down_payment = '" . $dp . "', 
	repayment = '" . $lunas . "', note = '" . $comment . "' WHERE id = '" . $q_id . "'";
	$r = $conn->query($sql_update);
?>
<form method="POST" id="q_id" action="quotation_create_print.php" target="_blank">
	<input name="id" value="<?= $q_id?>" type='hidden'>
</form>
<script>
$(document).ready(function () {
    window.setTimeout(function () {
		$('#q_id').submit();

	},100);
	window.setTimeout("location = ('/agungelektrindo/sales');",125);
});
</script>