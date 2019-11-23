<?php
	include("../codes/connect.php");
	if($_GET['term'] != ''){
		$term 		= mysqli_real_escape_string($conn,$_GET['term']);
		$sql 		= "SELECT * FROM itemlist INNER JOIN
					(SELECT reference,stock,id FROM stock INNER JOIN (SELECT MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) topscore 
					ON stock.id = topscore.latest) AS stockawal ON stockawal.reference = itemlist.reference
					WHERE itemlist.reference LIKE '%" . $term . "%' OR description LIKE '%" . $term . "%'";
		$result 	= $conn->query($sql);
		while($row 	= $result->fetch_assoc()){
			$stock			= $row['stock'];
			$reference		= $row['reference'];		
			$description	= $row['description'];
?>
	<tr>
		<td><?= $reference ?></td>
		<td><?= $description ?></td>
		<td><?= $stock ?></td>
	</tr>
<?php
		}
	} else {
		$sql 		= "SELECT * FROM stock
					INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) topscore 
					ON stock.reference = topscore.reference 
					AND stock.id = topscore.latest
					LIMIT 10";
		$result 	= $conn->query($sql);
		while($row 	= $result->fetch_assoc()) {
			$stock			= $row['stock'];
			$reference		= $row['reference'];
			
			$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item 	= $conn->query($sql_item);
			$item	 		= $result_item->fetch_assoc();
			
			$description	= $item['description'];
?>
	<tr>
		<td><?= $reference ?></td>
		<td><?= $description ?></td>
		<td><?= $stock ?></td>
	</tr>
<?php
		}
	}
?>