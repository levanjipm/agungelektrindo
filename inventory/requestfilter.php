 <?php
	include ("connect.php");
	$id=$_POST['id'];
	$sql = "SELECT purchaseorder_received.purchaseorder_id, code_purchaseorder.id, code_purchaseorder.name 
	FROM code_purchaseorder LEFT JOIN purchaseorder_received ON purchaseorder_received.purchaseorder_id = code_purchaseorder.id 
	WHERE code_purchaseorder.supplier_id= '" . $id . "' AND purchaseorder_received.status = '0'";
	echo $sql;
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
