<?php
	include("purchasingheader.php")
?>
<div class='main'>
	<div class='row row-eq-height'>
		<div class='col-sm-4'>
			<a href='view_incomplete_po.php' style='text-decoration:none'>
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
			</a>
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
		function toggle_pending_so(){
			$('#pending_so').fadeIn();
			$('#pending_po').fadeOut();
		}
	</script>
	<hr>
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