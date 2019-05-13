<?php
	//Search stock value//
	include('../../codes/connect.php');
	$start = $_POST['start'];
	$end = $_POST['end'];
?>
	<table class='table table-hover'>
		<tr>
			<th>Date</th>
			<th>Stock Value</th>
			<th></th>
		</tr>
<?php
	$selisih = abs(strtotime($start) - strtotime($end))/86400;
	for ($i = 0; $i <= $selisih; $i++){
		$total = 0;
		$sql_in = "SELECT id,quantity,price FROM stock_value_in WHERE date <= '" . date('Y-m-d', strtotime($start . "+" . $i . " days")) . "'";
		$result_in = $conn->query($sql_in);
		while($in = $result_in->fetch_assoc()){
			$sql_out = "SELECT SUM(quantity) AS quantity_out FROM stock_value_out WHERE date <= '" . date('Y-m-d', strtotime($start . "+" . $i . " days")) . "' AND in_id = '" . $in['id'] . "'";
			$result_out = $conn->query($sql_out);
			$out = $result_out->fetch_assoc();
			$quantity = $in['quantity'] - $out['quantity_out'];
			$total = $total + $quantity * $in['price'];
		};
?>
		<tr>
			<td><?= date('d M Y',strtotime('+' . $i . 'day', strtotime($start))) ?></td>
			<td>Rp. <?= number_format($total,2) ?></td>
			<td>
				<button type='button' class='btn btn-default' onclick='submiting(<?= $i ?>)'>View detail</button>
				<form action='stock_value_detail.php' id='form<?= $i ?>' method='POST'>
					<input type='hidden' value='<?= date('Y-m-d', strtotime($start . "+" . $i . " days")) ?>' name='date'>
				</form>
			</td>
		</tr>
<?php
	}
?>
<script>
	function submiting(n){
		$('#form' + n).submit();
	}
</script>