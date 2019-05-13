<?php
	include('purchasingheader.php');
?>
<div class='main'>
	<h2>Creating purchase order</h2>
	<div class='row'>
		<div class='col-sm-2'>
			Reference
		</div>
		<div class='col-sm-2'>
			Quantity
		</div>
		<div class='col-sm-3'>
			Price
		</div>
		<div class='col-sm-1'>
			Discount
		</div>
		<div class='col-sm-3'>
			Total price
		</div>
	</div>
<?php
	$x = $_POST['x'];
	for($i = 1; $i <= $x; $i++){
?>
	<div class='row'>
		<div class='col-sm-2'>
			<input type='text' class='form-control' name='reference<?= $i ?>' value='<?= $_POST['reference' . $i] ?>'>
		</div>
		<div class='col-sm-2'>
			<input type='number' class='form-control' name='quantity<?= $i ?>' value='<?= $_POST['quantity' . $i] ?>'>
		</div>
		<div class='col-sm-3'>
			<input type='number' class='form-control' name='price<?= $i ?>'>
		</div>
		<div class='col-sm-1'>
			<input type='number' class='form-control' name='discount<?= $i ?>'>
		</div>
		<div class='col-sm-3'>
			<input type='number' class='form-control' name='price<?= $i ?>'>
		</div>
	</div>
<?php
	}
?>
	<hr>