	<h3>Document number</h3>
	<p>
		<?php
			include("../../codes/connect.php");
			$term = $_GET['term'];
			$sql = "SELECT document FROM code_goodreceipt WHERE id = '" . $term . "'";
			$result = $conn->query($sql);
			while($code = $result->fetch_assoc()){
				$document = $code['document'];
			}
			echo $document;
		?>
	</p>
		<table class='table'>
			<tr>
				<th>Reference</th>
				<th>Quantity</th>
			</tr>
<?php

	$sql_initial = "SELECT * FROM goodreceipt WHERE id = '" . $term . "'";
	$result_initial = $conn->query($sql_initial);
	while($row_initial = $result_initial->fetch_assoc()){
		$gr_id = $row_initial['id'];
	}
	$sql_first = "SELECT received_id, quantity FROM goodreceipt WHERE gr_id = '" . $gr_id . "'";
	$i = 0;
	$result_first = $conn->query($sql_first);
	while($rows = $result_first->fetch_object()){
?>
			<tr>
				<td><?php
					$sql_receive = "SELECT reference FROM purchaseorder_received WHERE id = '" . $rows->received_id . "'";
					$result_receive = $conn->query($sql_receive);
					while ($row = $result_receive->fetch_assoc()){
						echo $row['reference'];
					}
				?></td>
				<td><?= $rows->quantity ?></td>
			</tr>
<?php
		$i++;
	}
	// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	// header("Cache-Control: post-check=0, pre-check=0", false);
	// header("Pragma: no-cache");
	// header("Content-Type: application/json; charset=utf-8");
	// echo json_encode($function_result);
?>