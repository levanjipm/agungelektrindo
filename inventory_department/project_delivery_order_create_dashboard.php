<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<script>
	$(document).ready(function(){
		$('#reference1').autocomplete({
			source: "ajax/search_item.php"
		})
	});
</script>
<head>
	<title>Create project delivery order</title>
</head>
<div class='main'>
	<h2 style='font-family:Bebasneue'>Project Delivery Order</h2>
	<p style='font-family:museo'>Create project delivery order</p>
	<hr>
	<form action='project_delivery_order_create_validation' method='POST' id='project_form'>
		<label>Date</label>
		<input type='date' class='form-control' name='date' id='date'>
		<label>Project</label>
		<select class='form-control' name='project_id' id='projects'>
			<option value=''>-- Please select a project --</option>
<?php
	$sql_project 	= "SELECT id, project_name FROM code_project WHERE isdone = '0' AND major_id = '0'";
	$result_project = $conn->query($sql_project);
	while($project 	= $result_project->fetch_assoc()){
		$major_id	= $project['id'];
		$name		= $project['project_name'];
?>
			<option value='<?= $major_id ?>' style='font-weight:bold'><?= $name ?></option>
<?php
		$sql_project_minor				= "SELECT id, project_name FROM code_project WHERE major_id = '$major_id' AND isdone = '0'";
		$result_project_minor			= $conn->query($sql_project_minor);
		if(mysqli_num_rows($result_project_minor) > 0){
			while($project_minor		= $result_project_minor->fetch_assoc()){
				$minor_id				= $project_minor['id'];
				$name					= $project_minor['project_name'];
?>
			<option value='<?= $minor_id ?>'><?= $name ?></option>
<?php
			}
		}
	}
?>
		</select>
		<br>
		<button type='button' class='button_default_dark' id='add_item_button'>Add item</button>
		<br><br>
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
					<td><button type='button' class='button_danger_dark' style='visibility:hidden'><i class='fa fa-trash'></i></button></td>
				</tr>
			</tbody>
		</table>
		<button type='button' class='button_default_dark' id='proceeding'>Proceed</button>
	</form>
</div>
<script>
	var a = 2;
	var i;
	
	$('#add_item_button').click(function(){
		$('#project_delivery_order_table').append(
			"<tr id='tr-" + a + "'>"+
			"<td><input type='text' class='form-control' id='reference" + a + "' name='reference[" + a + "]'></td>"+
			"<td><input type='text' class='form-control' id='quantity" + a + "' name='quantity[" + a + "]'></td>"+
			"<td><button type='button' class='button_danger_dark' onclick='delete_row(" + a + ")'><i class='fa fa-trash'></i></button></td>"+
			"</tr>"
		)
		
		$('#reference' + a).autocomplete({
			source: "ajax/search_item.php"
		})
		
		a++;
		
	});
	
	function delete_row(n){
		$('#tr-' + n).remove();
	}
	
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
		