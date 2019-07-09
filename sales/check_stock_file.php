<?php
	include('salesheader.php');
	$target_dir = "files/";
	$file_name = basename($_FILES["fileToUpload"]["name"]);
	$tmp_name = $_FILES['fileToUpload']['tmp_name'];
	$terupload = move_uploaded_file($tmp_name, $target_dir.$file_name);
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Check Stock</h2>
	<p><?= $file_name ?>
	<hr>
	<table class='table table-hover'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Stock</th>
		</tr>
<?php	
	$file_complete = $target_dir . $file_name;
	
	$file = fopen($file_complete,"r");
	$data = fgetcsv($file, 1000, ";");
	$i = 1;
	while (($data = fgetcsv($file, 1000, ";")) !== FALSE){
		$the_big_array[$i] = $data;
		$i++;
	}
	foreach($the_big_array as $array){
		$reference = $array[0];
		$quantity = $array[1];
		$sql_item = "SELECT COUNT(id) AS existance FROM itemlist WHERE reference = '" . $reference . "'";
		$result_item = $conn->query($sql_item);
		$item = $result_item->fetch_assoc();
		if($item['existance'] == 0){
?>
		<tr class='danger'>
			<td><?= $reference ?></td>
			<td colspan='3'>Reference not found</td>
		</tr>
<?php
		} else {
			$sql_stock = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC";
			$result_stock = $conn->query($sql_stock);
			$stock = $result_stock->fetch_assoc();
			
			$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $reference . "'";
			$result_item = $conn->query($sql_item);
			$item = $result_item->fetch_assoc();
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $item['description']; ?></td>
			<td><?= $quantity ?></td>
			<td><?php
				if($stock['stock'] == NULL){
					echo (0);
				} else {
					echo $stock['stock'];
				}
			?></td>
		</tr>
<?php
		}
	}
?>
	</table>
<?php
	unlink($file_complete)
?>