<?php
	include("purchasingheader.php")
?>
<div class='main'>
	<div class='row row-eq-height'>
		<div class='col-sm-4'>
			<div class='row box_notif'>
				<div class='col-md-4' style='background-color:#34495e;padding-top:20px'>
					<button class='btn' type='button' style='background-color:transparent' onclick='toggle_pending_po()'>
						<img src='../universal/images/po.png' style='width:100%'>
					</button>
				</div>
				<div class='col-sm-8'>
				<?php
					$sql_pending_po = "SELECT COUNT(DISTINCT(purchaseorder_id)) AS po_id FROM purchaseorder_received WHERE status = '0'";
					$result_pending_po = $conn->query($sql_pending_po);
					$row_pending_po = $result_pending_po->fetch_assoc();
					echo ('<h1>' . $row_pending_po['po_id'] . '</h1>');
					echo ('<h3>Pending Purchase Order</h3>');
				?>
				</div>
			</div>
		</div>
		<div class='col-sm-4'>
			<div class='row box_notif'>
				<div class='col-sm-4' style='background-color:#56706f;padding-top:20px'>
					<button class='btn' type='button' style='background-color:transparent' onclick='toggle_pending_so()'>
						<img src='../universal/images/pending.png' style='width:100%'>
					</button>
				</div>
				<div class='col-md-8'>
				<?php
					$point = 0;
					$sql_pending_so = "SELECT * FROM sales_order_sent WHERE status = '0'";
					$result_pending_so = $conn->query($sql_pending_so);
					while($pending_so = $result_pending_so->fetch_assoc()){
						$reference_so = $pending_so['reference'];
						$so_id = $pending_so['so_id'];
						$quantity_sent = $pending_so['quantity'];
						$sql_so = "SELECT quantity FROM sales_order WHERE reference = '" . $reference_so . "' AND so_id = '" . $so_id . "'";
						$result_so = $conn->query($sql_so);
						$row_so = $result_so->fetch_assoc();
						$quantity_ordered = $row_so['quantity'];
						$sql_stock = "SELECT stock FROM stock WHERE reference = '" . $reference_so . "' ORDER BY ID DESC LIMIT 1";
						$result_stock = $conn->query($sql_stock);
						$row_stock = $result_stock->fetch_assoc();
						$stock = $row_stock['stock'];
						if($quantity_ordered <= $quantity_sent + $stock){
						} else {
							$point++;
						}
					}
					echo ('<h1>' . $point . '</h1>');
					echo ('<h3>Items need to be bought</h3>');
				?>
				</div>
			</div>
		</div>
	</div>
	<script>
		function toggle_pending_po(){
			$('#pending_so').fadeOut();
			$('#pending_po').fadeIn();
		}
		function toggle_pending_so(){
			$('#pending_so').fadeIn();
			$('#pending_po').fadeOut();
		}
	</script>
	<hr>
	<div class='row' id='pending_po' style='display:none'>
		<h2>Pending purchase order</h2>
		<table class="table">
			<tr style='background-color:#333;color:white;font-family:Verdana'>
				<th style="width:20%;font-size:1em">Date</th>
				<th style="width:30%;font-size:1em">PO Number</th>
				<th style="width:30%;font-size:1em">Supplier</th>
				<th></th>
			</tr>
	<?php
	$sql = "SELECT DISTINCT(purchaseorder_id) FROM purchaseorder_received WHERE status = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$po_id = $row['purchaseorder_id'];
		$sql_po = "SELECT name,supplier_id,date FROM code_purchaseorder WHERE id = '" . $po_id . "'";
		$result_po = $conn->query($sql_po);
		while($row_po = $result_po->fetch_assoc()){
			$supplier_id = $row_po['supplier_id'];
			$name = $row_po['name'];
			$date = $row_po['date'];
		}
	?>
			<tr>
				<td><strong><?= date('d M Y',strtotime($date)) ?></strong></td>
				<td><?= $name?></td>
				<td>
				<?php
					$sql_supplier = "SELECT name,city FROM supplier WHERE id = '" . $supplier_id . "'";
					$result_supplier = $conn->query($sql_supplier);
					while($row_supplier = $result_supplier->fetch_assoc()){
						echo ($row_supplier['name'] . ' - ' . $row_supplier['city']);
					}
				?>
				</td>
				<td style="width:50%">
					<button type='button' class="btn btn-default" onclick='showdetail(<?= $po_id ?>)' id="more_detail<?= $po_id ?>">+</button>
					<button type='button' class="btn btn-warning" onclick='lessdetail(<?= $po_id ?>)' id="less_detail<?= $po_id ?>" style="display:none" >-</button>			
				</td style="width:50%">
			</tr>
			<tbody style="display:none" id="<?= $po_id ?>">
