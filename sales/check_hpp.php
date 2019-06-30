<?php
	include('salesheader.php');
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class='main'>
<a href="#" id="folder"><i class="fa fa-folder"></i></a>
<a href="#" id="close"><i class="fa fa-close"></i></a>
	<h2 style='font-family:bebasneue'>Cost of Goods Sold</h2>
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
	<br>
	<div class='row' style='text-align:center'>
		<div class='col-sm-1'>
			1.
		</div>
		<div class='col-sm-4'>
			<input type='text' class='form-control' id='reference1' name='reference1'>
		</div>
		<div class='col-sm-3'>
			<input type='number' class='form-control' id='quantity1' name='quantity1'>
		</div>
		<div class='col-sm-2' id='price_hpp1'>
		</div>
	</div>
	<div id='input_list'></div>
	<hr>
	<button type='button' class='btn btn-secondary' id='check_item_button'>Calculate</button>
	<button type='button' class='btn btn-default' id=''>Calculate</button>
</div>
<script>
	var i;
	var a = 2;
	$("#folder").click(function (){	
		$("#input_list").append(
		'<div class="row" style="padding-top:10px;text-align:center" id="barisan'+a+'">'+
		'<div class="col-sm-1">' + a + '</div>'+
		'<div class="col-sm-4"><input id="reference'+a+'" name="reference'+a+'" class="form-control" style="width:100%"></div>'+
		'<div class="col-sm-3"><input id="quantity'+a+'" name="quantity'+a+'" class="form-control" style="width:100%"></div>'+
		'<div class="col-sm-2" id="price_hpp' + a + '"></div>' + 
		'</div>').find("input").each(function () {
			});
		$("#reference" + a).autocomplete({
			source: "ajax/search_item.php"
		 });
		a++;
	});

	$("#close").click(function () {
		if(a>2){
		a--;
		x = 'barisan' + a;
		$("#"+x).remove();
		} else {
			return false;
		}
	});
	$('#check_item_button').click(function(){
		var item = 1;
		$('input[id^="reference"]').each(function(){
			$.ajax({
				url:"Ajax/check_item_available.php",
				data:{
					reference: $(this).val(),
				},
				type:"POST",
				success:function(result){
					if(result == 1){
						item++;
						alert('Please insert correct reference');
						return false;
					}
				}
			})
		})
		console.log(item);
		if(item == 1){
			$('input[id^="reference"]').each(function(){
				var quantity = $(this).parent().siblings().find('input[id^="quantity"]').val();
				if(quantity <= 0 || quantity == ''){
					alert('Please input valid quantity!');
				}
			// $.ajax{(
				// url: 'Ajax/check_stock.php';
			// })
			});
		}
	});
</script>