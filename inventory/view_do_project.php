	<h3>Document number</h3>
	<p>
		<?php
			include("../codes/connect.php");
			$do_id = $_GET['do_id'];
			$sql_project = "SELECT project_id FROM project_delivery_order WHERE id = '" . $do_id . "'";
			$result_project = $conn->query($sql_project);
			$project = $result_project->fetch_assoc();
			
			$sql = "SELECT project_name FROM code_project WHERE id = '" . $project['project_id'] . "'";
			$result = $conn->query($sql);
			$code = $result->fetch_assoc();
			echo ($code['project_name']);
		?>
	</p>
		<table class='table'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
<?php
	$i = 0;
	$sql_initial = "SELECT * FROM project WHERE project_do_id = '" . $do_id . "'";
	$result_initial = $conn->query($sql_initial);
	while($row_initial = $result_initial->fetch_object()){
?>
			<tr>
				<td><?=	$row_initial->reference ?></td>
				<td><?php
					$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $row_initial->reference . "'";
					$result_item = $conn->query($sql_item);
					$item = $result_item->fetch_assoc();
					echo $item['description'];
				?></td>
				<td><?= $row_initial->quantity ?></td>
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