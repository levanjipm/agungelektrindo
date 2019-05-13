<?php
	include("salesheader.php");
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "ajax/search_item.php"
	 })
});
</script>
<a href="#" id="folder"><i class="fa fa-folder"></i></a>
<a href="#" id="close"><i class="fa fa-close"></i></a>
<div class="main" style='padding-top:0;height:100%'>
	<div class='row' style='height:100%'>
		<div class='col-sm-1' style='background-color:#ddd'>
		</div>
		<div class='col-sm-10' style='padding:30px'>
			<h2>Sales Order</h2>
			<p>Create sales order</h2>
			<hr>
			<form name="salesorder" class="form" method="POST" id="sales_order" action="createsalesorder_validation.php">
				<div class="row">
					<div class="col-lg-6">
						<label for="name">Customer</label>
						<select class="forming" id="select_customer" name="select_customer"  onclick="disable_two()" onchange='show_retail()'>
						<option id="customer_one" value="">Please select a customer--</option>
						<option value='0'>Retail</option>
							<?php
								$sql = "SELECT id,name FROM customer";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
									while($row = mysqli_fetch_array($result)) {
									echo '<option id="pilih" value="' . $row["id"] . '">'. $row["name"].'</option> ';
									}
								} else {
									echo "0 results";
								}
							?>
						</select>
						<script>
							function show_retail(){
								if($('#select_customer').val() == 0){
									$('#retails').fadeIn();
								} else {
									$('#retails').fadeOut();
								}
							}
						</script>
					</div>
					<div class="col-lg-2 offset-lg-2">
						<label for="date">Date</label>
						<input id="today" name="today" type="date" class="forming" value="<?php echo date('Y-m-d');?>">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<label for="purchaseordernumber">Purchase Order number</label>
						<input type="name" class="forming" id="purchaseordernumber" name="purchaseordernumber">
					</div>
					<div class="col-lg-3 offset-lg-2">
						<label for="taxing">Taxing option</label>
						<select name="taxing" id="taxing" class="forming" onclick="disable()">
							<option id="taxingopt_one" value="">--Please choose taxing option--</option>
							<option value="1">Tax</option>
							<option value="0">Non-Tax</option>
						</select>
					</div>
				</div>
				<div class="row" id="headerlist" style="border-radius:10px;padding-top:25px">
					<div class="col-lg-1" style="background-color:#aaa">
						Nomor
					</div>
					<div class="col-lg-2" style="background-color:#ccc">
						Refference
					</div>
					<div class="col-lg-1" style="background-color:#aaa">
						Quantity
					</div>
					<div class="col-lg-2" style="background-color:#ccc">
						Price after tax
					</div>
					<div class="col-lg-2" style="background-color:#aaa">
						Price list
					</div>
					<div class="col-lg-1" style="background-color:#ccc">
						Discount
					</div>
					<div class="col-lg-2" style="background-color:#aaa">
						Total Price
					</div>
				</div>
				<div class="row" style="padding-top:10px;">
					<div class="col-lg-1">
						<input class="nomor" id="no1" style="width:40%" value="1"></input>
					</div>
					<div class="col-lg-2">
						<input id="reference1" class="form-control" name="reference1" style="width:100%">
					</div>
					<div class="col-lg-1">
						<input style="overflow-x:hidden" id="qty1" name="qty1" class="form-control" style="width:100%">
					</div>
					<div class="col-lg-2">
						<input style="overflow-x:hidden" id="vat1" name="vat1" class="form-control" style="width:100%">
					</div>
					<div class="col-lg-2">
						<input style="overflow-x:hidden" id="pl1" name="pl1" class="form-control" style="width:100%">
					</div>
					<div class="col-lg-1">
						<input class="form-control" id="disc1" readonly name="disc1">
					</div>
					<div class="col-lg-2">
						<input style="overflow-x:hidden" id="total1" class="form-control" style="width:100%" readonly name="total1">
					</div>
				</div>
				<div id="input_list">
				</div>
				<br>
				<div class="row">
					<div class="col-lg-2 offset-lg-7">
						<a href="#" data-toggle="tooltip" data-placement="bottom" title="Check the purchase order's tax option"><b>Grand Total *</b></a>
					</div>
					<div class="col-lg-2">
						<input type="text" class="form-control" id="total" readonly name="total">
					</div>
				</div>
				<div id='retails' style='display:none' >
					<label>Name (Not required)</label>
					<input type='text' class='form-control' name='retail_name'>
					<div class="form-group">
						<label for="comment">Delivery Address (Not required)</label>
						<textarea class="form-control" rows="3" id="comment" name='retail_address' form='sales_order'></textarea>
					</div>
					<label>City (Not required)</label>
					<input type='text' class='form-control' name='retail_city'>
					<label>Phone (Not required)</label>
					<input type='text' class='form-control' name='retail_phone'>
				</div>
				<div class="row">
					<div class="col-lg-2" style="padding:20px">
						<button type="button" class="btn btn-success" onclick="return validateso()" id="calculate">Calculate</button>
						<button type="button" class="btn btn-primary" style="display:none" id="submitbtn" onclick="return look()">Submit</button>
						<button type="button" class="btn btn-danger" style="display:none" id="back">Back</button>
					</div>
				</div>
				<input type="hidden" class="form-control" id="jumlah_barang" name="jumlah_barang"></input>
			</form>
		</div>
		<div class='col-sm-1' style='background-color:#ddd;z-index:-100'>
		</div>
	</div>
	<div class='row' style='height:70px;background-color:#333'>
	</div>
</div>
<script type="text/javascript" src="Scripts/createsalesorder.js"></script>