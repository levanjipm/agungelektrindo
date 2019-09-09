<?php
	//editing Sales order//
	include('salesheader.php');
	$so_id = $_POST['id'];
	if($so_id == NULL){
		header('location:sales.php');
	}
	$sql_initial 		=  "SELECT name,customer_id,po_number,label, seller FROM code_salesorder WHERE id = '" . $so_id . "'";
	$result_initial 	= $conn->query($sql_initial);
	$row_initial 		= $result_initial->fetch_assoc();
	
	$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $row_initial['customer_id'] . "'";
	$result_customer 	= $conn->query($sql_customer);
	$customer 			= $result_customer->fetch_assoc();
?>
<link rel='stylesheet' href='../jquery-ui.css'>
<script src='../jquery-ui.js'></script>
<script src="../universal/Numeral-js-master/numeral.js"></script>
<script>
$( function() {
	$('input[id^="reference"]').autocomplete({
		source: "search_item.php"
	 })
});
</script>
<style>
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
	}
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
		box-shadow: 3px 4px 3px 4px #ddd;
	}
	.btn-confirm{
		background-color:#2bf076;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-x{
		background-color:transparent;
		border:none;
		outline:0!important;
	}
	.btn-x:focus{
		outline: 0!important;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Order</h2>
	<p>Edit sales order</p>
<?php
	if($role == 'superadmin'){
?>
		<button type='button' class='button_danger_dark' id='close_sales_order_button'>Close</button>
<?php
	}
?>
	<hr>
	<form method='POST' action='edit_so_validation' id='sales_order_form'>
		<h3 style='font-family:bebasneue'><?= $customer['name'] ?></h3>
		<p><?= $row_initial['name'] ?></p>
		<label>Purchase Order Number</label>
		<input type='text' class='form-control' value='<?= $row_initial['po_number']; ?>' style='width:50%' name='po_number'>
		<label>Label</label>
		<select class='form-control' style='width:50%' name='label'>
			<option value='0'>-- Label --</option>
			<option value='BLAPAK' <?=$row_initial['label'] == 'BLAPAK' ? ' selected="selected"' : '';?>>Bukalapak</option>
		</select>
		<label>Seller</label>
		<select class='form-control' style='width:50%' name='seller'>
			<option value='0'>-- Seller --</option>
<?php
			$sql_seller		= "SELECT id,name FROM users WHERE isactive = '1'";
			$result_seller	= $conn->query($sql_seller);
			while($seller	= $result_seller->fetch_assoc()){
?>
			<option value='<?= $seller['id'] ?>' <?=$row_initial['seller'] == $seller['id'] ? ' selected="selected"' : '';?>><?= $seller['name'] ?></option>
<?php
			}
?>
		</select>
		<br>
		<h4 style='font-family:bebasneue;display:inline-block;margin-right:10px'>Detail </h4>
		<button type='button' class='button_default_dark' id='add_item_button' style='display:inline-block'>Add item</button>
		<table class='table table-bordered'>
			<tr>
				<th style='width:20%'>Reference</th>
				<th style='width:10%'>Qty</th>
				<th style='width:5%'>Sent</th>
				<th style='width:15%'>V.A.T.</th>
				<th style='width:15%'>Price list</th>
				<th style='width:25%'>Discount</th>
				<th></th>
			</tr>
			<tbody id='edit_sales_order_table'>
<?php
	$reference_array = array();
	$sql_so 	= "SELECT id,reference,quantity,price,price_list,sent_quantity,status FROM sales_order WHERE so_id = '" . $so_id . "'";
	$result_so 	= $conn->query($sql_so);
	while($so 	= $result_so->fetch_assoc()){
		$reference			= $so['reference'];
		array_push($reference_array,$reference);
		$sent_quantity		= max(0,$so['sent_quantity']);
		$quantity			= $so['quantity'];
		$id					= $so['id'];
		$status				= $so['status'];
?>
				<tr id='exist_tr-<?= $so['id'] ?>'>
<?php
		if($sent_quantity == 0 && $status == 0){
?>
					<td><input type='text' 		value='<?= $so['reference']; ?>' 	class='form-control' name='reference[<?= $id ?>]' 	id='reference<?= $id ?>'></td>
					<td><input type='number' 	value='<?= $so['quantity']; ?>' 	class='form-control' name='quantity[<?= $id ?>]' 	id='quantity<?= $id ?>' min='<?= $sent_quantity ?>' ></td>
					<td><?= $so['sent_quantity'] ?></td>
					<td><input type='number' 	value='<?= $so['price']; ?>' 		class='form-control' name='price[<?= $id ?>]'			id='price<?= $id ?>'></td>
					<td><input type='number' 	value='<?= $so['price_list']; ?>' 	class='form-control' name='price_list[<?= $id ?>]'	id='price_list<?= $id ?>'></td>
					<td id='discount<?= $id ?>'><?= number_format(100 * (1 - ($so['price']/ $so['price_list'])),2) ?>%</td>
					<td><button type='button' class='button_danger_dark' onclick='show_notification(<?= $id ?>)' id='delete_row_button-<?= $id ?>'>X</button></td>
					<script>
						$('#exist_reference<?= $id ?>').autocomplete({
							source: "../codes/search_item.php"
						});
					</script>
<?php
		} else {
?>
					<td>
						<?= $so['reference']; ?>
						<input type='hidden' value='<?= $so['reference'] ?>' class='form-control' name='reference[<?= $id ?>]' 	id='reference<?= $id ?>'>
					</td>
					<td><input type='number' value='<?= $so['quantity']; ?>' class='form-control' name='quantity[<?= $id ?>]' 	id='quantity<?= $id ?>' min='<?= $so['sent_quantity'] ?>'></td>
					<td><?= $so['sent_quantity'] ?></td>
					<td>
						Rp. <?= number_format($so['price'],2); ?>
						<input type='hidden' value='<?= $so['price'] ?>' id='price<?= $id ?>'>
					</td>
					<td>
						Rp. <?= number_format($so['price_list'],2); ?>
						<input type='hidden' value='<?= $so['price_list'] ?>' id='price_list<?= $id ?>'>
					</td>
					<td id='discount<?= $id ?>'><?= number_format(100 * (1 - ($so['price']/ $so['price_list'])),2) ?>%</td>
					<td></td>
<?php
		}
?>
				</tr>
<?php
	};
?>
			</tbody>
			<tfoot>	
				<tr>
					<td style='border:none;' colspan='4'></td>
					<td>Total</td>
					<td id="grand_total"></td>
					<input type='hidden' id='total_number'/>
				</tr>
			</tfoot>
		</table>
		<input type='hidden' value='<?= $so_id ?>' name='id_so'>
		<button type='button' class='button_default_dark' id='calculate_button' onclick='calculate()'>Calculate</button>
		<button type='button' class='button_warning_dark' id='recalculate_button' style='display:none'>Back</button>
		<button type='button' class='button_success_dark' id='sales_order_submit' style='display:none'>Submit</button>
	</form>
<div class='notification_large' style='display:none' id='delete_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to delete this item?</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete' id='delete_button'>Delete</button>
		<input type='hidden' value='0' id='delete_id'>
	</div>
</div>
<?php
	if($role == 'superadmin'){
?>
<div class='notification_large' style='display:none' id='close_so_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to close this sales order?</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete' id='delete_button'>Delete</button>
		<input type='hidden' value='0' id='close_id'>
	</div>
</div>
<?php
	}
?>
<input type='hidden' value='false' id='check_reference_input'>
<input type='hidden' value='false' id='check_duplicate_input'>
<script>
var a = 1;
	function evaluate_organic(x){
		var to_be_evaluated = $('#' + x).val();
		return eval(to_be_evaluated);
	}

	$('#add_item_button').click(function(){
		$('#edit_sales_order_table').append(
			"<tr id='new_item_tr-" + a + "'>"+
			"<td><input type='text' 	class='form-control' id='reference-" + a + "' name='reference_new[" + a + "]'></td>"+
			"<td><input type='number' 	class='form-control' id='quantity-" + a + "' name='quantity_new[" + a + "]'></td>"+
			"<td></td>"+
			"<td><input type='number' 	class='form-control' id='price-" + a + "' name='price_new[" + a + "]'></td>"+
			"<td><input type='number' 	class='form-control' id='price_list-" + a + "' name='price_list_new[" + a + "]'></td>"+
			"<td id='discount-" + a + "'></td>"+
			"<td><button type='button' class='button_danger_dark' onclick='delete_new_row(" + a + ")' id='delete_row_button-" + a + "'>X</button></td>"+
			"</tr>");
		$("#reference-" + a).autocomplete({
			source: "../codes/search_item.php"
		});
		a++;
	});
	
	function delete_new_row(n){
		$('#new_item_tr-' + n).remove();
	};
	
	function show_notification(n){
		$('#delete_id').val(n);
		$('#delete_notification').fadeIn();
	};
	
	$('.btn-back').click(function(){
		$('.notification_large').fadeOut();
	});
	
	$('.btn-delete').click(function(){
		var n =  $('#delete_id').val();
		$.ajax({
			url:"delete_item_sales_order.php",
			data:{
				sales_order_id: $('#delete_id').val(),
			},
			type:"POST",
			beforeSend:function(){
				$('.btn-delete').attr('disabled',true);
			},
			success:function(response){
				if(response == 1){
					$('#exist_tr-' + n).remove();
				}
				$('#delete_notification').fadeOut();
			}
		});
	});
<?php
	if($role == 'superadmin'){
?>	
	$('#close_sales_order_button').click(function(){
		$('#close_so_notification').fadeIn();
	});
<?php
	}
?>
	function calculate(){
		var total_sales_order	= 0;
		$('#check_reference_input').val('false');
		$('#check_duplicate_input').val('false');
		var reference_array = [];
		$('input[id^="reference"]').each(function(){
			$.ajax({
				url:"../codes/check_item_availability.php",
				data:{
					reference: $(this).val()
				},
				success:function(response){
					if(response == 0){
						$('#check_reference_input').val('true');
					}
				},
				type:'POST'
			});
			
			var reference_value = $(this).val();
			if (reference_array.indexOf(reference_value) == -1){
				reference_array.push(reference_value);
			} else {
				$('#check_duplicate_input').val('true');
			}
			
			var input_id	= $(this).attr('id');
			var uid			= input_id.substring(9,15);
			var price		= parseFloat($('#price' + uid).val());
			var price_list	= parseFloat($('#price_list' + uid).val());
			var quantity	= parseFloat($('#quantity' + uid).val());
			
			if(price_list == 0){
				var discount	= 0;
			} else {
				var discount	= parseFloat(100 * (1 - price/ price_list));
			}
			$('#discount' + uid).html(numeral(discount).format('0,0.00') + '%');
			if(price == '' || price < 0){
				$('#price' + uid).val(0);
			}
			total_sales_order += (quantity * $('#price' + uid).val());
		});
		
		$('#total_number').val(total_sales_order);
		$('#grand_total').html('Rp. ' + numeral(total_sales_order).format('0,0.00'))
		
		if($('#check_reference_input').val() == 'true'){
			alert('There are one or more reference not found');
			return false;
		} else if($('#check_duplicate_input').val() == 'true'){
			alert('We found a duplicate reference');
			return false;
		} else {
			$('#sales_order_form input').attr('readonly',true);
			$('#recalculate_button').show();
			$('#sales_order_submit').show();
			$('#sales_order_submit').attr('disabled',false);
			$('#calculate_button').hide();
			$('button[id^="delete_row_button-"]').hide();
		}
	}
	
	$('#recalculate_button').click(function(){
		$('#sales_order_form input').attr('readonly',false);
		$('#recalculate_button').hide();
		$('#sales_order_submit').hide();
		$('#sales_order_submit').attr('disabled',true);
		$('#calculate_button').show();
		$('button[id^="delete_row_button-"]').show();
	});
	
	$('#sales_order_submit').click(function(){
		if(isNaN($('#total_number').val())){
			alert('Please insert valid price');
			$('#recalculate_button').click();
			return false;
		} else if($('#check_reference_input').val() == 'true'){
			alert('Please check your reference');
			$('#recalculate_button').click();
			return false;
		} else if($('#check_duplicate_input').val() == 'true'){
			alert('Please check your reference');
			$('#recalculate_button').click();
			return false;
		} else {
			$('#sales_order_form').submit();
		}
	})
</script>