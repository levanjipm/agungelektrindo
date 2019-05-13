<?php
	include('salesheader.php');
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script type="text/javascript" src="scripts/createquotation.js"></script>
<script>
$( function() {
	$('#customer').autocomplete({
		source: "search_customer.php"
	 })
});
</script>
<?php
//Get the quotation ID of copied quotation//
$id = $_POST['id'];
$customer = $_POST['customer'];
$sql_customer = "SELECT id FROM customer WHERE name = '" . $customer . "' LIMIT 1";
$result_customer = $conn->query($sql_customer) or die($conn->error);
if(mysqli_num_rows($result_customer) != 1 ){
	echo ('euweuh');
	//header('location:sales.php');
} else {
	while($rows = $result_customer->fetch_assoc()) { 
		$customer_id = $rows['id'];
	}
}
$sql_count = "SELECT COUNT(*) AS number FROM code_quotation WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())";
$result_count = $conn->query($sql_count);
while($row_count = $result_count->fetch_assoc()){
	$count = $row_count['number'];
}
if($count == 0){
	$number = 1;
} else {
	$number = $count + 1;
}
if (date('m') == '01'){
	$month = 'I';
} else if(date('m') == '02'){
	$month = 'II';
} else if(date('m') == '03'){
	$month = 'III';
} else if(date('m') == '04'){
	$month = 'IV';
} else if(date('m') == '05'){
	$month = 'V';
} else if(date('m') == '06'){
	$month = 'VI';
} else if(date('m') == '07'){
	$month = 'VII';
} else if(date('m') == '08'){
	$month = 'VIII';
} else if(date('m') == '09'){
	$month = 'IX';
} else if (date('m') == '10'){
	$month = 'X';
} else if(date('m') == '11'){
	$month = 'XI';
} else {
	$month = 'XII';
}
$qname = "Q-AE-" . $number . '.' . date('d') . '-' . $month . '-' . date('y');
?>
<div class='main'>
	<div class='container' style='text-align:center'>
		<h2><?= $customer ?></h2>
		<h4><?= $qname ?></h4>
	</div>
	<a href="#" id="folder" title="Add new item"><i class="fa fa-folder"></i></a>
	<a href="#" id="close" title="Delete last item"><i class="fa fa-close"></i></a>
	<div class="container">
		<form name="quotation_copy" id="quotation_copy" method="POST" action="copy_quotation_input.php">
			<input type='hidden' value='<?= $customer_id ?>' name='customer_id'>
			<input type='hidden' value='<?= $qname ?>' name='qname'>
			<div class="row" id="headerlist" style="border-radius:10px;padding-top:25px">
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
		$sql = "SELECT * FROM quotation WHERE quotation_code = '" . $id . "'";
		$result = $conn->query($sql);
		$a = 1;
		while($row = $result->fetch_assoc()){	
		?>	
			<div class="row" id="barisan<?= $a ?>" style="padding-top:10px;">
				<div class="col-lg-2">
					<input id="reference<?=$a?>" class="form-control" name="reference<?=$a?>" style="width:100%" value="<?= $row['reference']?>">
				</div>
				<div class="col-lg-2">
					<input style="overflow-x:hidden" id="price<?=$a?>" name="price<?=$a?>" class="form-control" style="width:100%" value="<?= $row['price_list']?>">
				</div>
				<div class="col-lg-1">
					<input id="discount<?=$a?>" class="form-control" style="width:100%" name="discount<?=$a?>" value="<?= $row['discount']?>">
				</div>
				<div class="col-lg-1">
					<input id="quantity<?=$a?>" class="form-control" style="width:100%" name="quantity<?=$a?>" value="<?= $row['quantity']?>">
				</div>
				<div class="col-lg-2">
					<input class="nomor" id="unitprice<?=$a?>" name="unitprice<?=$a?>" readonly value="<?= $row['net_price']?>"></input>
				</div>
				<div class="col-lg-2">
					<input class="nomor" id="totalprice<?=$a?>" name="totalprice<?=$a?>" readonly value="<?= $row['total_price']?>"></input>
				</div>
				<div class="col-lg-1">
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
				<div class="col-lg-2 offset-lg-7">
					<label for="total">Total</label>
				</div>
				<div class="col-lg-2">
					<input class="nomor" id="total" name="total" readonly>
				</div>
			</div>
			<div class="row" style="padding-top:20px">
				<div class="col-lg-2">
					<input type="hidden" class="form-control" id="jumlah_barang" name="jumlah_barang"></input>
				</div>	
			</div>
			<div class="container" style="background-color:#eee">
				<div class="row" style="padding:20px">
					<h3><b>Note</b></h3>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<p><b>1. Payment term</b></p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<select id="terms" name="terms" class="form-control" style="width:100%" onchange="payment_js()">
							<option value='0'>Insert payment terms</option>
						<?php
							include("connect.php");
							$sql_payment = "SELECT * FROM payment";
							$result = $conn->query($sql_payment);
							if ($result->num_rows > 0) {
								while($rows = mysqli_fetch_array($result)) {
									if($rows['id'] == $terms){
										echo '<option selected = "selected" value="' . $rows["id"] . '">'. $rows["payment_term"].'</option> ';
									} else{
									echo '<option value="' . $rows["id"] . '">'. $rows["payment_term"].'</option> ';
									}
								}
							} else {
								echo "0 results";
							}
						?>
						</select>
					</div>
				</div>
				<div class="row" style="padding:5px">
					<div class="col-lg-6" style="padding:5px">
						<div class="col-lg-6" style="padding:5px">
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" id="dp" name="dp" maxlength='2'>
									<span class="input-group-addon" style="font-size:12px">%</span>
								</div>
							</div>
						</div>
						<div class="col-lg-6" style="padding:5px">
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" id="lunas" name="lunas" readonly maxlength='2'>
									<span class="input-group-addon" style="font-size:12px">days</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<p><b>2. </b>Prices and availability are subject to change at any time without prior notice.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<p><b>3. </b>Prices mentioned above are tax-included.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<textarea class="form-control" name="comment" rows="10" form="quotation_copy"></textarea>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-2">
					<button type="button" class="btn btn-primary" onclick="hitung()" id="calculate">Calculate</button>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-2">
					<button type="submit" id="submitbtn" class="btn btn-success" style="display:none">Submit</button>
				</div>
				<div class="col-lg-2">
					<button type="button" id="back" class="btn btn-primary" style="display:none">Back</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
var a = "<?= $a ?>";
function delete_row(x_men){
	x = 'barisan' + x_men;
	$("#"+x).remove();
};
$("#folder").click(function (){	

	$("#input_list").append(
	'<div class="row" style="padding-top:10px" id="barisan'+a+'">'+
	'<div class="col-lg-2"><input id="reference'+a+'" name="reference'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-lg-2"><input style="overflow-x:hidden" id="price'+a+'" name="price'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-lg-1">'+'<input id="discount'+a+'" name="discount'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-lg-1">'+'<input id="quantity'+a+'" name="quantity'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-lg-2">'+'<input class="nomor" id="unitprice'+a+'" name="unitprice'+a+'"></input></div>'+
	'<div class="col-lg-2">'+'<input class="nomor" id="totalprice'+a+'" name="totalprice'+a+'" ></input></div>'+
	'<div class="col-lg-1"><button type="button" id="close'+a+'" class="btn btn-danger" onclick="delete_row('+a+')">X</button></div>'+
	'</div>').find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
		source: "search_item.php"
	 });
	a++;
});
</script>
<script type="text/javascript" src="Scripts/copyquotation.js"></script>