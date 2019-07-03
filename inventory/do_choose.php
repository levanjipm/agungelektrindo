<?php
	include("inventoryheader.php")
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script> 
$( function() {
	$('#so_id').autocomplete({
		source: "Ajax/search_so.php"
	 })
});
</script>
<style>
.box_do{
	padding:100px 30px;
	box-shadow: 3px 3px 3px 3px #888888;
}
.icon_wrapper{
	position:relative;
}
.view_wrapper{
	position:fixed;
	top:30px;
	right:0px;
	margin-left:0;
	width:30%;
	background-color:#eee;
	padding:20px;
}
</style>
	<div class="main">
		<h2 style='font-family:bebasneue'>Delivery Order</h2>
		<p>Choose a confirmed sales order</p>
		<hr>
		<div class='row'>
			<div class='col-sm-7'>
				<h3 style='font-family:bebasneue'>Available to send</h3>
				<div class='row'>
<?php
	$sql = "SELECT id,name,customer_id,po_number FROM code_salesorder WHERE isconfirm = '1'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$nilai = 1;
		$sql_detail = "SELECT sales_order.reference
		FROM sales_order JOIN sales_order_sent 
		ON sales_order.id = sales_order_sent.id
		WHERE sales_order.so_id = '" . $row['id'] . "' AND sales_order_sent.status = '0'";
		$result_detail = $conn->query($sql_detail);
		while($detail = $result_detail->fetch_assoc()){
			$sql_stock = "SELECT stock FROM stock WHERE reference = '" . $detail['reference'] . "' ORDER BY id DESC LIMIT 1";
			$result_stock = $conn->query($sql_stock);
			$stock = $result_stock->fetch_assoc();
			if($stock['stock'] != 0 || $stock['stock'] == NULL){
				$nilai++;
			}
		}
		if($nilai > 1){			
?>
					<div class='col-sm-4' style='margin-top:30px;text-align:center'>
						<div class='box' style='background-color:#eee;width:90%;text-align:center;padding:10px'>
							<h3 style='font-family:bebasneue'><?= $row['name'] ?></h3>
							<p><?php
								$sql_customer = "SELECT name FROM customer WHERE id = '" . $row['customer_id'] . "'";
								$result_customer = $conn->query($sql_customer);
								$customer = $result_customer->fetch_assoc();
								echo $customer['name'];
							?></p>
							<p><?= $row['po_number'] ?></p>
							<button type='button' class='btn btn-default' onclick='view(<?= $row['id'] ?>)'>View</button>
							<button type='button' class='btn btn-success' onclick='send(<?= $row['id'] ?>)'>Send</button>
						</div>
					</div>
<?php
		}
	}
?>
				</div>
				<hr>
				<h3 style='font-family:bebasneue'>Incomplete sales orders</h3>
				<div class='row'>
<?php
	$sql = "SELECT DISTINCT(sales_order_sent.so_id), code_salesorder.id, code_salesorder.name,code_salesorder.customer_id,code_salesorder.po_number 
	FROM code_salesorder 
	JOIN sales_order_sent ON sales_order_sent.so_id = code_salesorder.id
	WHERE code_salesorder.isconfirm = '1' AND sales_order_sent.status = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
					<div class='col-sm-4' style='margin-top:30px;text-align:center'>
						<div class='box' style='background-color:#eee;width:100%;text-align:center;padding:10px'>
							<h3 style='font-family:bebasneue'><?= $row['name'] ?></h3>
							<p><?php
								$sql_customer = "SELECT name FROM customer WHERE id = '" . $row['customer_id'] . "'";
								$result_customer = $conn->query($sql_customer);
								$customer = $result_customer->fetch_assoc();
								echo $customer['name'];
							?></p>
							<p><?= $row['po_number'] ?></p>
							<button type='button' class='btn btn-default' onclick='view(<?= $row['id'] ?>)'>View</button>
							<button type='button' class='btn btn-secondary' onclick='send(<?= $row['id'] ?>)'>Send</button>
						</div>
					</div>
					<form action='do_exist_dashboard.php' method='POST' id='so_form<?= $row['id'] ?>'>
						<input type='hidden' value='<?= $row['id'] ?>' name='id'>
					</form>
<?php
		}
?>
				</div>
			</div>
		</div>
		<div class='view_wrapper'>
			<div id='view_so'>
			</div>
		</div>
	</div>
</body>
<script>
	function view(n){
		$.ajax({
			url:'view_so.php',
			data:{
				id: n,
			},
			success:function(response){
				$('#view_so').html(response);
			},
			type:'POST',
		})
	}
	function send(n){
		$('#so_form' + n).submit();
	}
</script>