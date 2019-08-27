<?php
	include('salesheader.php');
	print_r($_POST);
?>
<body>
<link rel="stylesheet" href="../jquery-ui.css">
<link rel="stylesheet" href="css/create_quotation.css">
<script src="../jquery-ui.js"></script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Quotataion</h2>
	<p>Edit quotataion</p>
	<hr>
<?php
	$id = $_POST['id'];
	$sql_quotation = "SELECT * FROM code_quotation WHERE id = '" . $id . "'";
	$result_quotation = $conn->query($sql_quotation);
	$quotation = $result_quotation->fetch_assoc();
	
	$quotation_name = $quotation['name'];
	$date 			= $quotation['date'];
	$customer_id 	= $quotation['customer_id'];
	$terms			= $quotation['payment_id'];
	$dp 			= $quotation['down_payment'];
	$lunas			= $quotation['repayment'];
	$note 			= $quotation['note'];
	
	$sql_customername = "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
	$result_customername = $conn->query($sql_customername);
	$customer_naming = $result_customername->fetch_assoc();
	$customer_name = $customer_naming['name'];	
?>
	<form name="quotation" id="quotation_edit" class="form" method="POST" action="quotation_edit_input.php">
		<input type="hidden" value="<?= $id ?>" name="id">
		<div class="row">
			<div class="col-sm-6">
				<h2 style='font-family:bebasneue'><?= $customer_name ?></h2>
				<h2 style='font-family:bebasneue'><?= $quotation_name ?></h2><p><?= date('d M Y',strtotime($date)) ?></p>
			</div>
		</div>
		<br>
		<h4 style='font-family:bebasneue;display:inline-block;margin-right:10px'>Detail </h4>
		<button type='button' class='button_add_row' id='add_item_button' style='display:inline-block'>Add item</button>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Price</th>
				<th>Discount</th>
				<th>Quantity</th>
				<th>Net price</th>
				<th>Total price</th>
			</tr>
			<tbody id='detail_quotation'>
<?php
	$sql = "SELECT * FROM quotation WHERE quotation_code = '" . $id . "'";
	$result = $conn->query($sql);
	$a = 1;
	while($row = $result->fetch_assoc()){
?>	
				<tr id='tr-<?= $a ?>'>
					<td><input id='reference<?= $a ?>' class='form-control' name='reference[<?=$a?>]' style='width:100%' value='<?= $row['reference']?>'></td>
					<td><input style='overflow-x:hidden' id='price<?=$a?>' name='price[<?=$a?>]' class='form-control' style='width:100%' value='<?= $row['price_list']?>'></td>
					<td><input id='discount<?=$a?>' class='form-control' name='discount[<?=$a?>]' value='<?= $row['discount']?>'></td>
					<td><input id='quantity<?=$a?>' class='form-control' name='quantity[<?=$a?>]' value='<?= $row['quantity']?>'></td>
					<td><input class='nomor' id='unitprice<?=$a?>' readonly value='<?= $row['net_price']?>'></td>
					<td><input class='nomor' id='totalprice<?=$a?>' readonly value='<?= $row['net_price'] * $row['quantity']?>'></input></td>
					<td><button class='button_delete_row' type='button' id='close<?= $a ?>' onclick='delete_row(<?= $a ?>)'>X</button></td>
				</tr>
<?php
		$a++;
	}
?>
			</tbody>
		</table>
		<div id="input_list">
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-2 offset-lg-7">
				<label for="total">Total</label>
			</div>
			<div class="col-sm-2">
				<input class="nomor" id="total" name="total" readonly>
			</div>
		</div>
		<div class="row" style="padding-top:20px">
			<div class="col-sm-2">
				<input type="hidden" class="form-control" id="jumlah_barang" name="jumlah_barang"></input>
			</div>	
		</div>
		<div style="padding:20px;background-color:#eee">
			<div class='row'>
				<div class='col-sm-6'>
					<h3 style='font-family:bebasneue'>Note</h3>
					<p><b>1. Payment term</b></p>
				</div>
				<hr>
			</div>
			<div class='row'>
				<div class='col-sm-6'>
					<select id="terms" name="terms" class="form-control" onchange="payment_js()">
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
			<div class='row'>
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
			<div class='row'>
				<div class='col-sm-12'>
					<p><b>2. </b>Prices and availability are subject to change at any time without prior notice.</p>
					<p><b>3. </b>Prices mentioned above are tax-included.</p>
					<textarea class="form-control" name="comment" rows="10" form="quotation_edit"><?= $note ?></textarea>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">
				<button type="button" class="button_add_row" onclick="hitung()" id="calculate">Calculate</button>
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
$("#add_item_button").click(function (){	
	$("#detail_quotation").append(
		"<tr id='tr-" + a + "'>"+
		"<td><input id='reference<?= $a ?>' class='form-control' name='reference[<?=$a?>]' style='width:100%' value='<?= $row['reference']?>'></td>"+
		"<td><input style='overflow-x:hidden' id='price<?=$a?>' name='price[<?=$a?>]' class='form-control' style='width:100%' value='<?= $row['price_list']?>'></td>"+
		"<td><input id='discount<?=$a?>' class='form-control' name='discount[<?=$a?>]' value='<?= $row['discount']?>'></td>"+
		"<td><input id='quantity<?=$a?>' class='form-control' name='quantity[<?=$a?>]' value='<?= $row['quantity']?>'></td>"+
		"<td><input class='nomor' id='unitprice<?=$a?>' readonly value='<?= $row['net_price']?>'></td>"+
		"<td><input class='nomor' id='totalprice<?=$a?>' readonly value='<?= $row['net_price'] * $row['quantity']?>'></input></td>"+
		"<td><button class='button_delete_row' type='button' id='close<?= $a ?>' onclick='delete_row(<?= $a ?>)'>X</button></td>"+
		"</tr>");
		
	$("#reference" + a).autocomplete({
		source: "search_item.php"
	 });
	a++;
});
</script>
<script type="text/javascript" src="Scripts/editquotation.js"></script>