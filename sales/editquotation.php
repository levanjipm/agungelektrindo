<?php
	include('salesheader.php');
	if(empty($_POST['id'])){
		header('location:sales.php');
	}
?>
<body>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script type="text/javascript" src="scripts/createsalesorder.js"></script>
<div class='main'>
	<div class="container">
		<h2>Quotataion</h2>
		<p>Edit quotataion</p>
		<hr>
	</div>
<br><br>
<?php
	$id = $_POST['id'];
	$sql_customer = "SELECT * FROM code_quotation WHERE id = '" . $id . "'";
	$r = $conn->query($sql_customer);
	while($rows = $r->fetch_assoc()){
		$date = $rows['date'];
		$customer_id = $rows['customer_id'];
		$total = $rows['value'];
		$terms = $rows['payment_id'];
		$dp = $rows['down_payment'];
		$lunas = $rows['repayment'];
		$note = $rows['note'];
	}
	$sql_customername = "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
	$result_customername = $conn->query($sql_customername);
	$customer_naming = $result_customername->fetch_assoc();
	$customer_name = $customer_naming['name'];	
?>
<a href="#" id="folder" title="Add new item"><i class="fa fa-folder"></i></a>
<div class="container">
	<form name="quotation" id="quotation_edit" class="form" method="POST" action="quotation_edit_input.php">
		<input type="hidden" value="<?= $id ?>" name="id">
		<div class="row">
			<div class="col-sm-6">
				<label>Customer name</label>
				<input type="text" class="form-control" readonly value="<?= $customer_name ?>">
			</div>
			<div class="col-sm-2 offset-lg-2">
				<input id="today" type="date" class="form-control" value="<?= $date ?>" name="today" readonly>
			</div>
		</div>
		<div class="row" id="headerlist" style="border-radius:10px;padding-top:25px">
			<div class="col-sm-2" style="background-color:#ccc">
				Refference
			</div>
			<div class="col-sm-2" style="background-color:#aaa">
				Price
			</div>
			<div class="col-sm-1" style="background-color:#ccc">
				Discount
			</div>
			<div class="col-sm-1" style="background-color:#ccc">
				Quantity
			</div>
			<div class="col-sm-2" style="background-color:#aaa">
				Nett Unit Price
			</div>
			<div class="col-sm-2" style="background-color:#ccc">
				Total Price
			</div>
		</div>
