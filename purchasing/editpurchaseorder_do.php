<?php
	ob_start();
	include('purchasingheader.php');
	$po_id = $_POST['id'];
	$sql_user = "SELECT role,pin FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user = $conn->query($sql_user);
	while($row_user = $result_user->fetch_assoc()){
		$role = $row_user['role'];
		$pin = $row_user['pin'];
	}
	if($role != 'superadmin'){
		header('location:purchasing.php');
	}
	$sql_initial = "SELECT * FROM code_purchaseorder WHERE id = '" . $po_id . "'";
	$result_initial = $conn->query($sql_initial);
	while($row_initial = $result_initial->fetch_assoc()){
		$supplier_id = $row_initial['supplier_id'];
		$tax = $row_initial['taxing'];
		$top = $row_initial['top'];
		$promo_code = $row_initial['promo_code'];
	}
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
<style>
*{
	overflow-x:hidden;
}
.forming{
	border:none;
	border-bottom:2px solid #999;
	background-color:transparent;
	display:block;
	width:100%;
}
.forming:focus{
	outline-width: 0;
}
</style>
<div class="main" style='padding-top:0'>
<a href="#" id="folder" title="add item"><i class="fa fa-folder" style='z-index:200'></i></a>
	<div class='row' style='height:100%'>
		<div class='col-sm-1' style='background-color:#eee'>
		</div>
		<div class='col-sm-10' style='padding:30px'>
			<div class="container" style="right:50px">
				<h2>Purchase order</h2>
				<h4 style="color:#444">Editing purchase order</h4>
				<hr>
				<br>
			</div>
			<form action="editpurchaseorder.php" method="POST" id='edit_po'>
			<div class="row">
				<div class="col-sm-4">
					<label>Order to</label><br>
					<?php
					$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $supplier_id . "'";
					$result_supplier = $conn->query($sql_supplier);
					$supplier = $result_supplier->fetch_assoc();
					echo $supplier['name'];
					?><br>
					<label>Promo Code</label>
					<input type="text" class="forming" value="<?= $promo_code?>" name="promo_code">
					<label>Taxing option</label>
					<select class="forming" name="taxing">
<?php
			if($tax == 0){
?>
						<option value='2'>Non Tax</option>
						<option value='1'>Tax</option>
<?php
			} else{
?>
						<option value='1'>Tax</option>
						<option value='2'>Non tax</option>
<?php
			}
?>
					</select>
					<label>Term of payment</label>
					<div>
						<input type="text" value="<?= $top ?>" class="forming" name="top" style='width:75%;display:inline-block;'>
						<span style='width:20%;display:inline-block;'>Days</span>
					</div>
				</div>
			</div>
			<div class="row" style="text-align:center;padding:20px">
				<div class="col-sm-2" style='background-color:#aaa'>Item</div>
				<div class="col-sm-2" style='background-color:#ccc'>Price list</div>
				<div class="col-sm-1" style='background-color:#aaa'>Discount</div>
				<div class="col-sm-2" style='background-color:#ccc'>Unit Price</div>
				<div class="col-sm-2" style='background-color:#aaa'>Quantity</div>
				<div class="col-sm-2" style='background-color:#ccc'>Total Price</div>
			</div>
			<input type="hidden" value='<?= $po_id ?>' name="po_id">
<?php
	$i = 1;
	$sql  = "SELECT * FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_second = "SELECT * FROM purchaseorder_received WHERE purchaseorder_id = '" . $po_id . "' AND id = '" . $row['id'] . "'";
		$result_second = $conn->query($sql_second);
		while($row_second = $result_second->fetch_assoc()){
			$min_val = $row_second['quantity'];
		}
?>
			<div class="row" style="text-align:center;padding:20px" id="<?= $i ?>">
				<div class="col-sm-2"><input type='text' value="<?= $row['reference'] ?>" class="form-control" id='ref<?= $i ?>' name='ref<?= $i ?>'></div>
				<div class="col-sm-2"><input type="text" value="<?= $row['price_list'] ?>" class='form-control' id="pl<?= $i?>" name="pl<?= $i?>"></div>
				<div class="col-sm-1"><input type="text" value="<?= $row['discount'] ?>" class="form-control" min='0' max='100' id="discount<?= $i ?>" name="discount<?= $i ?>"></div>
				<div class="col-sm-2"><input type="text" value="<?= $row['unitprice'] ?>" class="form-control" readonly id="unitprice<?= $i?>" name="unitprice<?= $i?>"></div>
				<div class="col-sm-2"><input type="text" value="<?= $row['quantity'] ?>" min='<?= $min_val ?>' class="form-control" id="qty<?= $i ?>" name="qty<?= $i ?>"></div>
				<div class="col-sm-2"><input type="text" value="<?= $row['totalprice'] ?>" class="form-control" readonly id="totalprice<?= $i ?>" name="totalprice<?= $i ?>"></div>
				<div class="col-sm-1"><button type="button" class="btn btn-danger" onclick="delete_item(<?= $i ?>)">&times</button></div>
			</div>
<?php
	$i++;
	}
