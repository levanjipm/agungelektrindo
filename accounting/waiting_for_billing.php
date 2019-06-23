<?php
	//Waiting for billing//
	include('accountingheader.php');
	$sql = "SELECT * FROM code_goodreceipt WHERE isinvoiced = '0'";
	$result = $conn->query($sql);
?>
<div class='main'>
	<h2>Purchase Invoice</h2>
	<p>Waiting for billing</p>
	<div id='naming'></div>
	<hr>
	<table class='table table-hover'>
		<tr>
			<th>Date</th>
			<th>Supplier</th>
			<th>Document Number</th>
			<th>Value</th>
		</tr>
<?php
	$total_buat = 0;
	while($row = $result->fetch_assoc()){
?>
		<tr>
			<td><?= $row['date']; ?></td>
			<td>
				<?php
				$supplier_id = $row['supplier_id'];
				$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $supplier_id . "'";
				$result_supplier = $conn->query($sql_supplier);
				while($row_supplier = $result_supplier->fetch_assoc()){
					$supplier_name = $row_supplier['name'];
				}
				echo $supplier_name
				?>
			</td>
			<td><?= $row['document']?></td>
			<td>
				<?php
					$total = 0;
					$sql_initial = "SELECT * FROM goodreceipt WHERE gr_id = '" . $row['id'] . "'";
					$result_initial = $conn->query($sql_initial);
					while($row_initial = $result_initial->fetch_assoc()){
						$received_id = $row_initial['received_id'];
						$quantity = $row_initial['quantity'];
						$sql_price = "SELECT unitprice FROM purchaseorder WHERE id = '" . $received_id . "'";
						$result_price = $conn->query($sql_price);
						while($row_price = $result_price->fetch_assoc()){
							$price = $row_price['unitprice'];
						}
						$total = $total + $quantity * $price;
					}
					echo 'Rp.' . number_format($total,2);
				?>
			</td>
			<?php
			$total_buat = $total_buat + $total;
			}
			?>
		</tr>
	</table>
</div>
<script src='../universal/Numeral-js-master/numeral.js'></script>
<script>
	$(document).ready(function(){
		var name_tot = numeral(<?= $total_buat?>).format('0,0.00');
		console.log(name_tot);
		$('#naming').text('Rp. ' + name_tot);
	});
</script>