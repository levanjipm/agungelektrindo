<?php
	include('../codes/connect.php');
	$id					= $_POST['code_gr'];
	$next_view			= $_POST['next_view'];
	$prev_view			= $_POST['prev_view'];
	
	$sql_code_gr		= "SELECT * FROM code_goodreceipt WHERE id = '$id'";
	$result_code_gr		= $conn->query($sql_code_gr);
	$code_gr			= $result_code_gr->fetch_assoc();
		
	$document_name		= $code_gr['document'];
	$purchase_order_id	= $code_gr['po_id'];
	$sql_po				= "SELECT name, taxing FROM code_purchaseorder WHERE id = '$purchase_order_id'";
	$result_po			= $conn->query($sql_po);
	$po					= $result_po->fetch_assoc();
	
	$po_name			= $po['name'];
	$taxing				= $po['taxing'];
?>
	<script src='../universal/Numeral-js-master/numeral.js'></script>
	<style>
		#button_close{
			position:absolute;
			top:0px;
			left:0;
			color:#333;
			border:none;
			ouline:none;
			background-color:transparent;
		}
	</style>
	<button id='button_close'>X</button>
	<script>
		$('#button_close').click(function(){
			$('#view_pending_bills_wrapper').fadeOut();
		})
	</script>
	<h2 style='font-family:bebasneue'><?= $document_name ?></h2>
	<p><?= $po_name ?></p>
	<hr>
<?php
	if($taxing		== 1){
?>
	<button type='button' class='button_success_dark' id='include_tax_button'>Included tax</button>
	<button type='button' class='button_danger_dark' id='exclude_tax_button' style='display:none'>Excluded tax</button>
	<br><br>
	<script>
		$('#include_tax_button').click(function(){
			$('#include_tax_button').hide();
			$('#exclude_tax_button').show();
			$('input[id^="input_net_price-"]').each(function(){
				var input_id		= $(this).attr('id');
				var uid				= input_id.substring(16,20);
				var input_value		= $('#input_net_price-' + uid).val();
				var quantity		= $('#input_quantity-' + uid).val();
				
				$('#net_price-' + uid).html('Rp. ' + numeral(input_value * 10 / 11).format('0,0.00'));
				$('#total_price-' + uid).html('Rp. ' + numeral(input_value * 10 * quantity / 11).format('0,0.00'));
			});
			
			$('#include_foot').hide();
			$('#exclude_foot').show();
		});
		
		$('#exclude_tax_button').click(function(){
			$('#exclude_tax_button').hide();
			$('#include_tax_button').show();
			$('input[id^="input_net_price-"]').each(function(){
				var input_id		= $(this).attr('id');
				var uid				= input_id.substring(16,20);
				var input_value		= $('#input_net_price-' + uid).val();
				var quantity		= $('#input_quantity-' + uid).val();
				
				$('#net_price-' + uid).html('Rp. ' + numeral(input_value).format('0,0.00'));
				$('#total_price-' + uid).html('Rp. ' + numeral(input_value * quantity).format('0,0.00'));
			});
			
			$('#exclude_foot').hide();
			$('#include_foot').show();
		});
	</script>
<?php
	}
?>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Unit price</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
<?php
	$i						= 0;
	$total_receipt			= 0;
	$sql_gr					= "SELECT purchaseorder.reference, purchaseorder.unitprice, goodreceipt.quantity FROM goodreceipt 
							JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
							WHERE gr_id = '$id'";
	$result_gr				= $conn->query($sql_gr);
	while($gr				= $result_gr->fetch_assoc()){
		$reference			= $gr['reference'];
		$quantity			= $gr['quantity'];
		$unit_price			= $gr['unitprice'];
		$total_price		= $unit_price * $quantity;
			
		$total_receipt		+= $total_price;
			
		$sql_item			= "SELECT description FROM itemlist	WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item		= $conn->query($sql_item);
		$item				= $result_item->fetch_assoc();
		
		$item_description	= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $item_description ?></td>
				<td id='quantity-<?= $i ?>'>
					<?= number_format($quantity,0) ?>
				</td>
				<input type='hidden' value='<?= $quantity ?>' id='input_quantity-<?= $i ?>'>
				<td id='net_price-<?= $i ?>'>
					Rp. <?= number_format($unit_price,2) ?>
				</td>
				<input type='hidden' value='<?= $unit_price ?>' id='input_net_price-<?= $i ?>'>
				<td id='total_price-<?= $i ?>'>Rp. <?= number_format($total_price,2) ?></td>
			</tr>
<?php
		$i++;
	}
?>
		</tbody>
		<tfoot id='include_foot'>
			<tr>
				<td colspan='3'></td>
				<td>Total</td>
				<td>Rp. <?= number_format($total_receipt,2) ?></td>
			</tr>
		</tfoot>
<?php
	if($taxing		== 1){
?>
		<tfoot id='exclude_foot' style='display:none'>
			<tr>
				<td colspan='3'></td>
				<td>Sub total</td>
				<td>Rp. <?= number_format($total_receipt * 10 / 11,2) ?></td>
			</tr>
			<tr>
				<td colspan='3'></td>
				<td>Tax</td>
				<td>Rp. <?= number_format($total_receipt - $total_receipt * 10 / 11,2) ?></td>
			</tr>
			<tr>
				<td colspan='3'></td>
				<td>Total</td>
				<td>Rp. <?= number_format($total_receipt,2) ?></td>
			</tr>
		</tfoot>
<?php
	}
?>
	</table>
	<button type='button' class='button_default_dark' onclick='change_slide(<?= $prev_view ?>)'>Previous</button>
	<button type='button' class='button_success_dark' onclick='change_slide(<?= $next_view ?>)'>Next</button>
	