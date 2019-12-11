<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<
<div class='main'>
	<h2 style='font-family:bebasneue'>Quotataion</h2>
	<p>Edit quotataion</p>
	<hr>
<?php
	$id 				= (int)$_POST['id'];
	$sql_quotation 		= "SELECT code_quotation.name, code_quotation.payment_id, code_quotation.date, code_quotation.payment_id, code_quotation.down_payment,
							code_quotation.repayment, code_quotation.note, customer.name as customer_name
							FROM code_quotation 
							JOIN customer ON customer.id = code_quotation.customer_id
							WHERE code_quotation.id = '$id'";
	$result_quotation 	= $conn->query($sql_quotation);
	$quotation 			= $result_quotation->fetch_assoc();
	
	$quotation_name 	= $quotation['name'];
	$date 				= $quotation['date'];
	$terms				= $quotation['payment_id'];
	$dp 				= $quotation['down_payment'];
	$lunas				= $quotation['repayment'];
	$note 				= $quotation['note'];
	$customer_name		= $quotation['customer_name'];
?>
	<form name="quotation" id="quotation_edit" class="form" method="POST" action="quotation_edit_input">
		<input type="hidden" value="<?= $id ?>" name="id">
		<div class="row">
			<div class="col-sm-6">
				<h2 style='font-family:bebasneue'><?= $customer_name ?></h2>
				<h2 style='font-family:bebasneue'><?= $quotation_name ?></h2><p><?= date('d M Y',strtotime($date)) ?></p>
			</div>
		</div>
		<br>
		<h4 style='font-family:bebasneue;display:inline-block;margin-right:10px'>Detail </h4>
		<button type='button' class='button_default_dark' id='add_item_button' style='display:inline-block'>Add item</button>
		<table class='table table-bordered'>
			<tr>
				<th style='width:20%'>Reference</th>
				<th style='width:15%'>Price</th>
				<th style='width:15%'>Discount</th>
				<th style='width:15%'>Quantity</th>
				<th style='width:15%'>Net price</th>
				<th style='width:15%'>Total price</th>
				<th></th>
			</tr>
			<tbody id='detail_quotation'>
<?php
	$sql = "SELECT * FROM quotation WHERE quotation_code = '" . $id . "'";
	$result = $conn->query($sql);
	$a = 1;
	while($row = $result->fetch_assoc()){
?>	
				<tr id='tr-<?= $a ?>'>
					<td><input id='reference<?= $a ?>' 	class='form-control' 	name='reference[<?=$a?>]' 	value='<?= $row['reference']?>'></td>
					<td><input id='price<?=$a?>' 		class='form-control'	name='price[<?=$a?>]'  		value='<?= $row['price_list']?>'></td>
					<td><input id='discount<?=$a?>' 	class='form-control' 	name='discount[<?=$a?>]' 	value='<?= $row['discount']?>'></td>
					<td><input id='quantity<?=$a?>' 	class='form-control' 	name='quantity[<?=$a?>]' 	value='<?= $row['quantity']?>'></td>
					<td id='netprice_numeral<?= $a ?>'></td>
					<td id='total_price_numeral<?= $a ?>'></td>
					<td><button class='button_danger_dark' type='button' id='close<?= $a ?>' onclick='delete_row(<?= $a ?>)'>X</button></td>
				</tr>
				<script>
					$('#reference<?= $a ?>').autocomplete({
						source: "search_item.php"
					});
				</script>
<?php
		$a++;
	}
?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan='3'></td>
					<td>Total</td>
					<td id='grand_total' colspan='2'></td>
				</tr>
			</tfoot>
		</table>
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
			<div class="col-sm-12">
				<button type="button" id="back" class="button_warning_dark" style="display:none">Back</button>
				<button type="button" id="submitbtn" class="button_success_dark" style="display:none" onclick='validate()'>Submit</button>
			</div>
		</div>
		<input type='hidden' value='benar' id='danieltri'>
	</form>
</div>
<script>
var a = "<?= $a ?>";

