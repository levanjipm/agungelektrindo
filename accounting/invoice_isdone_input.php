
<?php
	include('../codes/connect.php');
	if(empty($_POST['id'])){
		header('location:accounting.php');
	}
	if(empty($_POST['date'])){
?>
	<script>
		window.history.back();
	</script>
<?php
	} else {
		$id = $_POST['id'];
		$date = $_POST['date'];
		$sql_update = "UPDATE invoices SET isdone = '1' WHERE id = '" . $id . "'";
		$result_update = $conn->query($sql_update);
		
		$sql = "SELECT customer_id,value FROM invoices WHERE id = '" . $id . "'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		
		$value = $row['value'];
		
		$sql_receive = "SELECT SUM(value) AS jumlah_bayar FROM receivable WHERE invoice_id = '" . $id . "'";
		$result_receive = $conn->query($sql_receive);
		$receive = $result_receive->fetch_assoc();
		
		$paid = $receive['receive'];
		$dilunaskan = $value - $paid;
		
		$sql_insert = "INSERT INTO receivable (invoice_id,date,value)
		VALUES ('$id','$date','$dilunaskan')";
		$result_insert = $conn->query($sql_insert);
?>
	<form action='customer_view.php' method='POST' name='customer_form'>
		<input type='hidden' value='<?= $row['customer_id'] ?>' name='customer'>
	</form>
	<script>
		document.customer_form.submit();
	</script>
<?php
	}
?>