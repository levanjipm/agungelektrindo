<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
<head>
	<title>Create quotation</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Quotation</h2>
	<p style='font-family:museo'>Create new quotation</p>
	<hr>
	<form id="quotation_form" class="form" method="POST" action="quotation_create_validate">
		<div class='row'>
			<div class='col-sm-6'>
				<label>Customer</label>
				<select class="form-control" id="quote_person" name="quote_person" onclick="disable('empty_customer')">
				<option id="empty_customer" value="0">Please Select a customer--</option>
					<?php
						$sql 		= "SELECT id,name FROM customer WHERE is_blacklist = '0' ORDER BY name ASC";
						$result 	= $conn->query($sql);
						while($row	= $result->fetch_assoc()){
					?>
						<option value='<?= $row['id'] ?>'><?= $row['name'] ?></option>
					<?php
						}
					?>
				</select>
			</div>
			<div class='col-sm-4'>
				<label>Date</label>
				<input id="today" type="date" class='form-control' value="<?php echo date('Y-m-d');?>" name="quotation_date">
			</div>
			<div class='col-sm-2'>
				<label style='color:white'>X</label>
				<br>
				<button type='button' class='button_default_dark' id='add_item_button'>Add item</button>
			</div>
		</div>
		<br>
		
		<table class='table table-bordered'>
			<tr>
				<th style='width:25%'>Reference</th>
				<th style='width:20%'>Price</th>
				<th style='width:10%'>Discount</th>
				<th style='width:15%'>Quantity</th>
				<th style='width:20%'>Net Price</th>
				<th style='width:20%'>Total Price</th>
			</tr>
			<tbody id='quotation_detail'>
				<tr id='tr-1'>
					<td><input type='text' class='form-control' name='reference[1]' id='reference1'></td>
					<td><input type='text' class='form-control' name='price[1]' id='price1' step='0.01'></td>
					<td><input type='text' class='form-control' name='discount[1]' id='discount1'></td>
					<td><input type='text' class='form-control' name='quantity[1]' id='quantity1'></td>
					<td id='unitprice1'></td>
					<td id='totalprice1'></td>
					<td><button type='button' class='button_success_dark' style='visibility:hidden'><i class='fa fa-trash'></i></button></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan='3'></td>
					<td>Total</td>
					<td colspan='2' style='width:40%' id='total'></td>
				</tr>
				<tr>
					<td colspan='3'></td>
					<td>Discount</td>
					<td colspan='2' style='width:40%'><input type='number' class='form-control' id='add_discount' name="add_discount" step='0.001'></td>
				</tr>
		</table>
		
		<div style='padding:20px;background-color:#eee'>
			<label>Note</label>
			
			<p style='font-family:museo'><b>1. </b>Payment term</p>
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
			<br>
			
			<div class='form-group' style='width:49%;display:inline-block'>
				<div class='input-group'>
					<input class='form-control' id='dp' name='dp' maxlength='2'>
					<span class="input-group-addon" style="font-size:12px;border-radius:0">%</span>
				</div>
			</div>
			<div class='form-group' style='width:50%;display:inline-block'>
				<div class='input-group'>
					<input class='form-control' id='lunas' name='lunas' maxlength='2' maxlength='2'>
					<span class='input-group-addon' style='font-size:12px;border-radius:0'>days</span>
				</div>
			</div>
			<p style='font-family:museo'><b>2. </b>Prices and availability are subject to change at any time without prior notice.</p>
			<p style='font-family:museo'><b>3. </b>Prices mentioned above are tax-included.</p>
			<textarea class='form-control' name='comment' rows='3' style='resize:none' placeholder='Comment'></textarea>
		</div><br>
		
		<button type='button' class='button_default_dark' onclick='calculate_quotation()' id="calculate">Calculate</button>
		
		<button type='button' class='button_danger_dark' id='back' style='display:none'>Check again</button>
		<button type='button' class='button_default_dark' onclick='validate()' id='button_validate' style='display:none'>Submit</button>
	</form>
</div>
<input type='hidden' id='check_available_input' value='true'>
<input type='hidden' id='check_quantity_input' value='true'>

<script>
var a = 2;

function evaluate_organic(x){
	var to_be_evaluated = $('#' + x).val();
	return eval(to_be_evaluated);
}

