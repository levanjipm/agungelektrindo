<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class="row" id='edititemtable' style="background-color:#888;padding-top:30px">
	<div class="col-sm-10 offset-sm-1">
		<div class="container" style="background-color:#eee;height:300px;border-radius:30px">
<?php
	include("connect.php");
	$term = $_GET['term'];
	$sql = "SELECT * FROM stock INNER JOIN (SELECT MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) topscore ON stock.id = topscore.latest WHERE reference LIKE '%" . $term . "%' LIMIT 10";
	$result = $conn->query($sql);
	$i=0;
	while($row = $result->fetch_object()) {
		$function_result[$i]=$row;
		$reference = $row->reference;
		$sql_item = "SELECT * FROM itemlist WHERE reference = '" . $reference . "'";
		$result_item = $conn->query($sql_item);
		while($row_item = $result_item->fetch_assoc()) {
			$name = $row_item['description'];
		}
?>

			<?= $row->reference ?>
			<?= $name ?>
			<?= $row->stock ?><br>

<?php
		$i++;
	};
	if($i == 0){
		echo 'there are no result found';
	}
?>
			</div>
		</div>
	</div>
<?php
	//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	//header("Cache-Control: post-check=0, pre-check=0", false);
	//header("Pragma: no-cache");
	//header("Content-Type: application/json; charset=utf-8");
	//echo json_encode($function_result);
?>