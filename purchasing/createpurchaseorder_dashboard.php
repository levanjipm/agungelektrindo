<?php
	include("purchasingheader.php");
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "ajax/search_item.php"
	 })
});
</script>
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
<div class="main" style="overflow-x:hidden;padding:0px">
	<a href="#" id="folder"><i class="fa fa-folder"></i></a>
	<a href="#" id="close"><i class="fa fa-close"></i></a>
	<div class='row' style='padding:0px;height:100%'>
		<div class='col-sm-10 col-sm-offset-1' style='padding:30px'>
			<h2 style='font-family:bebasneue'>Purchase order</h2>
			<h4 style="color:#444" id='demo'>Creating new purchase order</h4>
			<hr>
			<br>
			<form name="purchaseorder" id="purchaseorder" method="POST" action="createpurchaseorder_validation.php" style="font-family:sans-serif">
				<div class="row">
					<div class="col-sm-5">
						<label for="name">Order to</label>
						<select class="form-control" id="selectsupplier" name="selectsupplier"  onclick="disable()">
						<option id="kosong" value="">--Please Select a supplier--</option>
							<?php
								include("connect.php");
								$sql = "SELECT id,name,address FROM supplier ORDER BY name";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
									while($row = mysqli_fetch_array($result)) {
									echo '<option id="pilih" value="' . $row["id"] . '">'. $row["name"].'</option> ';
									}
								}
							?>
						</select>
						<label>Promo Code</label>
						<input type="text" class="form-control" name="code_promo" placeholder="Promo code">
						<label for="top">Payement Terms:</label>
						<input class="form-control" id="top" value="30" name="top" style='width:75%;display:inline-block;' required>
						<span style='width:20%;display:inline-block;'>Days</span>	
					</div>
					<div class="col-sm-5 col-sm-offset-1">
						<label for="date">Date</label>
						<input id="today" name="today" type="date" class="form-control" value="<?= date('Y-m-d');?>">
						<label>Send date</label>
						<input type='date' class='form-control' name='sent_date' id='sent_date'>
						<div class="checkbox">
							<label class="radio-inline"><input type="radio" name="delivery_date" checked value='1'>Insert date</label>
							<label class="radio-inline"><input type="radio" name="delivery_date" value='2'>Unknown date</label>
							<label class="radio-inline"><input type="radio" name="delivery_date" value='3'>Urgent delivery</label>
						</div>
					</div>
				</div>
				<div class="row" id="headerlist" style="border-radius:10px;padding-top:25px">
					<div class="col-sm-1" style="background-color:#aaa">
						Nomor
					</div>
					<div class="col-sm-2" style="background-color:#ccc">
						Reference
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
				<div class="row" style="padding-top:10px;">
					<div class="col-sm-1">
						1
					</div>
					<div class="col-sm-2">
						<input id="reference1" class="form-control ref" name="reference1" style="width:100%" required>
					</div>
					<div class="col-sm-2">
						<input type='number' style="overflow-x:hidden" id="price1" name="price1" class="form-control" style="width:100%" required>
					</div> 
					<div class="col-sm-1">
						<input type='number' id="discount1" class="form-control" name="discount1" style="width:100%" required>
					</div>
					<div class="col-sm-1">
						<input type='number' id="quantity1" class="form-control" name="quantity1" style="width:100%" required></input>
					</div>
					<div class="col-sm-2">
						<input type='number' class="nomor" id="unitprice1" name="unitprice1" readonly></input>
					</div>
					<div class="col-sm-2">
						<input type='number' class="nomor" id="totalprice1" name="totalprice1" readonly></input>
					</div>
				</div>
				<div id="input_list">
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-2 offset-lg-7">
						<label for="total">Total</label>
					</div>
					<div class="col-sm-2">
						<input class="nomor" id="total" name="total" readonly></input>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-8'>
						<label class="radio-inline"><input type="radio" name="optradio" checked value='1' onchange='delivery_option()'>Default</label>
						<label class="radio-inline"><input type="radio" name="optradio" value='2' onchange='delivery_option()'>As dropshiper</label>
						<br><br>
						<div id='dropshiper_delivery' style='display:none'>
							<label>Name</label>
							<input type='text' class='form-control' name='dropship_name' id='dropship_name'>
							<label>Delivery address:</label>
							<input type='text' class='form-control' name='dropship_address' id='dropship_address'>
							<label>City</label>
							<input type='text' class='form-control' name='dropship_city' id='dropship_city'>
							<label>Phone number</label>
							<input type='text' class='form-control' name='dropship_phone' id='dropship_phone'>
						</div>
					</div>
					<script>
						function delivery_option(){
							if($('input[name=optradio]:checked').val() == 1){
								$('#dropshiper_delivery').fadeOut();
							} else {
								$('#dropshiper_delivery').fadeIn();
							}
						}
					</script>
				</div>
				<div class='row' style='padding:20px'>
					<label>Note</label>
					<textarea class="form-control" rows="5" form="purchaseorder" name='note'></textarea>
				</div>
				<br><br>
				<div class="row">
					<div class="col-sm-2">
						<button type="button" class="btn btn-default" onclick="hitung()" id="calculate">Calculate</button>
					</div>
				</div>
				<div class="row" style="padding-top:20px">
					<div class="col-sm-6">
						<button type="button" id="back" class="btn btn-danger" style="display:none">Back</button>
						<button type="submit" id="submitbtn" class="btn btn-success">Submit</button>
						<input type="hidden" class="form-control" id="jumlah_barang" name="jumlah_barang">
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript"src="Scripts/createpurchaseorder.js"></script>