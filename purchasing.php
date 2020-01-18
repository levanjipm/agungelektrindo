<head>
	<title>Purchasing Department</title>
</head>
<?php
	include('header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
?>
<head>
	<script src='/agungelektrindo/universal/chartist/dist/chartist.min.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/chartist/dist/chartist.min.css'>
</head>
<style>
	.ct-label {
		font-size: 10px;
		font-family:museo;
		color:#222;
	}
	
	#purchase_chart_line .ct-chart{
		height:300px;
	}
	
	#purchase_chart_pie .ct-chart{
		height:250px;
	}
	
	.box{
		padding:10px;
		background-color:#fff;
		color:#024769;
		border:3px solid #024769;
		text-align:center;
		cursor:pointer;
		width:25%;
		display:inline-block;
		margin-left:2%;
	}

	.box:hover{
		background-color:#eee;
		color:#333;
		transition:0.3s all ease;
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
		<div class='col-md-12 col-sm-12 col-xs-12'>
			<a href='/agungelektrindo/purchasing_department/purchase_order_incomplete_dashboard' style='text-decoration:none;color:#333;'>
				<div class='box'>
					<?php
						$sql_pending_po = "SELECT COUNT(DISTINCT(purchaseorder_id)) AS incomplete_po FROM purchaseorder WHERE status = '0'";
						$result_pending_po = $conn->query($sql_pending_po);
						$row_pending_po = $result_pending_po->fetch_assoc();
						
						if($row_pending_po['incomplete_po'] > 50){
							$bar_width_pending = 50;
						} else {
							$bar_width_pending = $row_pending_po['incomplete_po'];
						}
						
						echo ('<h1>' . $row_pending_po['incomplete_po'] . '</h1>');
						echo ('<h5>Pending Purchase Order</h5>');
					?>
					<div class='bar_wrapper'>
						<div class='bar' id='pending_purchaseorder_bar'></div>
					</div>
				</div>
			</a>
			<div class='box' id='sales_order_view_button'>
<?php
				$point = 0;
				$sql_pending_so 		= "SELECT reference, quantity, sent_quantity
											FROM sales_order 
											WHERE status = '0'";
				$result_pending_so 		= $conn->query($sql_pending_so);
				while($pending_so 		= $result_pending_so->fetch_assoc()){
					$reference	 		= $pending_so['reference'];
					$quantity			= $pending_so['quantity'];
					$quantity_sent 		= $pending_so['sent_quantity'];
					$pending_so			= $quantity - $quantity_sent;
					
					$sql_po	 			= "SELECT quantity, received_quantity FROM purchaseorder WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND status = '0'";
					$result_po 			= $conn->query($sql_po);
					$row_po 			= $result_po->fetch_assoc();
					
					$quantity_ordered	= $row_po['quantity'];
					$quantity_received	= $row_po['received_quantity'];
					
					$pending_purchase_order	= $quantity_ordered - $quantity_received;
					
					$sql_stock 			= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY ID DESC LIMIT 1";
					$result_stock 		= $conn->query($sql_stock);
					$row_stock 			= $result_stock->fetch_assoc();

					$stock 				= $row_stock['stock'];
					
					if($pending_so > $pending_purchase_order + $stock){
						$point++;
					}
					
					
					if($point > 100){
						$bar_width = 50;
					} else {
						$bar_width = $point;
					}
				}
				echo ('<h1>' . $point . '</h1>');
				echo ('<h5>Items need to be bought</h5>');
?>			
				<div class='bar_wrapper'>
					<div class='bar' id='pending_sales_order_bar'></div>
				</div>
			</div>
			<div class='box' id='sales_order_view_button'>
<?php
				$sql				= "SELECT id FROM supplier";
				$result				= $conn->query($sql);
				$supplier_count		= mysqli_num_rows($result);
				$active_supplier	= 0;
				
				while($row			= $result->fetch_assoc()){
					$supplier_id	= $row['id'];
					$sql_last		= "SELECT MAX(date) AS date FROM purchases WHERE supplier_id = '$supplier_id'";
					$result_last	= $conn->query($sql_last);
					$last			= $result_last->fetch_assoc();
					
					$date_1			= $last['date'];
					
					$sql_last		= "SELECT MAX(date) AS date FROM code_purchaseorder WHERE supplier_id = '$supplier_id'";
					$result_last	= $conn->query($sql_last);
					$last			= $result_last->fetch_assoc();
					
					$date_2			= $last['date'];
					
					$last_transaction	= max($date_1, $date_2);
					
					if($last_transaction >= date('Y-m-d',strtotime('-3month'))){
						$active_supplier++;
					}
				}
				echo ('<h1>' . $active_supplier . ' / ' . $supplier_count . '</h1>');
				echo ('<h5>Active supplier</h5>');
?>			
				<div class='bar_wrapper'>
					<div class='bar' id='supplier_bar'></div>
				</div>
			</div>
			<script>
				$(document).ready(function(){
					$('#pending_purchaseorder_bar').animate({
						width: "<?= max(40, (2 * $bar_width)) ?>%"
					},300)
				})
				
				$(document).ready(function(){
					$('#supplier_bar').animate({
						width: "<?= max(10, ($active_supplier / $supplier_count)) ?>%"
					},300)
				})
				
				$(document).ready(function(){
					$('#pending_purchaseorder_bar').animate({
						width: "<?= max(0, ($bar_width_pending * 2)) ?>%"
					},300)
				})
			</script>
			<br><br><br>
			<div id='purchase_chart_line'></div>
		</div>
	</div>
	<script>
		$.ajax({
			url:'/agungelektrindo/purchasing_department/purchasing_chart_line.php',
			success:function(response){
				$('#purchase_chart_line').html(response);
			}
		});
	</script>
</div>
<div class='full_screen_wrapper' id='sales_order_pending_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#pending_sales_order_bar').animate({
			width: "<?= max(20, ($bar_width)) ?>%"
		},300)
	})
	$('#sales_order_view_button').click(function(){
		$.ajax({
			url:'/agungelektrindo/purchasing_department/sales_order_pending_view.php',
			success:function(response){
				$('.full_screen_box').html(response);
				$('#sales_order_pending_wrapper').fadeIn();
			}
		});
	});
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
</script>