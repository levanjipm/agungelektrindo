<?php
	include("salesheader.php");
?>
<div class='main'>
	<div class='row'>
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
function toggle_pending_so(){
	$('#pending_so').fadeIn();
}
</script>
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
					<td><?= $quantity . ' out of ' . $quantity_ordered . ' uncompleted' ?></td>
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
		<h2 style='font-family:bebasneue'>Daily Sales</h2>
	<label>End date</label>
	<input type='date' class='form-control' style='width:30%' onchange='update_date()' id='end_date'>
	<hr>
	<div id='chart'>
	</div>
<script>
	$(document).ready(function(){
		$.ajax({
			url:'sales_chart.php',
			data:{
				date:"<?= date('Y-m-d')?>"
			},
			type:'POST',
			success:function(response){
				$('#chart').html(response);
			},
		})
	});
	function update_date(){
		$.ajax({
			url:'sales_chart.php',
			data:{
				date:$('#end_date').val()
			},
			type:'POST',
			success:function(response){
				$('#chart').html(response);
			},
		})
	};
</script>
</div>
<script>
	function showdetailso(n){
		$('#more_detail_so' + n).hide();
		$('#less_detail_so' + n).show();
		$('#so' + n).show();
	}
	function lessdetailso(n){
		$('#more_detail_so' + n).show();
		$('#less_detail_so' + n).hide();
		$('#so' + n).hide();
	}
</script>