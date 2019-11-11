<?php
	include('salesheader.php');
	$reference_array	= $_POST['reference'];
	$quantity_array		= $_POST['quantity'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Cost of Goods Sold</h2>
	<hr>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Quantity</th>
				<th>Unit price</th>
				<th>Total price</th>
			</tr>
		</thead>
		<tbody>
<?php
	$total_price			= 0;
	
	foreach($reference_array as $reference){
		$key		= key($reference_array);
		$quantity	= $quantity_array[$key];
		$price		= 0;
		
		$sql_stock_value 	= "SELECT sisa,price FROM stock_value_in WHERE sisa > 0 AND reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY id DESC";
		$result_stock_value	= $conn->query($sql_stock_value);
		while($stock_value 	= $result_stock_value->fetch_assoc()){
			$minimum_value	= min($stock_value['sisa'], $quantity);
			$price			+= $minimum_value * $stock_value['price'];
			
			$quantity		= $quantity - $minimum_value;
			if($quantity	== 0){
				break;
			}
		}
		
		$unit_price			= $price / $quantity_array[$key];
		$total_price		+= $price;
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= number_format($quantity_array[$key],0) ?></td>
				<td>Rp. <?= number_format($unit_price,2) ?></td>
				<td>Rp. <?= number_format($unit_price * $quantity_array[$key],2) ?></td>
			</tr>
<?php
		next($reference_array);
	}
?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan='2'></td>
				<td>Total</td>
				<td>Rp. <?= number_format($total_price,2) ?></td>
			</tr>
		</tfoot>
	</table>
	<p><strong>Note</strong></p>
	<ol>
		<li>Seluruh harga di atas sudah termasuk dengan PPn 10%</li>
		<li>Harga di atas merupakan harga per pada saat pengecekan, harga <strong>dapat berubah</strong> apabila waktu pengecekan berubah.</li>
	</ol>
	<a href='check_hpp_dashboard'>
		<button type='button' class='button_success_dark'>
			<i class="fa fa-long-arrow-left" aria-hidden="true"></i>
		</button>
	</a>
</div>