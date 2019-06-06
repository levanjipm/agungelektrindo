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
<a href="#" id="folder"><i class="fa fa-folder"></i></a>
<a href="#" id="close"><i class="fa fa-close"></i></a>
	<h2>Return</h2>
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
		<hr>
		<div class='row' style='text-align:center'>
			<div class='col-sm-1'>
				No.
			</div>
			<div class='col-sm-4'>
				Reference
			</div>
			<div class='col-sm-3'>
				Quantity
			</div>
		</div>
		<hr>
		<div class='row'>
			<div class='col-sm-1'>
				1
			</div>
			<div class='col-sm-4'>
				<input type='text' class='form-control' name='reference1' id='reference1'>
			</div>
			<div class='col-sm-3'>
				<input type='number' class='form-control' name='quantity1' id='quantity1'>
			</div>
			<div class='col-sm-2 loading' id='check_result1'></div>
		</div>
		<div id='input_list'></div>
		<hr>
		<input type='hidden' value='2' name='jumlah' id='jumlah' readonly>
	</form>
	<button type='button' class='btn btn-primary' onclick='checking()' id='cekin'>Check</button>
	<button type='button' class='btn btn-warning' onclick='kembalikan()' id='balikin' style='display:none'>Back</button>
	<button type='button' class='btn btn-default' onclick='validation()' id='ajuin' style='display:none'>Submit</button>
</div>
<script>
var i;
var a = 2;
$("#folder").click(function (){	
	$("#input_list").append(
	'<div class="row" style="padding-top:10px" id="barisan'+a+'">'+
	'<div class="col-sm-1">'+a+'</div>'+
	'<div class="col-sm-4"><input id="reference'+a+'" name="reference'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-sm-3">'+'<input id="quantity'+a+'" name="quantity'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-sm-2 loading" id="check_result' + a + '"></div>'+
	'</div>').find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
		source: "ajax/search_item.php"
	 });
	a++;
	$('#jumlah').val(a);
});

$("#close").click(function () {
	if(a>2){
	a--;
	$('#jumlah').val(a);
	x = 'barisan' + a;
	$("#"+x).remove();
	} else {
		return false;
	}	
});
function checking(){
	if($('#supplier').val() == 0){
		alert('Please insert a supplier!');
		$('#supplier').focus();
		return false;
	}
	$('input[id^=reference]').each(function(){
		var parent = $(this).parent();
		var quantity_siblings = parent.siblings();
		var quantity_child = quantity_siblings.find('input');
		var loading = parent.parent().find('.loading');
		$.ajax({
			url:"Ajax/search_po.php",
			data:{
				reference:$(this).val(),
				quantity:$(quantity_child).val()
			},
			type:"POST",
			success: function(data){
				loading.html($.trim(data));
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