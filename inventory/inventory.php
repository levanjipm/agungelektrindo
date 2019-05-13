<?php
	include("inventoryheader.php")
?>
<div class='main'>
	<div class='row'>
		<div class='col-md-4 col-sm-4'>
			<div class='row box_notif'>
				<div class='col-md-5' style='background-color:#95a5a6;padding-top:20px'>
					<button class='btn' type='button' style='background-color:transparent' onclick='toggle_delivery()'>
						<img src='../universal/images/truck.png' style='width:100%'>
					</button>
				</div>
				<div class='col-md-7'>
				<?php
					$sql_calendar = "SELECT COUNT(*) AS delivery FROM code_delivery_order WHERE date = '" . date('Y-m-d') . "' AND sent = '0'";
					$result_calendar = $conn->query($sql_calendar);
					$row = $result_calendar->fetch_assoc();
					echo ('<h1>' . $row['delivery'] . '</h1>');
					echo ('<h3>Delivery is on Process</h3>');
				?>
				</div>
			</div>
		</div>
		<div class='col-md-4 col-sm-4'>
			<div class='row box_notif'>
				<div class='col-md-5' style='background-color:#34495e;padding-top:20px'>
					<button class='btn' type='button' style='background-color:transparent' onclick='toggle_pending_po()'>
						<img src='../universal/images/po.png' style='width:100%'>
					</button>
				</div>
				<div class='col-md-7'>
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
		<div class='col-md-4 col-sm-4'>
			<div class='row box_notif'>
				<div class='col-md-5' style='background-color:#2c3e50;padding-top:20px'>
					<button class='btn' type='button' style='background-color:transparent' onclick='toggle_pending_so()'>
						<img src='../universal/images/so.png' style='width:100%'>
					</button>
				</div>
				<div class='col-md-7'>
				<?php
					$sql_pending_so = "SELECT COUNT(DISTINCT(so_id)) AS jumlah_so FROM sales_order_sent WHERE status = '0'";
					$result_pending_so = $conn->query($sql_pending_so);
					$row_pending_so = $result_pending_so->fetch_assoc();
					echo ('<h1>' . $row_pending_so['jumlah_so'] . '</h1>');
					echo ('<h3>Pending Sales Order</h3>');
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
		$row_po = $result_po->fetch_assoc();
		$supplier_id = $row_po['supplier_id'];
		$po_name = $row_po['name'];
		$date = $row_po['date'];
	?>
			<tr>
				<td><strong><?= date('d M Y',strtotime($date)) ?></strong></td>
				<td><?= $po_name?></td>
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
					<td><?= $row_detail['ordered'] - $row_detail['quantity'] . ' out of ' . $row_detail['ordered'] . ' incomplete' ?></td>
				</tr>
<?php
		}
?>
				<tr>
					<td colspan='3'>
						<button type='button' class='btn btn-default' onclick='goodreceipt(<?= $po_id ?>)'>
							Create good receipt
						</button>
						<form action='goodreceipt.php' method='POST' id='form<?= $po_id ?>'>
							<input type='hidden' value="<?= $po_id ?>" name='po'>
							<input type='hidden' value='<?= date('Y-m-d',strtotime('today')) ?>' name='date'>
							<input type='hidden' value='<?= $supplier_id ?>' name='supplier'>
						</form>
					</td>
				</tr>
			</tbody>
		<?php
	}
?>
		</table>
	</div>
	<div class='row' id='pending_so' style='display:none'>
		<h2>Pending sales order</h2>
		<table class='table'>
			<tr style='background-color:#2c3e50;color:white;font-family:Verdana'>
				<th style="width:20%;font-size:1em">Date</th>
				<th style="width:30%;font-size:1em">SO Number</th>
				<th style="width:30%;font-size:1em">Customer</th>
				<th></th>
			</tr>
	<?php	
	$sql = "SELECT DISTINCT(so_id) FROM sales_order_sent WHERE status = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$so_id = $row['so_id'];
		$sql_name = "SELECT * FROM code_salesorder WHERE id = '" . $so_id . "'";
		$result_name = $conn->query($sql_name);
		while($row_name = $result_name->fetch_assoc()){
			$so_name = $row_name['name'];
			$customer_id = $row_name['customer_id'];
			$so_date = $row_name['date'];
		}
		$sql_customer = "SELECT * FROM customer WHERE id = '" . $customer_id . "'";
		$result_customer = $conn->query($sql_customer);
		while($row_customer = $result_customer->fetch_assoc()){
			$customer_name = $row_customer['name'];
		}
?>
			<tr>
				<td><strong><?= date('d M Y',strtotime($so_date)) ?></strong></td>
				<td><?= $so_name ?></td>
				<td><?= $customer_name ?></td>
				<td style="width:50%">
					<button type='button' class="btn btn-default" onclick='showdetailso(<?= $so_id ?>)' id="more_detail_so<?= $so_id ?>">+</button>
					<button type='button' class="btn btn-warning" onclick='lessdetailso(<?= $so_id ?>)' id="less_detail_so<?= $so_id ?>" style="display:none" >-</button>			
				</td style="width:50%">
			</tr>		
			<tbody id='so<?= $so_id ?>' style='display:none'>
<?php
		$sql_child = "SELECT sales_order.id, sales_order_sent.id, sales_order.quantity AS quantity_ordered,sales_order_sent.reference, sales_order_sent.status, sales_order.reference, sales_order_sent.quantity AS quantity_sent 
		FROM sales_order_sent INNER JOIN sales_order ON sales_order.id = sales_order_sent.id
		WHERE sales_order_sent.status = '0' AND sales_order_sent.so_id = '" . $so_id . "'";
		$result_child = $conn->query($sql_child);
		$i = 1;
		while($row_child = $result_child->fetch_assoc()){
			$reference = $row_child['reference'];
			$quantity_sent = $row_child['quantity_sent'];
			$quantity_ordered = $row_child['quantity_ordered'];
			$quantity = $quantity_ordered - $quantity_sent;
?>
				<tr>
					<td><?= $reference ?></td>
					<td><?php
						$sql_item_so = "SELECT description FROM itemlist WHERE reference = '" . $reference . "'";
						$result_item_so = $conn->query($sql_item_so);
						$row_item_so = $result_item_so->fetch_assoc();
						echo $row_item_so['description'];
					?></td>
					<td><?= $quantity . ' out of ' . $quantity_ordered . ' incomplete' ?></td>
				</tr>
<?php
			}
?>
				<tr>
					<td colspan='3'>
						<button type='button' class='btn btn-default' onclick='submit(<?= $so_id ?>)'>Create delivery order</button>
						<form method='POST' action='do_exist_dasboard.php' id='form<?= $so_id ?>'>
							<input type='hidden' value='<?= $so_name ?>' name='so_id'>
						</form>
					</td>
				</tr>
			</tbody>
<?php
		}
?>
		</table>
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
	function showdetailso(n){
		$("#so" + n).show();
		$("#less_detail_so" + n).show();
		$("#more_detail_so" + n).hide();
	}
	function lessdetailso(n){
		$("#so" + n).hide();
		$("#less_detail_so" + n).hide();
		$("#more_detail_so" + n).show();
	}
	function submit(n){
		$('#form' + n).submit();
	}
	function goodreceipt(n){
		$('#form' + n).submit();
	}
</script>
</div>