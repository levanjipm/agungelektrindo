<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
?>
<head>
	<title>Add item</title>
</head>
<div class='main'>
	<div class='row'>
		<div class='col-sm-12'>
			<h2 style='font-family:bebasneue'>Item</h2>
			<p>Add new item</p>
			<hr>
			<label for="name">Item Name</label>
			<input type="text" id="reference" class="form-control" placeholder="Item reference..." name="reference" required autofocus></input>
			<label>Type</label>
			<select class='form-control' id='item_type' style='width:50%'>
				<option value='0'>Please select a type</option>
<?php
	$sql_brand 		= "SELECT id,name FROM itemlist_category ORDER BY name ASC";
	$result_brand 	= $conn->query($sql_brand);
	while($brand 	= $result_brand->fetch_assoc()){
?>
				<option value='<?= $brand['id'] ?>'><?= $brand['name'] ?></option>
<?php
	}
?>
			</select>
			<label for="name">Item Description</label>
			<textarea id="description" class="form-control" style="resize:none" rows="3" placeholder="Item description..." required></textarea>
			<br>
			<button type="button" class="button_default_dark" id="submit_item_button">Submit Item</button>	
		</div>
	</div>
</div>
<div class='full_screen_wrapper'>
	<button type='button' class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
		<h2 style='font-family:bebasneue'>Adding new item</h2>
		<table class='table table-bordered'>
			<tr>
				<td>Reference</td>
				<td id='reference_validation'></td>
			</tr>
			<tr>
				<td>Item description</td>
				<td id='description_validation'></td>
			</tr>
			<tr>
				<td>Type</td>
				<td id='type_validation'></td>
			</tr>
		</table>
		<button type='button' class='button_success_dark' id='add_item_button'>Submit</button>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#reference').focus()
	});

	$('#submit_item_button').click(function() {
		if($('#reference').val() == ''){
			alert('Please insert correct reference');
			$('#reference').focus();
			return false;
		} else if($('#description').val() == ''){
			alert('Please insert correct description');
			$('#description').focus();
			return false;
		} else if($('#item_type').val() == 0){
			alert('Please insert valid item type');
			return false;
		} else {
			$('.full_screen_wrapper').fadeIn();
			$('#reference_validation').html($('#reference').val());
			$('#type_validation').html($('#item_type option:selected').text());
			$('#description_validation').html($('#description').val());
		}
	});
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#add_item_button').click(function(){
		$.ajax({
			url:'item_add.php',
			data:{
				reference : $('#reference').val(),
				description : $('#description').val(),
				user : <?= $_SESSION['user_id'] ?>,
				type : $('#item_type').val(),
			},
			type:"POST",
			success:function(response){
				$('.full_screen_wrapper').fadeOut();
				if(response == 0){
					$('#exist_alert').fadeIn();
					setTimeout(function(){
						$('#exist_alert').fadeOut();
					},1000);
					$('#reference').focus();
				} else if(response == 1){
					$('#success_alert').fadeIn();
					setTimeout(function(){
						$('#success_alert').fadeOut();
					},1000);
					$('#reference').val('');
					$('#type').val(0);
					$('#description').val('');
				} else if(response == 2){
					$('#failed_alert').fadeIn();
					setTimeout(function(){
						$('#failed_alert').fadeOut();
					},1000);
				}
			},
		})
	});
</script>
</body>
</html>