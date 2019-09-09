<?php
	//Closing the purchaseorder//
	include('purchasingheader.php');
?>
<div class="main">
	<h2 style='font-family:bebasneue'>Purchase order</h2>
	<p>Close purchase order</p>
	<hr>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Date</th>
				<th>Supplier</th>
				<th>Purchase Order</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php
		//Close only the one that has not finished//
		$sql_initial = "SELECT COUNT(*) AS jumlah, SUM(status) AS status, purchaseorder_id FROM purchaseorder_received GROUP BY purchaseorder_id";
		$result_initial = $conn->query($sql_initial);
		while($row_initial = $result_initial->fetch_assoc()){
			$po_id 		= $row_initial['purchaseorder_id'];
			$jumlah 	= $row_initial['jumlah'];
			$status 	= $row_initial['status'];
			if ($jumlah != $status){
				$sql_po = "SELECT * FROM code_purchaseorder WHERE id = '" . $po_id . "' AND isclosed = '0'";
				$result_po = $conn->query($sql_po);		
				while($row_po = $result_po->fetch_assoc()){
?>
			<tr>
				<td><?= date('d M Y',strtotime($row_po['date'])) ?></td>
				<td><?= $row_po['name'] ?></td>
				<td>
				<?php
					$sql_supplier 		= "SELECT name,city FROM supplier WHERE id = '" . $row_po['supplier_id'] . "'";
					$result_supplier 	= $conn->query($sql_supplier);
					$row_supplier = $result_supplier->fetch_assoc();
					echo ($row_supplier['name']);
				?>
				</td>			
				<td>
					<button type="submit" class="button_danger_dark" onclick='submit_this(<?= $po_id ?>)'>X</button>
					<form action='close_purchaseorder_validation.php' method='POST' id='form<?= $po_id ?>'>
						<input type='hidden' value='<?= $po_id ?>' name='po_id'>
					</form>
				</td>
			</tr>
<?php
				}
			}
		}
?>
		</tbody>
	</table>
</div>
<script>
	function submit_this(n){
		$('#form' + n).submit();
	}
</script>
<?php
	if(empty($_GET['alert'])){
	} else if($_GET['alert'] == 'true'){
?>
	<div style='position:absolute;top:0;left:50%;'>
		<div class="alert alert-info" id='info'>
			<strong>Info!</strong>Closing purchase order success.
		</div>
	</div>
<?php
	} else if($_GET['alert'] == 'false'){
?>
	<div style='position:absolute;top:0;left:50%;'>
		<div class="alert alert-warning" id='info'>
			<strong>Info!</strong>Closing purchase order failed.
		</div>
	</div>
<?php
	}
?>
<script>
	$(document).ready(function(){
		setTimeout(function(){
			$('#info').fadeOut()
		}, 2000)
	});
</script>