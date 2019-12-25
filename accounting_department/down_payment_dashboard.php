<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
<head>
	<title>Create down payment invoice</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Random Invoice</h2>
	<p style='font-family:museo'>Create <i>Down payment</i> invoice</h2>
	<hr>
	<form method='POST' id='down_payment_form' action='down_payment_validation'>
		<label>Date</label>
		<input type='date' class='form-control' id='invoice_date' name='invoice_date' value='<?php echo date('Y-m-d');?>'>
		
		<label>Customer</label>
		<select class='form-control' id='select_customer' name='select_customer'>
		<option value="">Please select a customer--</option>
<?php
		$sql_customer		= "SELECT id,name FROM customer";
		$result_customer	= $conn->query($sql_customer);
		while($customer 	= $result_customer->fetch_assoc()) {
			$customer_id	= $customer['id'];
			$customer_name	= $customer['name'];
?>
			<option value='<?= $customer_id ?>'><?= $customer_name ?></option>
<?php
		}			
?>
		</select>
		<label>Purchase Order number</label>
		<input type='text' class='form-control' id='purchase_order_number' name='purchase_order_number'>	
		
		<label>Taxing option</label>
		<select class='form-control' id='taxing' name='taxing'>
			<option value=''>--Please choose taxing option--</option>
			<option value='1'>Tax</option>
			<option value='0'>Non-Tax</option>
		</select>
		
		<br>
		<button type='button' class='button_default_dark' id='add_item_button'>Add item</button>
		<br><br>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Quantity</th>
				<th>VAT</th>
				<th>Total price</th>
			</tr>
			<tbody id='down_payment_table'>
				<tr>
					<td><input id='reference1' 	name="reference[1]" 	class='form-control'></td>
					<td><input id='qty1' 		name="qty[1]" 			class='form-control'></td>
					<td><input id='vat1' 		name="vat[1]" 			class='form-control'></td>
					<td id='total_td_1'></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan='2'></td>
					<td><strong>Total</strong></td>
					<td id='grand_total' colspan='2'></td>
				</tr>
			</tfoot>
		</table>
		<br>
		<button type='button' class='button_default_dark'	id='calculate_button'>Calculate</button>
		<button type='button' class='button_danger_dark' 	style='display:none' id='back_button'>Back</button>
		<button type='button' class='button_success_dark'	style='display:none' id='submit_button'>Submit</button>	
	</form>
</div>
<script>
	var a = 2;

	$('#add_item_button').click(function (){	
		$('#down_payment_table').append(
			"<tr id='item-" + a + "'>"+
			"<td><input class='form-control' id='reference" + a + "' 	name='reference[" + a + "']></td>"+
			"<td><input class='form-control' id='qty" + a + "' 			name='qty[" + a + "']></td>"+
			"<td><input class='form-control' id='vat" + a + "'			name='vat[" + a + "'></td>"+
			"<td id='total_td_" + a + "'></td>"+
			"<td><button type='button' class='button_danger_dark' onclick='remove(" + a + ")'>&times</button></td>"+
		"</tr>");
		
		$("#reference" + a).autocomplete({
			source: "../codes/search_item.php"
		});
		
		a++;
	});

	function remove(n){
		$('#item-' + n).remove();
	};
	
	$('#calculate_button').click(function(){
		var total_price		= 0;
		$('input[id^="reference"]').each(function(){
			var id			= $(this).attr('id');
			var uid			= parseInt(id.substring(9,15));
			var quantity	= parseFloat($('#qty' + uid).val());
			var price		= parseFloat($('#vat' + uid).val());
			
			var total_price	= quantity * price;
			$('#total_td_' + uid).text(numeral(total_price).format('0,0.00'));
		});
	});
</script>
	