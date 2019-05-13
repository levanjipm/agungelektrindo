<?php
	include("../../codes/connect.php");
	$term = $_GET['term'];
	$sql = "SELECT * FROM itemlist INNER JOIN
	(SELECT reference,stock FROM stock INNER JOIN (SELECT MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) topscore 
	ON stock.id = topscore.latest) AS stockawal ON stockawal.reference = itemlist.reference
	WHERE itemlist.reference LIKE '%" . $term . "%' OR description LIKE '%" . $term . "%'";
	$result = $conn->query($sql);
	$i=0;
	while($row = $result->fetch_object()) {
	$function_result[$i]=$row;
?>
	<div class="row" style="text-align:center">
		<div class="col-sm-3"><?= $row->reference ?></div>
		<div class="col-sm-5">
		<?= $row->description;?>
		</div>
		<div class="col-sm-2"><?= $row->stock ?></div>
		<div class='col-sm-1'>
			<button type='button' class='btn btn-default' onclick='view(<?= $row->id ?>)'>View Stock Card</button>
			<form id='form<?= $row->id ?>' action='stock_card.php' method='POST'>
				<input type='hidden' value='<?= $row->id ?>' name='item_id'>
			</form>
		</div>
	</div>
	<br>
<?php
		$i++;
		}
	//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	//header("Cache-Control: post-check=0, pre-check=0", false);
	//header("Pragma: no-cache");
	//header("Content-Type: application/json; charset=utf-8");
	//echo json_encode($function_result);
?>