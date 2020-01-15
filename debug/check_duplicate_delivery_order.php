<?php
	include('../codes/connect.php');
?>
	<table>
		<tr>
			<td>Name</td>
			<td>Counted</td>
		</tr>
<?php
	$sql						= "SELECT DISTINCT(name) FROM code_delivery_order";
	$result						= $conn->query($sql);
	while($row					= $result->fetch_assoc()){
		$delivery_order_name	= $row['name'];
		$sql_count				= "SELECT COUNT(id) as jumlah FROM code_delivery_order WHERE name = '$delivery_order_name'";
		$result_count			= $conn->query($sql_count);
		$count					= $result_count->fetch_assoc();
		
		$counted				= $count['jumlah'];
		if($counted				> 1){
?>
			<tr>
				<td><?= $delivery_order_name ?></td>
				<td><?= $counted ?></td>
			</tr>
<?php
		}
	}
?>