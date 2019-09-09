<?php
	include('salesheader.php');
	$reference_array	= $_POST['reference'];
	$quantity_array		= $_POST['quantity'];
?>
<div class='main'>
<?php
	foreach($reference_array as $reference){
		$key		= key($reference_array);
		$quantity	= $quantity_array[$key];
		
		$sql_stock_value 	= "SELECT quantity,sisa,harga FROM stock_value_in WHERE sisa > 0 ORDER BY id DESC";
		$result_stock_value	= $conn->query($sql_stock_value);
		while($stock_value 	= $result_stock_value->fetch_assoc()){
		}
		
		next($reference_array);
	}
?>