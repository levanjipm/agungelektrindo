<?php
	include("salesheader.php");
?>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
<div class="main">
<style>
	.alert_wrapper{
		position:fixed;
		top:20px;
		z-index:105;
	}
</style>
	<div class='alert_wrapper'>
		<div class="alert alert-success" id='alert_change' style='display:none'>
			<strong>Success!</strong> Update successful!
		</div>
		<div class="alert alert-info" id='alert_no' style='display:none'>
			<strong>Info!</strong> There was no change detected.
		</div>
		<div class="alert alert-warning" id='alert_failed' style='display:none'>
			<strong>Info!</strong> There was no change detected.
		</div>
	</div>
	<div class='row' style='top:0'>
		<div class='col-sm-1' style='background-color:#fff'>
		</div>
		<div class='col-sm-10'>
			<h2 style='font-family:bebasneue'>Customer</h2>
			<p>Edit customer data</p>
			<hr>
			<label>Search</label>
			<input type='text' class='form-control' id='customer_filter' placeholder='Search customer here'>
			<script>
				$(document).ready(function(){
					$("#customer_filter").on("keyup", function() {
						var value = $(this).val().toLowerCase();
						$("#edititemtable tr").filter(function() {
							$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
						});
					});
				});
			</script>
			<hr>
			<div class="row">
				<div class="col-lg-12">
					<?php
						$sql = "SELECT * FROM customer ORDER BY name";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
					?>
					<table id="edititemtable" style="width:100%">
						<tr>
							<td style="text-align:center"><strong>Name</strong></td>
							<td style="text-align:center"><strong>Address</strong></td>
							<td></td>
							<td></td>
						</tr>
					<?php
						$i = 1;
						while($row = mysqli_fetch_array($result)) {
					?>
						<tr>
							<td><?= $row['name']?></td>
							<td><?= $row['address']?></td>
							<td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal-<?=$row['id']?>">Edit</td>
							<td>
								<button type='button' class='btn btn-success' onclick='view_customer(<?= $row['id'] ?>)'>View</button>
								<form action='customer_view.php' method='POST' id='view_customer_form<?= $row['id'] ?>'>
									<input type='hidden' value='<?= $row['id'] ?>' name='customer' readonly>
								</form>
								<script>
									function view_customer(n){
										$('#view_customer_form' + n).submit();
									};
								</script>
							</td>
						</tr>
						
						<div class="modal" id="myModal-<?= $row['id'] ?>" role="dialog">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Input Supplier Data</h4>
									</div>
									<div class="modal-body">
										<label for="name">Company: </label>
										<input class="form-control" for="name" id='namaperusahaan<?= $row['id'] ?>' value="<?=$row['name']?>">
										<label for="name" >Address: </label>
										<input class="form-control" id="address<?= $row['id'] ?>" value="<?=$row['address']?>">
										<label for="name" >NPWP: </label>
										<input class="form-control" for="name" id="npwp<?= $row['id'] ?>" value="<?=$row['npwp']?>" id='npwp<?= $i ?>' oninput='liat_npwp(<?= $i ?>)'>
										<label for="name" >Person in Charge: </label>
										<div class="input-group">
											<select  name="prefix" id="prefix<?= $row['id'] ?>" onclick="disable()" class="form-control" style='width:20%'>
												<option value="Bapak" <?php if($row['prefix'] == 'Bapak') echo 'selected' ?>>Bapak</option>
												<option value="Ibu" <?php if($row['prefix'] == 'Ibu') echo 'selected' ?>>Ibu</option>
											</select>
											<div class="input-group-append">
												<input class="form-control" for="name" id="pic<?= $row['id'] ?>" value="<?=$row['pic']?>">
											</div>
										</div>
										<label for="name" >Phone number: </label>
										<input class="form-control" for="name" id="phone<?= $row['id'] ?>" value="<?=$row['phone']?>" required>
										</input>
										<label for="name" >City: </label>
										<input class="form-control" for="name" id="city<?= $row['id'] ?>" value="<?=$row['city']?>" required>
										</input>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal" id='close_modal<?= $row['id'] ?>'>Close</button>
										<button type="button" class="btn btn-success" onclick='submit(<?= $row['id'] ?>)'>Edit</button>
									</div>
								</div>
							</div>
						</div>
					<?php
						$i++;
					}
					?>
					</table>
					<?php
					} else {
						echo "0 results";
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<script>
	$("input[id^=npwp]").inputmask("99.999.999.9-999.999");
	
	function submit(n){
		$('#close_modal' + n).click();
		$.ajax({
			url:"editcustomer.php",
			data:{
				id : n,
				namaperusahaan : $('#namaperusahaan' + n).val(),
				address : $('#address' + n).val(),
				npwp: $('#npwp' + n).val(),
				prefix: $('#prefix' + n).val(),
				pic : $('#pic' + n).val(),
				phone: $('#phone' + n).val(),
				city: $('#city' + n).val(),
			},
			success:function(response){
				if(response == 0){
					$('#alert_no').fadeIn();
					setTimeout(function(){
						$('#alert_no').fadeOut();
					},1000);
				} else if(response == 1){
					$('#alert_change').fadeIn();
					setTimeout(function(){
						$('#alert_change').fadeOut();
					},1000);
				} else if(response == 2){
					$('#alert_failed').fadeIn();
					setTimeout(function(){
						$('#alert_failed').fadeOut();
					},1000);
				}
			},
			type:"POST",
		})
	}
</script>
