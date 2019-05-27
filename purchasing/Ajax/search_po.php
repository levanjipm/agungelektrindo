<?php
	include('../../codes/connect.php');
	$supplier = $_POST['supplier'];
	$sql_search = "SELECT *	FROM code_purchaseorder WHERE supplier_id = '" . $supplier . "' GROUP BY MONTH(date)";
	$result_search = $conn->query($sql_search);
	while($search = $result_search->fetch_assoc()){
?>
		<option value='<?= $search['id'] ?>'><?= $search['name'] ?></option>
<?php
	}
?>