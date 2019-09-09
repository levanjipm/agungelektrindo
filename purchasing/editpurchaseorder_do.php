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
	$row_initial = $result_initial->fetch_assoc();
	$supplier_id = $row_initial['supplier_id'];
	$tax = $row_initial['taxing'];
	$top = $row_initial['top'];
	$promo_code = $row_initial['promo_code'];
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class="main">
	<div class='row'>
		<div class='col-sm-12'>
			<h2 style='font-family:bebasneue'>Purchase order</h2>
			<p>Edit purchase order</p>
			<hr>
			<br>
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
					<input type="text" class="form-control" value="<?= $promo_code?>" name="promo_code">
					<label>Taxing option</label>
					<select class="form-control" name="taxing">
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
						<input type="text" value="<?= $top ?>" class="form-control" name="top" style='width:75%;display:inline-block;'>
						<span style='width:20%;display:inline-block;'>Days</span>
					</div>
				</div>
			</div>
			<br>
			<table class='table table-bordered'>
				<tr>
					<th>Item</th>
					<th>Price list(Rp.)</th>
					<th>Discount</th>
					<th>Unit price</th>
					<th>Quantity</th>
					<th>Total price</th>
					<th></th>
				</tr>
				<tbody id='purchase_order_body'>
<?php
	$sql  = "SELECT * FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$total_price 		= $row['unitprice'] * $row['quantity'];
		$quantity_received	= $row['received_quantity'];
		
		if($quantity_received > 0){
			$disabled = 'disabled';
		} else {
			$disabled = '';
		}
?>
					<tr id="tr-<?= $row['id'] ?>">
						<td><input type='text' value="<?= $row['reference'] ?>" 	class="form-control" id='reference<?= $row['id'] ?>' 			name='ref<?= $row['id'] ?>' <?= $disabled ?>></td>
						<td><input type="text" value="<?= $row['price_list'] ?>" 	class='form-control' id="pl<?= $row['id']?>" 			name="pl<?= $row['id']?>"></td>
						<td><input type="text" value="<?= $row['discount'] ?>" 		class="form-control" id="discount<?= $row['id'] ?>" 	name="discount<?= $row['id'] ?>"	min='0' max='100'></td>
						<td><input type="text" value="<?= $row['unitprice'] ?>" 	class="form-control" id="unitprice<?= $row['id']?>" 	name="unitprice<?= $row['id']?>"	readonly ></td>
						<td><input type="text" value="<?= $row['quantity'] ?>" 		class="form-control" id="qty<?= $row['id'] ?>" 			name="qty<?= $row['id'] ?>" 		min='<?= $min_val ?>' ></td>
						<td><?= number_format($total_price,2) ?></td>
						<td><?php if($disabled == 'disabled'){ ?><button type="button" class="btn btn-danger" onclick="delete_item(<?= $row['id'] ?>)">&times</button><?php ;} ?></td>
					</tr>
					<script>
						$( function() {
							$('#reference<?= $row['id'] ?>').autocomplete({
								source: "ajax/search_item.php"
							 })
						});
					</script>
<?php
	}
?>
				</tbody>
			</table>
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
	// $("#folder").click(function (){
		// $("#input_list").append(
		// '<div class="row" style="text-align:center;padding:5px 20px 5px" id="' + i + '">' + 
			// '<div class="col-sm-2"><input type="text" value="<?= $row['reference'] ?>" class="form-control" id="ref' + i + '" name="ref' + i + '"></div>' +
			// '<div class="col-sm-2"><input type="text" value="<?= $row['price_list'] ?>" class="form-control" id="pl' + i + '" name="pl' + i + '"></div>'+
			// '<div class="col-sm-1"><input type="text" value="<?= $row['discount'] ?>" class="form-control" min="0" max="100" id="discount' + i + '" name="discount' + i + '"></div>'+
			// '<div class="col-sm-2"><input type="text" value="<?= $row['unitprice'] ?>" class="form-control" readonly id="unitprice' + i + '"></div>' + 
			// '<div class="col-sm-2"><input type="text" value="<?= $row['quantity'] ?>" min="0" class="form-control" id="qty' + i + '" name="qty' + i + '"></div>'+
			// '<div class="col-sm-2"><input type="text" value="<?= $row['totalprice'] ?>" class="form-control" readonly id="totalprice' + i + '"></div>'+
			// '<div class="col-sm-1"><button type="button" class="btn btn-danger" onclick="delete_item(' + i + ')">&times</button></div>' + 
		// '</div>').find("input").each(function () {
			// });
		// $("#ref" + ).autocomplete({
			// source: "Ajax/search_item.php"
		 // });
	// });
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