<?php
	$sql = "SELECT * FROM quotation WHERE quotation_code = '" . $id . "'";
	$result = $conn->query($sql);
	$a = 1;
	while($row = $result->fetch_assoc()){
	
	?>	
		<div class="row" id="barisan<?= $a ?>" style="padding-top:10px;">
			<div class="col-sm-2">
				<input id="reference<?=$a?>" class="form-control" name="reference<?=$a?>" style="width:100%" value="<?= $row['reference']?>">
			</div>
			<div class="col-sm-2">
				<input style="overflow-x:hidden" id="price<?=$a?>" name="price<?=$a?>" class="form-control" style="width:100%" value="<?= $row['price_list']?>">
			</div>
			<div class="col-sm-1">
				<input id="discount<?=$a?>" class="form-control" style="width:100%" name="discount<?=$a?>" value="<?= $row['discount']?>">
			</div>
			<div class="col-sm-1">
				<input id="quantity<?=$a?>" class="form-control" style="width:100%" name="quantity<?=$a?>" value="<?= $row['quantity']?>">
			</div>
			<div class="col-sm-2">
				<input class="nomor" id="unitprice<?=$a?>" name="unitprice<?=$a?>" readonly value="<?= $row['net_price']?>"></input>
			</div>
			<div class="col-sm-2">
				<input class="nomor" id="totalprice<?=$a?>" name="totalprice<?=$a?>" readonly value="<?= $row['total_price']?>"></input>
			</div>
			<div class="col-sm-1">
				<button type="button" id="close<?= $a ?>" onclick="delete_row(<?= $a ?>)" class="btn btn-danger">X</button>
			</div>
		</div>
<?php
	$a++;
	}
	?>
		<div id="input_list">
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-2 offset-lg-7">
				<label for="total">Total</label>
			</div>
			<div class="col-sm-2">
				<input class="nomor" id="total" name="total" readonly value="<?= $total ?>">
			</div>
		</div>
		<div class="row" style="padding-top:20px">
			<div class="col-sm-2">
				<input type="hidden" class="form-control" id="jumlah_barang" name="jumlah_barang"></input>
			</div>	
		</div>
		<div class="container" style="background-color:#eee">
			<div class="row" style="padding:20px">
				<h3><b>Note</b></h3>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<p><b>1. Payment term</b></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<select id="terms" name="terms" class="form-control" style="width:100%" onchange="payment_js()">
					<?php
						$sql_payment = "SELECT * FROM payment";
						$result = $conn->query($sql_payment);
						while($rows = mysqli_fetch_array($result)) {
							if($rows['id'] == $terms){
								echo '<option selected = "selected" value="' . $rows["id"] . '">'. $rows["payment_term"].'</option> ';
							} else{
							echo '<option value="' . $rows["id"] . '">'. $rows["payment_term"].'</option> ';
							}
						}
					?>
					</select>
				</div>
			</div>
			<div class="row" style="padding:5px">
				<div class="col-sm-6" style="padding:5px">
					<div class="col-sm-6" style="padding:5px">
						<div class="form-group">
							<div class="input-group">
								<input class="form-control" id="dp" name="dp" maxlength='2' value="<?= $dp?>">
								<span class="input-group-addon" style="font-size:12px">%</span>
							</div>
						</div>
					</div>
					<div class="col-sm-6" style="padding:5px">
						<div class="form-group">
							<div class="input-group">
								<input class="form-control" id="lunas" name="lunas" maxlength='2' value="<?= $lunas?>">
								<span class="input-group-addon" style="font-size:12px">days</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<p><b>2. </b>Prices and availability are subject to change at any time without prior notice.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<p><b>3. </b>Prices mentioned above are tax-included.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<textarea class="form-control" name="comment" rows="10" form="quotation_edit"><?= $note ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">
				<button type="button" class="btn btn-primary" onclick="hitung()" id="calculate">Calculate</button>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<button type="button" id="submitbtn" class="btn btn-success" style="display:none" onclick='validate()'>Submit</button>
			</div>
			<div class="col-sm-2">
				<button type="button" id="back" class="btn btn-primary" style="display:none">Back</button>
			</div>
		</div>
		<input type='hidden' value='benar' id='danieltri'>
	</form>
</div>
<script>
var a = "<?= $a ?>";
function delete_row(x_men){
	console.log(($('button[id^=close]')).length);
	if(($('button[id^=close]')).length > 1){
		x = 'barisan' + x_men;
		$("#"+x).remove();
	}
};
$("#folder").click(function (){	
	$("#input_list").append(
	'<div class="row" style="padding-top:10px" id="barisan'+a+'">'+
	'<div class="col-sm-2"><input id="reference'+a+'" name="reference'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-sm-2"><input style="overflow-x:hidden" id="price'+a+'" name="price'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-sm-1">'+'<input id="discount'+a+'" name="discount'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-sm-1">'+'<input id="quantity'+a+'" name="quantity'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-sm-2">'+'<input class="nomor" id="unitprice'+a+'" name="unitprice'+a+'"></input></div>'+
	'<div class="col-sm-2">'+'<input class="nomor" id="totalprice'+a+'" name="totalprice'+a+'" ></input></div>'+
	'<div class="col-sm-1"><button type="button" id="close'+a+'" class="btn btn-danger" onclick="delete_row('+a+')">X</button></div>'+
	'</div>').find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
		source: "search_item.php"
	 });
	a++;
});
</script>
<script type="text/javascript" src="Scripts/editquotation.js"></script>