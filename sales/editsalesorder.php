<?php
	include('../codes/connect.php');
	
?>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<link rel="stylesheet" href="salesstyle.css">
</head>
<body>
<div class="row">
	<div class="col-lg-6 offset-lg-3">
		<h1 style="text-align:center">Edit Sales Order</h1>
	</div>
</div>
<br><br>
<?php
	$id = $_GET['id'];
	$sql_customer = "SELECT * FROM code_salesorder WHERE id = '" . $id . "'";
	$r = $conn->query($sql_customer);
	while($rows = $r->fetch_assoc()){
		$customer_id = $rows['customer_id'];
		$total = $rows['value'];
		$taxing = $rows['taxing'];
		$delivery = $rows['delivery_id'];
		$po_number = $rows['po_number'];
	}
	$sql_customername = "SELECT * FROM customer WHERE id = '" . $customer_id . "'";
	$res = $conn->query($sql_customername);
	while($rows = $res->fetch_assoc()){
		$customer_name = $rows['name'];
	}
	
?>
<div class="container">
	<form name="salesorder_edit" id="so_edit" class="form" method="POST" action="#">
		<div class="row">
			<div class="col-lg-6">
				<input type="text" class="form-control" readonly value="<?= $customer_name ?>">
			</div>
			<div class="col-lg-2 offset-lg-2">
				<input id="today" type="date" class="form-control" value="<?php echo date('Y-m-d');?>" name="today">
			</div>
		</div>
		<div class="row" id="headerlist" style="border-radius:10px;padding-top:25px">
			<div class="col-lg-1" style="background-color:#aaa">
				Nomor
			</div>
			<div class="col-lg-2" style="background-color:#ccc">
				Refference
			</div>
			<div class="col-lg-2" style="background-color:#aaa">
				Price
			</div>
			<div class="col-lg-1" style="background-color:#ccc">
				Discount
			</div>
			<div class="col-lg-1" style="background-color:#ccc">
				Quantity
			</div>
			<div class="col-lg-2" style="background-color:#aaa">
				Nett Unit Price
			</div>
			<div class="col-lg-2" style="background-color:#ccc">
				Total Price
			</div>
		</div>
<?php
	$sql = "SELECT * FROM sales_order WHERE so_id = '" . $id . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
		<div class="row" style="padding-top:10px;">
			<div class="col-lg-1">
				<input class="nomor" id="no" style="width:40%" value="1" disabled></input>
			</div>
			<div class="col-lg-2">
				<input id="reference<?=$id?>" class="form-control" name="reference<?=$id?>" style="width:100%" value="<?= $row['reference']?>">
			</div>
			<div class="col-lg-2">
				<input style="overflow-x:hidden" id="price<?=$id?>" name="price<?=$id?>" class="form-control" style="width:100%" value="<?= $row['price_list']?>">
			</div>
			<div class="col-lg-1">
				<input id="discount1" name="discount<?=$id?>" class="form-control" style="width:100%" name="discount<?=$id?>" value="<?= $row['discount']?>">
			</div>
			<div class="col-lg-1">
				<input id="quantity1" name="quantity<?=$id?>" class="form-control" style="width:100%" name="quantity<?=$id?>" value="<?= $row['quantity']?>">
			</div>
			<div class="col-lg-2">
				<input class="nomor" id="unitprice<?=$id?>" name="unitprice<?=$id?>" readonly value="<?= $row['price']?>"></input>
			</div>
			<div class="col-lg-2">
				<input class="nomor" id="totalprice<?=$id?>" name="totalprice<?=$id?>" readonly value="<?= $row['total_price']?>"></input>
			</div>
			<div class="col-lg-2">
			</div>
		</div>
<?php
	}
	?>
	</form>
</div>
<script>
function payment_js(){
	var payment_term = $('#terms').val();
	if (payment_term == 1) {
		$('#dp').val(0);
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',true);
	} else if (payment_term == 2) {
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',false);
	} else if (payment_term == 3) {
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',false);
	} else if (payment_term == 4) {
		$('#dp').attr('readonly',false);
		$('#lunas').attr('readonly',false);
	}
}
</script>