<?php
		$sql_detail = "SELECT purchaseorder.reference, purchaseorder.quantity AS ordered, purchaseorder_received.id, purchaseorder.id, 
		purchaseorder_received.quantity, purchaseorder_received.status, purchaseorder_received.purchaseorder_id 
		FROM purchaseorder_received	INNER JOIN purchaseorder ON purchaseorder_received.id = purchaseorder.id 
		WHERE purchaseorder_received.status = '0' AND purchaseorder_received.purchaseorder_id = '" . $po_id . "'";
		$result_detail = $conn->query($sql_detail);
		while($row_detail = $result_detail->fetch_assoc()){
			$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $row_detail['reference'] . "'";
			$result_item = $conn->query($sql_item);
			while($row_item = $result_item->fetch_assoc()){
				$description = $row_item['description'];
			}	
?>
				<tr>
					<td><?= $row_detail['reference'] ?></td>
					<td><?= $description ?></td>
					<td><?= $row_detail['ordered'] - $row_detail['quantity'] . ' out of ' . $row_detail['ordered'] . ' uncompleted' ?></td>
				</tr>
<?php
		}
?>
			</tbody>
		<?php
	}
?>
		</table>
	</div>
	<div class='row' id='pending_so' style='display:none'>
		<h2>Pending items</h2>
		<table class="table">
			<tr style='background-color:#333;color:white;font-family:Verdana'>
				<th style="width:20%;font-size:1em">Reference</th>
				<th style="width:30%;font-size:1em">Quantity needs to be ordered</th>
			</tr>
			<form method='POST' action='createpurchaseorder_dashboard_list.php'>
<?php
		$x = 1;
		$sql_pending_so = "SELECT * FROM sales_order_sent WHERE status = '0'";
		$result_pending_so = $conn->query($sql_pending_so);
		while($pending_so = $result_pending_so->fetch_assoc()){
			$reference_so = $pending_so['reference'];
			$so_id = $pending_so['so_id'];
			$quantity_sent = $pending_so['quantity'];
			$sql_so = "SELECT quantity FROM sales_order WHERE reference = '" . $reference_so . "' AND so_id = '" . $so_id . "'";
			$result_so = $conn->query($sql_so);
			$row_so = $result_so->fetch_assoc();
			$quantity_ordered = $row_so['quantity'];
			$sql_stock = "SELECT stock FROM stock WHERE reference = '" . $reference_so . "' ORDER BY ID DESC LIMIT 1";
			$result_stock = $conn->query($sql_stock);
			$row_stock = $result_stock->fetch_assoc();
			$stock = $row_stock['stock'];
			if($quantity_ordered <= $quantity_sent + $stock){
			} else {
				$quantity_so = $quantity_ordered - $quantity_sent - $stock;
?>
			<tr>
				<td>
					<?= $reference_so ?>
					<input type='hidden' value='<?= $reference_so ?>' name='reference<?= $x ?>'>
				</td>
				<td>
					<?= $quantity_so ?>
					<input type='hidden' value='<?= $quantity_so ?>' name='quantity<?= $x ?>'>
				</td>
			</tr>
<?php
			}
		}
?>
			</tbody>
		</table>
		<br><br>
		<input type='hidden' value='<?= $x ?>' name='x'>
		<button type='submit' class='btn btn-default'>Create purchase order from list</button>
	</div>
	<script>
		function showdetail(n){
			$("#" + n).show();
			$("#less_detail" + n).show();
			$("#more_detail" + n).hide();
		}
		function lessdetail(n){
			$("#" + n).hide();
			$("#less_detail" + n).hide();
			$("#more_detail" + n).show();
		}
	</script>
</div>