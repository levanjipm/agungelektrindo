<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Inventory Department</title>
</head>
<style>
.box{
	padding:10px;
	background-color:#024769;
	-moz-box-shadow:inset 0 0 5px #01141e;
	-webkit-box-shadow: inset 0 0 5px #01141e;
	box-shadow:inset 0 0 5px #01141e;
	color:white;
	text-align:center;
	cursor:pointer;
}

.bar_wrapper{
	position:relative;
	background-color:#fff;
	width:100%;
	height:5px;
}

.bar{
	position:absolute;
	top:0;
	height:100%;
	background-color:#aaa;
	transition:0.5s all ease;
}
</style>
<div class='main'>
	<div class='row'>
		<div class='col-sm-3 col-xs-4' style='padding:20px;padding-top:0'>
			<a href='/agungelektrindo/inventory_department/purchase_order_incomplete_dashboard' style='text-decoration:none;color:#333;'>
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
						echo ('<h3>Pending PO</h3>');
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
			<a href='#' style='text-decoration:none;color:#333;'>
				<div class='row'>
					<div class='col-sm-12 box' id='on_delivery_button'>
					<?php
						$sql_calendar = "SELECT COUNT(*) AS delivery FROM code_delivery_order WHERE date = '" . date('Y-m-d') . "' AND sent = '0'";
						$result_calendar = $conn->query($sql_calendar);
						$row = $result_calendar->fetch_assoc();
					
						if($row['delivery'] > 20){
							$bar_width = 20;
						} else {
							$bar_width = $row['delivery'];
						}
						
						echo ('<h1>' . $row['delivery'] . '</h1>');
						echo ('<h3>Delivery on process</h3>');
					?>
						<div class='bar_wrapper'>
							<div class='bar' id='delivery_bar'></div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<script>
			$(document).ready(function(){
				$('#delivery_bar').animate({
					width: "<?= max(30, (5 * $bar_width)) ?>%"
				},300)
			})
		</script>
		<div class='col-sm-3 col-xs-4' style='padding:20px;padding-top:0'>
			<div class='row'>
				<div class='col-sm-12 box' id='pending_sales_order_button'>
				<?php
					$sql_pending_so 	= "SELECT COUNT(DISTINCT(so_id)) AS jumlah_so FROM sales_order WHERE status = '0'";
					$result_pending_so 	= $conn->query($sql_pending_so);
					$row_pending_so 	= $result_pending_so->fetch_assoc();					
					if($row_pending_so['jumlah_so'] > 50){
						$bar_width = 50;
					} else {
						$bar_width = $row_pending_so['jumlah_so'];
					}
					
					echo ('<h1>' . $row_pending_so['jumlah_so'] . '</h1>');
					echo ('<h3>Pending Sales Order</h3>');
				?>
					<div class='bar_wrapper'>
						<div class='bar' id='pending_so_bar'></div>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				$('#pending_so_bar').animate({
					width: "<?= max(30, (2 * $bar_width)) ?>%"
				},300)
			})
		</script>
	</div>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	$('#pending_sales_order_button').click(function(){
		$.ajax({
			url:'pending_sales_order.php',
			type: 'POST',
			success:function(response){
				$('#view_inventory_view').html(response);
			}
		});
		$('.view_wrapper').fadeIn(200);
	});
	
	$('#on_delivery_button').click(function(){
		$.ajax({
			url:'delivery_order_sending.php',
			type: 'POST',
			success:function(response){
				$('#view_inventory_view').html(response);
			}
		});
		$('.view_wrapper').fadeIn(200);
	});
	
	$('#button_close_view').click(function(){
		$('.view_wrapper').fadeOut(200);
	});
	
	function view_sales_order_detail(n){
		$.ajax({
			url:'pending_sales_order_detail.php',
			type: 'POST',
			data:{ sales_order_id: n },
			success:function(response){
				$('#view_inventory_view').fadeOut(200);
				setTimeout(function(){
					$('#view_inventory_view').html(response);
				},250);
				setTimeout(function(){
					$('#view_inventory_view').fadeIn(300);
				},300);
			}
		});
	}
	
	function view_pending_sales_order(){
		$.ajax({
			url:'pending_sales_order.php',
			type: 'POST',
			success:function(response){
				$('#view_inventory_view').fadeOut(200);
				setTimeout(function(){
					$('#view_inventory_view').html(response);
				},250);
				setTimeout(function(){
					$('#view_inventory_view').fadeIn(300);
				},300);
			}
		});
	};
</script>