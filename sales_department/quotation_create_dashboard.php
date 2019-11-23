<?php
	include('../header.php');
	include('../universal/headers/salesheader.php');
?>
<link rel="stylesheet" href="css/create_quotation.css">
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script src="../universal/Numeral-js-master/numeral.js"></script>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
<div class="main">
	<h2 style='font-family:bebasneue'>Quotation</h2>
	<p>Create new quotation</p>
	<hr>
	<form id="quotation" class="form" method="POST" action="quotation_create_validate.php">
		<div class="row">
			<div class="col-sm-6">
				<label for="name">Quote to:</label>
				<select class="form-control" id="quote_person" name="quote_person"  onclick="disable()">
				<option id="kosong" value="0">Please Select a customer--</option>
					<?php
						$sql 		= "SELECT id,name,address FROM customer WHERE is_blacklist = '0' ORDER BY name ASC";
						$result 	= $conn->query($sql);
						while($row	= $result->fetch_assoc()){
					?>
						<option value='<?= $row['id'] ?>'><?= $row['name'] ?></option>
					<?php
						}
					?>
				</select>
			</div>
			<div class="col-sm-2 offset-sm-2">
				<label for="date">Date</label>
				<input id="today" type="date" class="form-control" value="<?php echo date('Y-m-d');?>" name="quotation_date">
			</div>
		</div>
		<br>
		<h4 style='font-family:bebasneue;display:inline-block;margin-right:10px'>Detail </h4>
		<button type='button' class='button_add_row' id='add_item_button' style='display:inline-block'>Add item</button>
		<br>
		<br>
		<table class='table table-bordered'>
			<tr>
				<th style='width:25%'>Reference</th>
				<th style='width:20%'>Price (Rp.)</th>
				<th style='width:10%'>Discount</th>
				<th style='width:15%'>Quantity</th>
				<th style='width:20%'>Net Price (Rp.)</th>
				<th style='width:20%'>Total Price (Rp.)</th>
			</tr>
			<tbody id='quotation_detail'>
				<tr id='tr-1'>
					<td><input type='text' class='form-control' name='reference[1]' id='reference1'></td>
					<td><input type='text' class='form-control' name='price[1]' id='price1' step='0.01'></td>
					<td><input type='text' class='form-control' name='discount[1]' id='discount1'></td>
					<td><input type='text' class='form-control' name='quantity[1]' id='quantity1'></td>
					<td id='unitprice1'></td>
					<td id='totalprice1'></td>
					<td></td>
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
					<td>Ad. Discount</td>
					<td colspan='2' style='width:40%'><input type='number' class="form-control" id="add_discount" name="add_discount" step='0.001'></td>
				</tr>
		</table>
		<button type='button' class='hide_note_button' id='toggle_note_button'>Toggle note</button>
		<br>
		<script>
			$('#toggle_note_button').click(function(){
				$('#note_wrapper').toggle(300);
			});
		</script>
		<div id='note_wrapper'>
			<h3><b>Note</b></h3>
			<div class="row">
				<div class="col-sm-6">
					<p><b>1. Payment term</b></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<select id="terms" name="terms" class="form-control" style="width:100%" onchange="payment_js()" onclick="disable_two()">
					<option value='0' id="kosongan">--Please select payment terms--</option>
					<?php
						include("connect.php");
						$sql_payment = "SELECT * FROM payment";
						$result = $conn->query($sql_payment);
						if ($result->num_rows > 0) {
							while($rows = mysqli_fetch_array($result)) {
							echo '<option value="' . $rows["id"] . '">'. $rows["payment_term"].'</option> ';
							}
						} else {
							echo "0 results";
						}
					?>
					</select>
				</div>
			</div>
			<input type='hidden' id='check_available_input' value='true'>
			<div class="row" style="padding:5px">
				<div class="col-sm-6" style="padding:5px">
					<div class="col-sm-6" style="padding:5px">
						<div class="form-group">
							<div class="input-group">
								<input class="form-control" id="dp" name="dp" readonly maxlength='2'>
								<span class="input-group-addon" style="font-size:12px">%</span>
							</div>
						</div>
					</div>
					<div class="col-sm-6" style="padding:5px">
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
						<textarea class="form-control" name="comment" rows="3" form="quotation" style='resize:none'></textarea>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">
				<button type="button" class="button_confirm" onclick="hitung()" id="calculate">Calculate</button>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<button type="button" id="back" class="button_warning_dark" style="display:none">Back</button>
				<button type="button" id='button_validate' class="button_success_dark" style="display:none" onclick='validate()'>Submit</button>	
			</div>
		</div>
	</form>
</div>
<script>
var a = 2;

function evaluate_organic(x){
	var to_be_evaluated = $('#' + x).val();
	return eval(to_be_evaluated);
}

function hitung(){
	$('#check_available_input').val('true');
	var payment_term = $('#terms').val();
	
	if($('#add_discount').val() == ''){
		$('#add_discount').val(0);
	}
	$('input[id^=reference]').each(function(){
		$.ajax({
			url: "ajax/check_item_available.php",
			data: {
				reference: $(this).val(),
			},
			type: "POST",
			dataType: "html",
			success: function (response) {
				if((response == 1)){
					alert('Reference not found');
					$('#check_available_input').val('false');
					return false;
				}
			},
		})
	});
	var angka = true;
	$('input[id^=discount]').each(function(){
		if($(this).val() > 80 || $(this).val() == ''){
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
			$('#folder').hide();
			$('#close').hide();
			$('#add_item_button').attr('disabled',true);
			$('.button_delete_row').hide();
		}
	}
};
function validate(){
	var payment_term = $('#terms').val();
	if($('#check_available_input').val() == 'false'){
		alert('One or more reference does not exist on database!');
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
		$('#quotation').submit();
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
	$('#folder').show();
	$('#close').show();
	$('#add_item_button').attr('disabled',false);
	$('.button_delete_row').show();
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
	function disable(){
		document.getElementById("kosong").disabled = true;
	}
	function disable_two(){
		document.getElementById("kosongan").disabled = true;
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
			"<td><button type='button' class='button_delete_row' onclick='delete_row(" + a + ")'>X</button></td></tr>").find("input").each(function () {
			});
		$("#reference" + a).autocomplete({
			source: "../codes/search_item.php"
		 });
		a++;
	});

	function delete_row(n){
		$('#tr-' + n).remove();
	};
</script>