 <?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$name = "agungelektrindo";

	// Create connection
	global $conn;
	$conn = mysqli_connect($servername, $username, $password);

	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$selected = mysqli_select_db($conn, $name);
	$id=$_POST['id'];
	$sql = "SELECT DISTINCT(purchaseorder_received.purchaseorder_id), code_purchaseorder.id, code_purchaseorder.name 
	FROM code_purchaseorder LEFT JOIN purchaseorder_received ON purchaseorder_received.purchaseorder_id = code_purchaseorder.id 
	WHERE code_purchaseorder.supplier_id= '" . $id . "' AND purchaseorder_received.status = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
?>
		<option value="<?= $row['id']?>"><?= $row['name']?></option>
<?php
	}
?>
<script>
$(".select option").val(function(idx, val) {
	$(this).siblings('[value="'+ val +'"]').remove();
});
</script>
