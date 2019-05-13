<?php
	//Closing the purchaseorder//
	include('purchasingheader.php');
?>
<div class="main">
	<div class="container" style="right:50px">
		<h2>Purchase order</h2>
		<h4 style="color:#444">Editing purchase order</h4>
		<hr>
		<br>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>Date</th>
				<th>Supplier</th>
				<th>Purchase Order</th>
				<th>Properties</th>
			</tr>
		</thead>
		<tbody>
<?php
		//Close only the one that has not finished//
		$sql_initial = "SELECT COUNT(*) AS jumlah, SUM(status) AS status, purchaseorder_id FROM purchaseorder_received GROUP BY purchaseorder_id";
		$result_initial = $conn->query($sql_initial);
		while($row_initial = $result_initial->fetch_assoc()){
			$po_id = $row_initial['purchaseorder_id'];
			$jumlah = $row_initial['jumlah'];
			$status = $row_initial['status'];
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
				$sql_supplier = "SELECT name,city FROM supplier WHERE id = '" . $row_po['supplier_id'] . "'";
				$result_supplier = $conn->query($sql_supplier);
				while($row_supplier = $result_supplier->fetch_assoc()){
					echo ($row_supplier['name'] . ' - ' . $row_supplier['city']);
				}
			?>
			</td>			
			<td>
				<button type="submit" class="btn btn-danger" onclick='submit_this(<?= $po_id ?>)'>Close this PO</button>
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