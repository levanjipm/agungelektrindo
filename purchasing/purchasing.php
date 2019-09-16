<?php
	include("purchasingheader.php")
?>
<div class='main'>
	<div class='row row-eq-height'>
		<div class='col-sm-3 col-xs-4' style='padding:20px;padding-top:0'>
			<a href='view_incomplete_po.php' style='text-decoration:none;color:#333;'>
				<div class='row'>
					<div class='col-sm-12 box'>
					<?php
						$sql_pending_po = "SELECT COUNT(DISTINCT(purchaseorder_id)) AS incomplete_po FROM purchaseorder WHERE status = '0'";
						$result_pending_po = $conn->query($sql_pending_po);
						$row_pending_po = $result_pending_po->fetch_assoc();
						
						if($row_pending_po['incomplete_po'] > 50){
							$bar_width = 50;
						} else {
							$bar_width = $row_pending_po['incomplete_po'];
						}
						
						echo ('<h1>' . $row_pending_po['incomplete_po'] . '</h1>');
						echo ('<h3>Pending Purchase Order</h3>');
					?>
						<div class='bar_wrapper'>
							<div class='bar' id='pending_purchaseorder_bar'></div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<script>
			$(document).ready(function(){
				$('#pending_purchaseorder_bar').animate({
					width: "<?= max(40, (2 * $bar_width)) ?>%"
				},300)
			})
		</script>
		<div class='col-sm-3 col-xs-4' style='padding:20px;padding-top:0'>
			<div class='row'>
				<div class='col-xs-12 box' id='sales_order_view_button'>
<?php
					$point = 0;
					$sql_pending_so 		= "SELECT * FROM sales_order WHERE status = '0'";
					$result_pending_so 		= $conn->query($sql_pending_so);
					while($pending_so 		= $result_pending_so->fetch_assoc()){
						$reference_so 		= $pending_so['reference'];
						$so_id 				= $pending_so['so_id'];
						$quantity_sent 		= $pending_so['quantity'];
						
						$sql_so 			= "SELECT quantity FROM sales_order WHERE reference = '" . $reference_so . "' AND so_id = '" . $so_id . "'";
						$result_so 			= $conn->query($sql_so);
						$row_so 			= $result_so->fetch_assoc();
						$quantity_ordered 	= $row_so['quantity'];
						
						$sql_stock 			= "SELECT stock FROM stock WHERE reference = '" . $reference_so . "' ORDER BY ID DESC LIMIT 1";
						$result_stock 		= $conn->query($sql_stock);
						$row_stock 			= $result_stock->fetch_assoc();
						$stock 				= $row_stock['stock'];
						if($quantity_ordered > $quantity_sent + $stock){
							$point++;
						}
						
						
						if($point > 100){
							$bar_width = 50;
						} else {
							$bar_width = $point;
						}
					}
					echo ('<h1>' . $point . '</h1>');
					echo ('<h3>Items need to be bought</h3>');
?>			
					<div class='bar_wrapper'>
						<div class='bar' id='pending_sales_order_bar'></div>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				$('#pending_sales_order_bar').animate({
					width: "<?= max(20, ($bar_width)) ?>%"
				},300)
			})
			$('#sales_order_view_button').click(function(){
				$('#pending_so').fadeIn();
				$('#pending_po').fadeOut();
			});
		</script>
	</div>
	<div class='row' id='pending_so' style='display:none'>
		<div class='col-xs-12'>
			<h2 style='font-family:bebasneue'>Pending items</h2>
			<table class="table table-hover">
				<tr'>
					<th style="width:20%;font-size:1em">Reference</th>
					<th style="width:30%;font-size:1em">Quantity needs to be ordered</th>
				</tr>
				<form method='POST' action='createpurchaseorder_dashboard_list.php'>
<?php
		$x = 1;
		$sql_pending_so = "SELECT * FROM sales_order WHERE status = '0'";
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