<?php
	include("../../codes/connect.php");	
	$term 	= mysqli_real_escape_string($conn,$_GET['term']);
	if($term != ''){
		$sql 	= "SELECT id, reference, description FROM itemlist WHERE reference LIKE '%" . $term . "%' OR description LIKE '%" . $term . "%'";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
			$reference		= $row['reference'];
			$description	= $row['description'];
			$item_id		= $row['id'];
			
			$sql_stock		= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY id DESC LIMIT 1";
			$result_stock	= $conn->query($sql_stock);
			$stock			= $result_stock->fetch_assoc();
			
			$stock_			= ($stock == NULL) ? '0' : $stock['stock'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= $stock_ ?></td>
			<td>
				<a href='stock_card?id=<?= $item_id ?>'>
					<button type='button' class='button_default_dark' onclick='view(<?= $item_id ?>)'>View</button>
				</a>
			</td>
		</tr>
<?php
		}
	} else {
		$sql 	= "SELECT * FROM stock
				INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) recent_stock 
				ON stock.reference = recent_stock.reference 
				AND stock.id = recent_stock.latest LIMIT 50";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
			$reference		= $row['reference'];
			$stock			= $row['stock'];
			
			$sql_item 		= "SELECT id,description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item 	= $conn->query($sql_item);
			$item	 		= $result_item->fetch_assoc();
			
			$item_id 		= $item['id'];
			$description	= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= $stock ?></td>
				<td>
					<a href='stock_card?id=<?= $item_id ?>'>
						<button type='button' class='button_default_dark'>View</button>
					</a>
				</td>
				
				<form id='form<?= $item_id ?>' action='stock_card' method='POST'>
					<input type='hidden' value='<?= $item_id ?>' name='item_id'>
				</form>
			</tr>
<?php
		}
	}
?>