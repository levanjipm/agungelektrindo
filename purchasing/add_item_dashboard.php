<?php
	include("purchasingheader.php");
?>
<style>
	.alert_wrapper{
		position:absolute;
		z-index:55;
		left:50%;
	}
	
	.validation_wrapper{
		position:fixed;
		z-index:40;
		top:0;
		left:0;
		background-color:rgba(30,30,30,0.8);
		display:none;
		width:100%;
		height:100%;
	}
	
	.validation_box{
		position:absolute;
		top:10%;
		left:10%;
		width:80%;
		height:80%;
		min-height:300px;
		background-color:white;
		overflow-y:scroll;
		padding:20px;
	}
	
	.validation_close_button{
		position:absolute;
		top:10%;
		left:10%;
		background-color:transparent;
		border:none;
		outline:none;
		color:#333;
		z-index:41;
	}
</style>
<div class="main">
	<div class='alert_wrapper'>
		<div class="alert alert-success" id='success_alert' style='display:none'>
			<strong>Success!</strong> Successfully add item.
		</div>
		<div class="alert alert-warning" id='exist_alert' style='display:none'>
			<strong>Info</strong> We found an exact same reference. Aborting operation.
		</div>
		<div class="alert alert-danger" id='failed_alert' style='display:none'>
			<strong>Danger</strong> Failed to add item.
		</div>
	</div>
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
			<textarea id="description" class="form-control" style="height:100px;resize:none" rows="3" placeholder="Item description..." required></textarea>
			<br>
			<button type="button" class="button_default_dark" id="submit_item_button">Submit Item</button>	
		</div>
	</div>
</div>
<div class='validation_wrapper'>
	<form id="inputitem" method="POST" action="additem.php">
		<button type='button' class='validation_close_button' id='close_wrapper_button'>X</button>
		<div class='validation_box'>
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
	</form>
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
			$('.validation_wrapper').fadeIn();
			$('#reference_validation').html($('#reference').val());
			$('#type_validation').html($('#item_type option:selected').text());
			$('#description_validation').html($('#reference').val());
		}
	});
	
	$('.validation_close_button').click(function(){
		$('.validation_wrapper').fadeOut();
	});
	
	$('#add_item_button').click(function(){
		$.ajax({
			url:'add_item.php',
			data:{
				reference : $('#reference').val(),
				description : $('#description').val(),
				user : <?= $_SESSION['user_id'] ?>,
				type : $('#item_type').val(),
			},
			type:"POST",
			success:function(response){
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