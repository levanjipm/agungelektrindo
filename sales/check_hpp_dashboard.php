<?php
	include('salesheader.php');
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class='main'>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "ajax/search_item.php"
	 })
});
</script>
<a href="#" id="folder"><i class="fa fa-folder"></i></a>
<a href="#" id="close"><i class="fa fa-close"></i></a>
	<h2 style='font-family:bebasneue'>Cost of Goods Sold</h2>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th></th>
		</tr>
		<tbody>
	<div class='row' style='text-align:center'>
		<div class='col-sm-1'>
			No.
		</div>
		<div class='col-sm-4'>
			Reference
		</div>
	</div>
	<br>
	<form action='check_hpp.php' method='POST' id='check_hpp_form'>
		<div class='row' style='text-align:center'>
			<div class='col-sm-1'>
				1.
			</div>
			<div class='col-sm-4'>
				<input type='text' class='form-control' id='reference1' name='reference[1]'>
			</div>
		</div>
		<div id='input_list'></div>
		<hr>
	</form>
	<button type='button' class='btn btn-secondary' id='check_item_button'>Calculate</button>
</div>
<script>
	var i;
	var a = 2;
	$("#folder").click(function (){	
		$("#input_list").append(
		'<div class="row" style="padding-top:10px;text-align:center" id="barisan'+a+'">'+
		'<div class="col-sm-1">' + a + '</div>'+
		'<div class="col-sm-4"><input id="reference'+a+'" name="reference['+a+']" class="form-control" style="width:100%"></div>'+
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
		var arr = [];
		var duplicate = 1;
		$("input").each(function(){
			var value = $(this).val();
			if (arr.indexOf(value) == -1){
				arr.push(value);
			} else{
				alert('Duplicate detected!');
				duplicate++;
				return false;
			}
		});
		if(duplicate == 1){
			$('#check_hpp_form').submit();
		}
	});
</script>