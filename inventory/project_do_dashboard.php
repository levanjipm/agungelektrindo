<?php
	include('inventoryheader.php');
?>
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<script>
	$(document).ready(function(){
		$('#reference1').autocomplete({
			source: "ajax/search_item.php"
		})
	});
	</script>
<div class='main'>
<a href="#" id="folder"><i class="fa fa-folder"></i></a>
<a href="#" id="close"><i class="fa fa-close"></i></a>
	<h2 style='font-family:Bebasneue'>Project Delivery Order</h2>
	<p>Create project delivery order</p>
	<hr>
	<div class='row'>
		<div class='col-sm-10'>
		<form action='project_do_validation.php' method='POST' id='project_form'>
		<label>Date</label>
		<input type='date' class='form-control' name='date' id='date'>
		<label>Project</label>
		<select class='form-control' name='project_id' id='projects'>
			<option value=''>-- Please select a project --</option>
<?php
	$sql_project = "SELECT * FROM code_project WHERE isdone = '0'";
	$result_project = $conn->query($sql_project);
	while($project = $result_project->fetch_assoc()){
?>
			<option value='<?= $project['id'] ?>'><?= $project['project_name'] ?></option>
<?php
	}
?>
		</select>
				<div class='row' style='padding-top:30px'>
					<div class='col-sm-1'>No.</div>
					<div class='col-sm-4'>Reference</div>
					<div class='col-sm-3'>Quantity</div>
				</div>
				<hr>
				<div class='row'>
					<div class='col-sm-1'>
						1
					</div>
					<div class='col-sm-4'>
						<input name='reference1' id='reference1' class='form-control'>
					</div>
					<div class='col-sm-3'>
						<input name='quantity1' id='quantity1' class='form-control'>
					</div>
				</div>
				<div id="input_list">
				</div>
				<hr>
				<input type='hidden' value='1' id='jumlah' name='jumlah'>
				<button type='button' class='btn btn-default' id='proceeding'>Proceed</button>
			</form>
		</div>
	</div>
</div>
<script>
	function check_duplicate(){
		var arr = [];
		var duplicate = false;
		$('input[id^="reference"]').each(function(){
			var value = $(this).val();
			if (arr.indexOf(value) == -1){
				arr.push(value);
			} else {
				duplicate = true;
			}
		});
		return duplicate;
	}
	var i;
	var a = 2;
	$("#folder").click(function (){	
	$("#input_list").append(
	'<div class="row" style="padding-top:10px" id="barisan'+a+'">'+
	'<div class="col-sm-1">'+a+'</div>'+
	'<div class="col-sm-4"><input id="reference'+a+'" name="reference'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-sm-3">'+'<input id="quantity'+a+'" name="quantity'+a+'" class="form-control" style="width:100%"></div>'+
	'</div>').find("input").each(function () {
	});
	$("#reference" + a).autocomplete({
		source: "ajax/search_item.php"
	});
	$('#jumlah').val(a);
	a++;
	});

	$("#close").click(function () {
		if(a>2){
			a--;
			$('#jumlah').val(a-1);			
			x = 'barisan' + a;
			$("#"+x).remove();
		} else {
			return false;
		}
	});
	$('#proceeding').click(function(){
		var duplicate = check_duplicate();
		if($('#projects').val() == ''){
			alert('Please select a valid project!');
			$('#projects').focus();
			return false;
		} else if($('#date').val() == ''){
			alert('Please insert date');
			$('#date').focus();
			return false;
		} else if(duplicate){
			alert('Cannot insert duplicate reference');
			return false;
		} else {
			$('#project_form').submit();
		}
	});
</script>
		