function calculate_quotation(){
	$('#check_available_input').val('true');
	$('#check_quantity_input').val('true');
	
	var payment_term = $('#terms').val();
	
	if($('#add_discount').val() == ''){
		$('#add_discount').val(0);
	}
	$('input[id^=reference]').each(function(){
		$.ajax({
			url: "/agungelektrindo/codes/check_item_availability.php",
			data: {
				reference: $(this).val(),
			},
			type: "POST",
			dataType: "html",
			success: function (response) {
				if((response == 0)){
					alert('Reference not found');
					$('#check_available_input').val('false');
					return false;
				}
			},
		})
	});
	
	$('input[id^="quantity"]').each(function(){
		if($(this).val() == 0 || $(this).val() < 0 || $(this).val() == ''){
			$('#check_quantity_input').val('false');
		}
	});
	
	var angka = true;
	$('input[id^=discount]').each(function(){
		if($(this).val() > 80 || $(this).val() == '' || $(this).val() < 0){
			angka = false;
		}
	});
	
	if($('#quote_person').val() == 0){
		alert("Please insert a customer");
		return false;
	} else if($('#today').val() == ''){
		alert('Please insert correct date!');
		return false;
	} else if(payment_term == 0) {
		alert("Please insert correct payment term");
		$('#note_wrapper').show();
		return false;
	} else if(angka == false){
		alert('Please insert correct discount!');
		return false;
	} else {
		var calculated_total = 0;
		$('input[id^=price]').each(function(){
			var input_id = $(this).attr('id');
			var calculated_pricelist = evaluate_organic(input_id);
			$(this).val(evaluate_organic(input_id));
			
			var uid 		= input_id.substring(5,8);
			var discount 	= $('#discount' + uid).val();
			var netprice 	= parseFloat(calculated_pricelist * (1 - discount*0.01));
			var totalprice 	= parseFloat(netprice * $('#quantity' + uid).val());
			
			$('#unitprice' + uid).html(numeral(netprice).format('0,0.00'));
			$('#totalprice' + uid).html(numeral($('#quantity' + uid).val() * netprice,2).format('0,0.00'));
			calculated_total = parseFloat(calculated_total + totalprice);
		});
		$('#total').html(numeral(calculated_total).format('0,0.00'));
		if(isNaN(calculated_total)){
			alert('Insert correct price!');
			return false;
		} else {
			$(':input').attr('readonly',true);
			$('#button_validate').show();
			$('#back').show();
			$('#calculate').hide();
			$('#close').hide();
			$('#add_item_button').hide();
			$('.button_danger_dark').css({'visibility':'hidden'});
		}
	}
};

function validate(){
	var payment_term = $('#terms').val();
	if($('#check_available_input').val() == 'false'){
		alert('One or more reference does not exist on database!');
		return false;
	} else if($('#check_quantity_input').val() == 'false'){
		alert('Please check your quantity input');
		return false;
	} else if(payment_term == 2 && $('#lunas').val() == '') {
		alert('Please insert correct payement detail!');
		return false;
	} else if (payment_term == 3 && $('#lunas').val() == '') {
		alert('Please insert correct payement detail!');
		return false;
	} else if (payment_term == 4 && ($('#dp').val() == '' || $('#lunas').val() == '')){
		alert('Please insert correct payement detail!');
		return false;
	} else {
		$('#quotation_form').submit();
	}
}

$("#back").click(function (){
	$('#quote_person').attr('readonly',false);
	$('input[id^=reference]').attr('readonly',false);
	$('input[id^=discount]').attr('readonly',false);
	$('input[id^=price]').attr('readonly',false);
	$('input[id^=quantity]').attr('readonly',false);	
	$('#terms').attr('readonly',false);
	$('#add_discount').attr('readonly',false);
	$('#today').attr('readonly',false);
	$('#button_validate').hide();
	$('#back').hide();
	$('#calculate').show();
	$('#close').show();
	$('#add_item_button').show();
	$('.button_danger_dark').css({'visibility':'visible'});
})

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
	
	function disable(option_id){
		$('#' + option_id).attr('disabled',true);
	}
	
	$("#add_item_button").click(function (){	
		$("#quotation_detail").append(
			"<tr id='tr-" + a + "'>"+
			"<td><input type='text' class='form-control' name='reference[" + a + "]' id='reference" + a + "'></td>"+
			"<td><input type='text' class='form-control' name='price[" + a + "]' id='price" + a + "' step='0.01'></td>"+
			"<td><input type='text' class='form-control' name='discount[" + a + "]' id='discount" + a + "'></td>"+
			"<td><input type='text' class='form-control' name='quantity[" + a + "]' id='quantity" + a + "'></td>"+
			"<td id='unitprice" + a + "'></td>"+
			"<td id='totalprice" + a + "'></td>"+
			"<td><button type='button' class='button_danger_dark' onclick='delete_row(" + a + ")'><i class='fa fa-trash'></i></button></td></tr>").find("input").each(function () {
			});
		$("#reference" + a).autocomplete({
			source: "../codes/search_item.php"
		 });
		a++;
	});

	function delete_row(n){
		$('#tr-' + n).hide(150, function(){ $(this).remove(); })
	};
</script>