<?php
	include('../codes/connect.php');
	$transaction_id			= $_POST['transaction_id'];
	$sql					= "SELECT * FROM petty_cash WHERE id = '$transaction_id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
	
	$info					= $row['info'];
	$value					= $row['value'];
	$date					= $row['date'];
	
	$petty_class			= $row['class'];
?>
<h3 style='font-family:bebasneue'>Edit transaction data</h3>
<label>Transaction detail</label>
<input type='date' class='form-control' id='date' value='<?= $date ?>'>

<label>Value</label>
<input type='number' class='form-control' id='value' value='<?= $value ?>'>

<label>Description</label>
<textarea class='form-control' id='description' style='resize:none'><?= $info ?></textarea>

<label>Classification</label>
<select class='form-control' id='class'>
<?php
	$sql_class				= "SELECT * FROM petty_cash_classification WHERE major_id = '0'";
	$result_class			= $conn->query($sql_class);
	while($class			= $result_class->fetch_assoc()){
		$class_id			= $class['id'];
		$class_name			= $class['name'];
?>
	<option value='<?= $class_id ?>' <?php if($petty_class == $class_id){ echo 'selected'; } ?>  style=;'font-weight:bold'><?= $class_name ?></option>
<?php
		$sql_sub_class		= "SELECT * FROM petty_cash_classification WHERE major_id = '$class_id'";
		$result_sub_class	= $conn->query($sql_sub_class);
		while($sub_class	= $result_sub_class->fetch_assoc()){
			$sub_class_id	= $sub_class['id'];
			$sub_class_name	= $sub_class['name'];
?>
	<option value='<?= $sub_class_id ?>' <?php if($petty_class == $sub_class_id){ echo 'selected'; } ?>><?= $sub_class_name ?></option>
<?php
		}
	}
?>
</select>
<br>
<button type='button' class='button_success_dark' id='reset_transaction_button'><i class='fa fa-long-arrow-right'></i></button>
<script>
	$('#reset_transaction_button').click(function(){
		if($('#value').val() == '' || $('#value').val() == 0){
			alert('Please insert value!');
			$('#value').focus();
			return false;
		} else if($('#date').val() == ''){
			alert('Please insert date');
			$('#date').focus();
			return false;
		} else {
			$.ajax({
				url:'reset_petty_input.php',
				data:{
					date:$('#date').val(),
					transaction_id:<?= $transaction_id ?>,
					info:$('#description').val(),
					classification:$('#class').val(),
					value:$('#value').val(),
				},
				type:'POST',
				success:function(){
					$('.full_screen_close_button').click();
					$('#search_button').click();
				}
			});
		}
	});
</script>