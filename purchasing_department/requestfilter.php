<?php
	include ("../connect.php");
	$id=$_POST['id'];
	$sql = "SELECT DISTINCT code_purchaseorder.name,code_purchaseorder.id FROM code_purchaseorder 
	JOIN purchaseorder ON purchaseorder.purchaseorder_id=code_purchaseorder.id 
	WHERE code_purchaseorder.supplier_id=" . $id . " AND purchaseorder.status = 0";
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
