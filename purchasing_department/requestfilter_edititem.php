<?php
	include ("../codes/connect.php");
	$search = $_POST['id'];
	$sql = "SELECT * FROM itemlist WHERE refference LIKE '%" . $search . "%'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
	?>
		<tr>
		<td style="text-align:center" width="40%"><?= $row['refference']?></td>
		<td style="text-align:center" width="40%"><?= $row['description']?></td>
		<td width="20%"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal-<?=$row['id']?>">Edit</td>
		<td width="20%"><button type="button" class="btn btn-danger">Delete</td>
		</tr>		
	<?php
	}
?>
