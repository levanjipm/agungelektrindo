<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<?php
	include('../codes/connect.php');
	$q_id = $_POST['id'];
	$sql_delete = "DELETE FROM quotation WHERE quotation_code = '" . $q_id . "'";
	$result = $conn->query($sql_delete);
	$i = 1;
	$x = $_POST['jumlah_barang'];
	for ($i=1;$i<=$x;$i++){
		if(!empty($_POST['reference' . $i])){
			$reference = $_POST['reference' . $i];
			$price = $_POST['price' . $i];
			$discount = $_POST['discount' . $i];
			$quantity = $_POST['quantity' . $i];
			$net_price = $_POST['unitprice' . $i];
			$note = $_POST['comment'];
			$sql_insert = "INSERT INTO quotation (reference,price_list,discount,net_price,quantity,quotation_code) 
			VALUES ('$reference','$price','$discount','$net_price','$quantity','$q_id')";
			$r = $conn->query($sql_insert);			
		} else{
			$i++;
		}
	}
	$terms = $_POST['terms'];
	$dp = $_POST['dp'];
	$lunas = $_POST['lunas'];
	$sql_update = "UPDATE code_quotation SET payment_id = '" . $terms . "', down_payment = '" . $dp . "', 
	repayment = '" . $lunas . "', note = '" . $note . "' WHERE id = '" . $q_id . "'";
	$r = $conn->query($sql_update);
?>
<form method="POST" id="q_id" action="createquotation_print.php" target="_blank">
	<input name="id" value="<?= $q_id?>" type='hidden'>
</form>
<script>
$(document).ready(function () {
    window.setTimeout(function () {
		$('#q_id').submit();

	},100);
	window.setTimeout("location = ('sales.php');",125);
});
</script>