?>
			<div id="input_list">
			</div>
			<input type="hidden" id="jumlah_barang" name="x">
			<button type="button" class="btn btn-primary" onclick="calculate()">Next</button>
			</form>	
		</div>
		<div class='col-sm-1' style='background-color:#eee'>
		</div>
	</div>
	<div class='row' style='display:none' id='pin_wrapper'>
			<div class='col-sm-12'  style='z-index:100;width:100%;height:100%;background-color:rgba(1,1,1,0.8);position:absolute;top:0;right:0' id='pin_overlay'>
			</div>
			<div class='col-sm-4 col-sm-offset-4' style='z-index:110;position:absolute;top:30%;left:0;padding:30px;background-color:#fff'>
				<label>Input your pin</label>
				<input type="number" id='pin' class='form-control' maxlength='6'>
				<br><br>
				<button type='button' class='btn btn-outline-success' onclick='exit()'>Check Again</button>
				<button type='button' class='btn btn-outline-primary' onclick='check_pin()'>Proceed</button>	
			</div>
		</div>
</div>
<style>
#pin{
	-webkit-text-security: disc;
}
#pin::-webkit-inner-spin-button, 
#pin::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
#snackbar {
  visibility: hidden; /* Hidden by default. Visible on click */
  min-width: 250px; /* Set a default minimum width */
  margin-left: -150px; /* Divide value of min-width by 2 */
  background-color: #333; /* Black background color */
  color: #fff; /* White text color */
  text-align: center; /* Centered text */
  border-radius: 3px; /* Rounded borders */
  padding: 20px 40px; /* Padding */
  position: fixed; /* Sit on top of the screen */
  z-index: 1; /* Add a z-index if needed */
  left: 50%; /* Center the snackbar */
  bottom: 30px; /* 30px from the bottom */
}
#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>
<div id="snackbar">
	<div class="row">
		<p style="font-size:1em">Be careful on editing purchase order.</p>
	</div>
</div>
<script>
	$(document).ready(function(){
	  var x = $("#snackbar");
	  x.addClass('show');
	  setTimeout(function() { 
		x.removeClass('show');
	  }, 3000);
	});
	function opendesc(n){
		var x = n;
		$('#' + x).fadeIn();
		$('#open' + x).hide();
		$('#close' + x).show();
	}
	function closedesc(n){
		var x = n;
		$('#' + x).fadeOut();
		$('#open' + x).show();
		$('#close' + x).hide();
	}	
	function delete_item(n){
		var row = n;
		var minimum = $('#qty' + row).attr('min');
		if (minimum == '0'){
			$(':input[id = qty' + row + ']').val(0);
			$('#' + row).hide();
		} else{
			alert('Cannot delete this data because it is bound to minimum sent items');
		}
	}
	var i = <?= $i ?>;
	$("#folder").click(function (){
		$("#input_list").append(
		'<div class="row" style="text-align:center;padding:5px 20px 5px" id="' + i + '">' + 
			'<div class="col-sm-2"><input type="text" value="<?= $row['reference'] ?>" class="form-control" id="ref' + i + '" name="ref' + i + '"></div>' +
			'<div class="col-sm-2"><input type="text" value="<?= $row['price_list'] ?>" class="form-control" id="pl' + i + '" name="pl' + i + '"></div>'+
			'<div class="col-sm-1"><input type="text" value="<?= $row['discount'] ?>" class="form-control" min="0" max="100" id="discount' + i + '" name="discount' + i + '"></div>'+
			'<div class="col-sm-2"><input type="text" value="<?= $row['unitprice'] ?>" class="form-control" readonly id="unitprice' + i + '"></div>' + 
			'<div class="col-sm-2"><input type="text" value="<?= $row['quantity'] ?>" min="0" class="form-control" id="qty' + i + '" name="qty' + i + '"></div>'+
			'<div class="col-sm-2"><input type="text" value="<?= $row['totalprice'] ?>" class="form-control" readonly id="totalprice' + i + '"></div>'+
			'<div class="col-sm-1"><button type="button" class="btn btn-danger" onclick="delete_item(' + i + ')">&times</button></div>' + 
		'</div>').find("input").each(function () {
			});
		$("#ref" + <?= $i ?>).autocomplete({
			source: "Ajax/search_item.php"
		 });
		i++;
	});
	function calculate(){
		var duplicate=false;
		$('input[id^=ref]').each(function(){
			var $this = $(this);
			if ($this.val()===''){ return;}
			$('input[id^=ref]').not($this).each(function(){
				if ( $(this).val()==$this.val()) {duplicate=true;}
			});
		});
		if(duplicate){
			alert('Reference must be unique!');
			return false;
		} else {
			$('#jumlah_barang').val(i);
			$('#pin_wrapper').fadeIn();
			$('.btn-danger').each(function(){
				$(this).hide();
			});
		}
	}
	function exit(){
		$('#pin_wrapper').fadeOut();
		$('.btn-danger').each(function(){
			$(this).show();
		});
	}
	function check_pin(){
		if($('#pin').val() == <?= $pin ?>){
			$('#edit_po').submit();
		} else {
			$('#pin').val('');
			$('#pin_wrapper').hide();
			alert('Insert correct pin!');
			$('.btn-danger').each(function(){
				$(this).show();
			});
		}
	}
			
</script>
<?php
	ob_end_flush();
?>