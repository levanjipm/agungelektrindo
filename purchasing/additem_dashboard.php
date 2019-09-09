<?php
	include("purchasingheader.php");
?>
<style>
	.alert_wrapper{
		position:absolute;
		z-index:55;
		left:50%;
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
	<div class='col-sm-10'>
		<h2 style='font-family:bebasneue'>Item</h2>
		<p>Add new item</p>
		<hr>
		<form id="inputitem" method="POST" action="additem.php">
			<label for="name">Item Name</label>
			<input type="text" id="itemreff" class="form-control" placeholder="Item reference..." name="itemreff" required autofocus></input>
			<label>Type</label>
			<select class='form-control' name='type' id='type' style='width:50%'>
				<option value='0'>Please select a type</option>
<?php
	$sql_brand = "SELECT id,name FROM itemlist_category ORDER BY name ASC";
	$result_brand = $conn->query($sql_brand);
	while($brand = $result_brand->fetch_assoc()){
?>
				<option value='<?= $brand['id'] ?>'><?= $brand['name'] ?></option>
<?php
	}
?>
			</select>
			<label for="name">Item Description</label>
			<textarea id="itemdescs" class="form-control" style="height:100px" rows="3" name="itemdescs" placeholder="Item description..." required form='inputitem'></textarea>
			<br><button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" id="submitbutton">Submit Item</button>
			<div class="modal" id="myModal" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Add Item</h4>
						</div>
						<div class="modal-body">
							<table class="table">
								<tr>
									<th style="width:20%">Reference</th>
									<td style="width:80%" id="itemref"></td>
								</tr>
								<tr>
									<th style="width:20%">Description</th>
									<td style="width:80%" id="itemdesc"></td>
								</tr>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-success" onclick='add_item()'>Proceed</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#itemreff').focus()
	});

	$('#submitbutton').click(function() {
		if($('#itemreff').val() == ''){
			alert('Please insert correct reference');
			$('#itemreff').focus();
			return false;
		} else if($('#itemdescs').val() == ''){
			alert('Please insert correct description');
			$('#itemdescs').focus();
			return false;
		} else {
			$('#myModal').modal('hide');
			$('#itemref').text($('#itemreff').val());
			$('#itemdesc').text($('#itemdescs').val());
		}
	});
	
	function add_item(){
		if($('#itemreff').val() == '' || $('#itemdescs').val() == ''){
			$('#myModal').modal('show');
			return false;
		} else {
			$.ajax({
				url:'additem.php',
				data:{
					reference : $('#itemreff').val(),
					description : $('#itemdescs').val(),
					user : <?= $_SESSION['user_id'] ?>,
					type : $('#type').val(),
				},
				type:"POST",
				beforeSend: function() {
					$('#myModal').modal('hide');
				},
				success:function(response){
					if(response == 0){
						$('#exist_alert').fadeIn();
						setTimeout(function(){
							$('#exist_alert').fadeOut();
						},1000);
						$('#itemreff').focus();
					} else if(response == 1){
						$('#success_alert').fadeIn();
						setTimeout(function(){
							$('#success_alert').fadeOut();
						},1000);
						$('#itemreff').val('');
						$('#type').val(0);
						$('#itemdescs').val('');
					} else if(response == 2){
						$('#failed_alert').fadeIn();
						setTimeout(function(){
							$('#failed_alert').fadeOut();
						},1000);
					}
				},
			})
		}
	}
</script>
</body>
</html>