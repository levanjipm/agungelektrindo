<?php
	include("purchasingheader.php");
	include('../Codes/connect.php');
?>
<div class="main">
	<div class="container" style="right:50px">
	<h2>Item</h2>
	<h4 style="color:#444">Add new item</h4>
	<hr>
	<br>
		<form id="inputitem" method="POST" action="additem.php">
			<div class="row">
				<div class="col-sm-12">
					<label for="name">Item Name</label>
					<input type="text" id="itemreff" class="form-control" placeholder="Item reference..." name="itemreff" required id="first" autofocus></input>
				</div>
				<div class='col-sm-3'>
					<label>Type</label>
					<select class='form-control' name='type'>
						<option value='0'>Please select a type</option>
<?php
	$sql_brand = "SELECT DISTINCT type FROM itemlist WHERE type <> '' ORDER BY type ASC";
	$result_brand = $conn->query($sql_brand);
	while($brand = $result_brand->fetch_assoc()){
?>
						<option value='<?= $brand['type'] ?>'><?= $brand['type'] ?></option>
<?php
	}
?>
					</select>
				</div>
				<div class="col-sm-12">
					<label for="name">Item Description</label>
					<input type="textarea" id="itemdescs" class="form-control" style="height:100px" rows="3" name="itemdescs" placeholder="Item description..." required></input>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12" style="padding:10px">	
					<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" id="submitbutton">Submit Item</button>
				</div>
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
								<button type="submit" class="btn btn-success">Proceed</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
$(document).ready(function(){
	$('input[name=itemreff]').focus()
});

$('#submitbutton').click(function() {
	$('#itemref').text($('#itemreff').val());
	$('#itemdesc').text($('#itemdescs').val());
});
</script>
</body>
</html>