function evaluate_organic(x){
	var to_be_evaluated = $('#' + x).val();
	return eval(to_be_evaluated);
}

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
		"<td><input id='reference" + a + "' class='form-control' name='reference[" + a + "]'></td>"+
		"<td><input style='overflow-x:hidden' id='price" + a + "' name='price[" + a + "]' class='form-control'></td>"+
		"<td><input id='discount" + a + "' class='form-control' name='discount[" + a + "]'></td>"+
		"<td><input id='quantity" + a + "' class='form-control' name='quantity[" + a + "]'></td>"+
		"<td id='netprice_numeral" + a + "'></td>"+
		"<td id='total_price_numeral" + a + "'</td>"+
		"<td><button class='button_danger_dark' type='button' id='close" + a + "' onclick='delete_row(" + a + ")'>X</button></td>"+
		"</tr>");
		
	$("#reference" + a).autocomplete({
		source: "search_item.php"
	 });
	a++;
});
function payment_js(){
	var payment_term = $('#terms').val();
	if (payment_term == 1) {
		$('#dp').val(0);
		$('#lunas').val(0);
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',true);
	} else if (payment_term == 2) {
		$('#dp').val(0);
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',false);
	} else if (payment_term == 3) {
		$('#dp').val(0);
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',false);
	} else if (payment_term == 4) {
		$('#dp').attr('readonly',false);
		$('#lunas').attr('readonly',false);
	}
};

function hitung(){
	$('#danieltri').val('benar');
	var payment_term = $('#terms').val();
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
				$('#danieltri').val('salah');
			} else {
			}
        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        }
		})
	});
	var angka = true;
	$('input[id^=discount]').each(function(){
		if($(this).val() > 75 || $(this).val() == ''){
			angka = false;
		}
	});
	if($('#quote_person').val() == 0){
		alert("Please insert a customer");
		return false;
	} else if($('#terms').val() == 0) {
		alert("Please insert correct payment term")
	} if(angka == false){
		alert('Please insert correct discount!');
		return false;
	} else {
		$('#terms').attr('readonly',true);
		$('button[id^=close]').hide();
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',true);
		$('input[id^=reference]').attr('readonly',true);
		$('input[id^=quantity]').attr('readonly',true);
		$('input[id^=price]').attr('readonly',true);
		$('input[id^=discount]').attr('readonly',true);
		$('#submitbtn').show();
		$('#back').show();
		$('#calculate').hide();
		$('#folder').hide();
		$('#close').hide();
		var calculated_total = 0;
		$('input[id^="price"]').each(function(){
			var input_id = $(this).attr('id');
			var calculated_pricelist = evaluate_organic(input_id);
			$(this).val(evaluate_organic(input_id));
			
			var uid 		= input_id.substring(5,8);
			var discount 	= $('#discount' + uid).val();
			var netprice 	= parseFloat(calculated_pricelist * (1 - discount*0.01));
			var totalprice 	= parseFloat(netprice * $('#quantity' + uid).val());
			
			$('#netprice_numeral' + uid).html(numeral(netprice).format('0,0.00'));
			$('#total_price_numeral' + uid).html(numeral($('#quantity' + uid).val() * netprice,2).format('0,0.00'));
			calculated_total = parseFloat(calculated_total + totalprice);
		});
		
		$('#grand_total').html(numeral(calculated_total).format('0,0.00'));
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
		}
	}
};
function round(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.round(value * multiplier) / multiplier;
}
$("#back").click(function () {
	$('input').attr('readonly',false);
	$('#submitbtn').hide();
	$('#back').hide();
	$('#calculate').show();
	$('#folder').show();
	$('#close').show();
	$('button[id^="close"]').show();
});
function validate(){
	if($('#danieltri').val() == 'salah'){
		alert('Please insert correct reference!');
		$('#terms').attr('readonly',false);
		$('#dp').attr('readonly',false);
		$('#lunas').attr('readonly',false);
		$('input[id^=reference]').attr('readonly',false);
		$('input[id^=price]').attr('readonly',false);
		$('input[id^=discount]').attr('readonly',false);
		$('input[id^=quantity]').attr('readonly',false);
		$('#submitbtn').hide();
		$('#back').hide();
		$('#calculate').show();
		$('#folder').show();
		$('#close').show();
		$('button[id^=close]').show();
		return false;
	} else {
		$('#quotation_edit').submit();
	}
};
</script>