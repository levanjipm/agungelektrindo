<?php
	include('inventoryheader.php');
	$jumlah = $_POST['jumlah'];
	$date = $_POST['date'];
	$nilai = 1;
	for($i = 1; $i <= $jumlah; $i++){
		$sql_check = "SELECT stock FROM stock WHERE reference = '" . $_POST['reference' . $i] . "' ORDER BY id DESC LIMIT 1";
		$result_check = $conn->query($sql_check);
		if(mysqli_num_rows($result_check)){
			$check = $result_check->fetch_assoc();
			$stock = $check['stock'];
			if($stock >= $_POST['quantity' . $i]){
			} else {
?>
<script>
	window.history.back();
</script>
<?php
			}
		} else {
?>
<script>
	window.history.back();
</script>
<?php
		}
	}
	$project_id = $_POST['project_id'];
	$sql = "SELECT * FROM code_project WHERE id = '" . $project_id . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$sql_customer = "SELECT name FROM customer WHERE id = '" . $row['customer_id'] . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
?>
<div class='main'>
	<h2><?= $row['project_name']; ?></h2>
	<?= $customer['name'] ?>
	<hr>
	<form action='project_do_input.php' method='POST' id='project_form'>
		<input type='hidden' value='<?= $project_id ?>' readonly name='projects'>
		<input type='hidden' value='<?= $date ?>' readonly name='date'>
		<table class='table table-hover'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
<?php
	for($x = 1; $x<= $jumlah; $x++){
?>
			<tr>
				<td>
					<?= $_POST['reference' . $x] ?>
					<input type='hidden' value='<?= $_POST['reference' . $x] ?>' name='reference<?= $x ?>'>
				</td>
				<td><?php
					$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $_POST['reference' . $x] . "'";
					$result_item = $conn->query($sql_item);
					$item = $result_item->fetch_assoc();
					echo $item['description'];
				?></td>
				<td>
					<?= $_POST['quantity' . $x] ?>
					<input type='hidden' value='<?= $_POST['quantity' . $x] ?>' name='quantity<?= $x ?>'>
				</td>
			</tr>
<?php
	}
?>
		</table>
		<hr>
		<input type='hidden' value='<?= $jumlah ?>' name='jumlah'>
		<button type='button' class='btn btn-default' id='submit_project'>Submit</button>
	</form>
</div>
<script>
	$('#submit_project').click(function(){
		$('#project_form').submit();
	});
</script>
