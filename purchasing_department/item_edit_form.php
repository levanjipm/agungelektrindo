<?php
	include('../codes/connect.php');
	$item_id		= $_POST['item_id'];
	$sql_item		= "SELECT * FROM itemlist WHERE id = '$item_id'";
	$result_item	= $conn->query($sql_item);
	$item			= $result_item->fetch_assoc();
?>
	<input type='hidden' value='<?= $item_id ?>' id='id'>
	<h2 style='font-family:bebasneue'>Edit item form</h2>
	<label>Reference</label>
	<input type='text' class='form-control' value='<?= $item['reference'] ?>' id='reference'>
	<label>Description</label>
	<textarea class='form-control' style='resize:none' rows='3' id='description'><?= $item['description'] ?></textarea>
	<label>Type</label>
	<select class='form-control' id='type'>
<?php
	$sql_type		= "SELECT * FROM itemlist_category";
	$result_type	= $conn->query($sql_type);
	while($type		= $result_type->fetch_assoc()){
		if($type['id'] ==  $item['type']){
			$selected 	= 'selected';
		} else {
			$selected	= '';
		}
?>
		<option value='<?= $type['id'] ?>' <?= $selected ?>><?= $type['name'] ?></option>
<?php
	}
?>
	</select>
	<br>
	<button type='button' class='button_success_dark' id='submit_change_button'>Submit</button>
	<script>
		$('#submit_change_button').click(function(){
		$.ajax({
			url: 'item_edit.php',
			data: {
				reference : $('#reference').val(),
				description : $('#description').val(),
				type : $('#type').val(),
				id : $('#id').val(),
			},
			type: "POST",
			success:function(){
				$('#button_edit_form_close').click();
			}
		});
	});
	</script>