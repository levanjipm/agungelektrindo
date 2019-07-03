<?php
	include('salesheader.php');
?>
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<div class='main'>
	<a href="#" id="folder"><i class="fa fa-folder"></i></a>
	<a href="#" id="close"><i class="fa fa-close"></i></a>
	<div class='row'>
		<div class='col-sm-10'>
			<h2 style='font-family:bebasneue'>Sales order</h2>
			<p>Create <strong>Service</strong> sales order</p>
			<hr>
			<div class='row' style='text-align:center'>
				<div class='col-sm-1'>
					No.
				</div>
				<div class='col-sm-3'>
					Service name
				</div>
				<div class='col-sm-4'>
					Description
				</div>
			</div>
			<div class='row' style='text-align:center'>
				<div class='col-sm-1'>
					1
				</div>
				<div class='col-sm-3'>
					<input type='text' class='form-control'>
				</div>
				<div class='col-sm-4'>
					<textarea class='form-control' rows='2'></textarea>
				</div>
				<div class='col-sm-3'>
					<input type='number' class='form-control'>
				</div>
			</div>
			<div id='input_list'></div>
		</div>
	</div>
<script>
var i;
var a=2;

$("#folder").click(function (){	
	$("#input_list").append(
	'<div class="row" style="padding-top:10px" id="barisan'+a+'">'+
	'<div class="col-sm-1"><input class="nomor" value="'+a+'" style="width:40%" style="text-align:center"></input></div>'+
	'<div class="col-sm-3"><input style="overflow-x:hidden" id="qty'+a+'"" class="form-control" style="width:100%" name="qty'+a+'"></div>'+
	'<div class="col-sm-4"><textarea id="reference'+a+'" class="form-control" rows="2"></textarea></div>'+
	'<div class="col-sm-3"><input class="form-control" name="quantity'+a+'"></div>'+
	'</div>').find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
	source: "search_item.php"
	 });
	a++;
});
</script>