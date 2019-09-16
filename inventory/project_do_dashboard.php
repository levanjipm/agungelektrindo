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
				<br>
				<table class='table table-bordered'>
					<tr>
						<th>Reference</th>
						<th>Quantity</th>
						<th></th>
					</tr>
					<tbody id='project_delivery_order_table'>
						<tr>	
							<td><input name='reference[1]' id='reference1' class='form-control'></td>
							<td><input name='quantity[1]' id='quantity1' class='form-control'></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<button type='button' class='button_default_dark' id='proceeding'>Proceed</button>
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
	"<tr id='tr-" + a + "'>"+
	"<td>
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
		