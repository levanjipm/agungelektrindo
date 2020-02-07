<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
	
	$class		= $_POST['class'];
	$sql		= "SELECT name FROM itemlist_category WHERE id = '$class'";
	$result		= $conn->query($sql);
	$row		= $result->fetch_assoc();
	
	$class_name	= $row['name'];
?>
<head>
	<title>Restock <?= $class_name ?></title>
</head>
<style>
@media print {
  body * {
    visibility: hidden;
  }
  #print_page, #print_page * {
    visibility: visible;
  }
  #print_page {
    position: absolute;
    left: 0;
    top: 0;
	width:100%;
  }
}
</style>
<div class='main'>
	<div id='print_page'>
	<h2 style='font-family:bebasneue'>Restock</h2>
	<p style='font-family:museo'><?= $class_name ?></p>
	<hr>
	
	<table class='table table-bordered'>
		<tr>
			<th style='width:35%'>Reference</th>
			<th style='width:25%'>Description</th>
			<th style='width:20%'>Quantity</th>
			<th style='width:20%'>Average per month</th>
		</tr>
<?php
	$sql		= "SELECT reference, description FROM itemlist WHERE type = '$class' ORDER BY reference ASC";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
		$reference	= $row['reference'];
		$description	= $row['description'];
		$sql_stock			= "SELECT stock FROM stock WHERE reference = '$reference' ORDER BY id DESC";
		$result_stock		= $conn->query($sql_stock);
		
		$stock_count		= mysqli_num_rows($result_stock);
		
		$row_stock			= $result_stock->fetch_assoc();
		$stock				= $row_stock['stock'];
		
		$sql_quantity		= "SELECT MIN(date) as min_date, MAX(date) as max_date, SUM(quantity) as quantity FROM stock WHERE reference = '$reference' AND transaction = 'OUT'";
		$result_quantity	= $conn->query($sql_quantity);
		$row_quantity		= $result_quantity->fetch_assoc();
		
		$min_date			= $row_quantity['min_date'];
		$max_date			= $row_quantity['max_date'];
		$diff 				= abs(strtotime($max_date) - strtotime($min_date));
		$quantity			= $row_quantity['quantity'];
		if($diff == 0){
			$average = 0;
		} else {
			$average			= $quantity * 60 * 60 * 24 * 30 / ($diff);
		}
		
		if($stock_count > 0){
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($stock) ?></td>
			<td><?= number_format($average,2) ?></td>
		</tr>
<?php
		}
	}
?>
	</table>
	</div>
	<button type='button' class='button_default_dark' id='print_button'><i class='fa fa-print'></i></button.
</div>
<script>
	$('#print_button').click(function(){
		window.print();
	});
</script>