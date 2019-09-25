<?php
	include('purchasingheader.php');
?>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "ajax/search_item.php"
	 })
});
</script>
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p>Purchasing return</p>
	<hr>
	<form action='purchasing_return_validation.php' method='POST' id='return_form'>
		<label>Supplier</label>
		<select class='form-control' name='supplier' id='supplier'>
			<option value='0'>Please select a supplier</option>
<?php
	$sql_supplier = "SELECT id,name FROM supplier ORDER BY name ASC";
	$result_supplier = $conn->query($sql_supplier);
	while($supplier = $result_supplier->fetch_assoc()){
?>
			<option value='<?= $supplier['id'] ?>'><?= $supplier['name'] ?></option>
<?php
	}
?>
		</select>
		<h4 style='font-family:bebasneue;display:inline-block;margin-right:10px'>Detail </h4>
		<button type='button' class='button_default_dark' id='add_item_button' style='display:inline-block'>Add item</button>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Quantity</th>
			</tr>
			<tbody id='purchase_return_table_body'>
				<tr>
					<td><input type='text' class='form-control' name='reference1' id='reference1'></td>
					<td><input type='number' class='form-control' name='quantity1' id='quantity1'></td>
					<td id='check_result1'></td>
				</tr>
			</tbody>
		</table>
	</form>
	<button type='button' class='button_default_dark' onclick='checking()' id='cekin'>Check</button>
	<button type='button' class='btn btn-warning' onclick='kembalikan()' id='balikin' style='display:none'>Back</button>
	<button type='button' class='btn btn-default' onclick='validation()' id='ajuin' style='display:none'>Submit</button>
</div>
<script>
var a = 2;
$("#add_item_button").click(function (){	
	$("#purchase_return_table_body").append(
	"<tr id='item_row-" + a + "'>"+
	"<td><input type='text' class='form-control' name='reference[" + a + "]' id='reference" + a + "'></td>"+
	"<td><input type='number' class='form-control' name='quantity[" + a + "]' id='quantity" + a + "'></td>"+
	"<td id='check_result" + a + "'></td>"+
	"</tr>")
	
	$("#reference" + a).autocomplete({
		source: "ajax/search_item.php"
	 });
	a++;
	$('#jumlah').val(a);
});

function checking(){
	if($('#supplier').val() == 0){
		alert('Please insert a supplier!');
		$('#supplier').focus();
		return false;
	}
	$('input[id^="reference"]').each(function(){
		var input_id			= $(this).attr('id');
		var reference			= $(this).val();
		var uid					= input_id.substr(9,15);
		var quantity 			= $('#quantity' + uid).val();
		
		console.log(uid);
		$.ajax({
			url:"Ajax/search_po.php",
			data:{
				reference:	$(this).val(),
				quantity:	quantity
			},
			type:"POST",
			success: function(data){
				$('#check_result' + a).html(data);
			}
		})
	});
	$('#balikin').show();
	$('#ajuin').show();
	$('#folder').hide();
	$('#close').hide();
	$('input').each(function(){
		$(this).attr('readonly',true);
	});
	$('#supplier').attr('readonly',true);
	$('#cekin').hide();
};
function kembalikan(){
	$('#balikin').hide();
	$('#ajuin').hide();
	$('#folder').show();
	$('#close').show();
	$('input').each(function(){
		$(this).attr('readonly',false);
	});
	$('#supplier').attr('readonly',false);
	$('#cekin').show();
};
function validation(){
	var point = 1;
	$('.loading').each(function(){
		if($.trim($(this).html()) != "OK"){
			alert($(this).html());
			point++;
			balikin();
			return false;
		}
	});
	if(point == 1){
		$('#return_form').submit();
	}
};
</script>