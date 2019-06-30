<?php
	include("inventoryheader.php");
?>
<div class="main" style='padding-top:0px'>
	<div class='row' style='height:100%'>
		<div class='col-sm-1' style='background-color:#ddd'>
		</div>
		<div class='col-sm-10'>
			<h2 style=';font-family:bebasneue'>Delivery Order</h2>
			<p>Create delivery order</p>
			<hr>
			<form id="goodreceipt" method="POST" action="goodreceipt.php">
				<div class="row">
					<div class="col-lg-6">
						<label for="name">Supplier</label>
						<select class="form-control" name="supplier" id="supplier" onclick="disable()">
							<option id="kosong">Please Select a supplier--</option>
<?php
	$sql = "SELECT id,name FROM supplier ORDER BY name ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = mysqli_fetch_array($result)) {
		echo '<option value="' . $row["id"] . '">'. $row["name"].'</option> ';
		}
	} else {
		echo "0 results";
	}
?>
						</select>
						<label for="name">Purchase Order number</label>
						<select class="form-control" name="po" id="po">
							<option id="kosong">--Pelase select a purchase order to receive--</option>
						</select>
					</div>
					<div class="col-lg-3 offset-lg-3">
						<label for="date">Tanggal Surat Jalan</label>
						<input type="date" class="form-control" required name="date"></input>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3" style="padding:10px">
						<button type="submit" href="goodreceipt.php" class="btn btn-primary">View Uncompleted Items</button>
					</div>
				</div>
			</form>
		</div>
		<div class='col-sm-1' style='background-color:#ddd'>
		</div>
	</div>
</div>
<script>
function disable(){
	document.getElementById("kosong").disabled = true;
}
$(document).ready(function() {
	$("#supplier").change(function(){
		var options = {
			url: "Ajax/requestfilter.php",
			type: "POST",
			data: {id:$('#supplier').val()},
			success: function(result){
				$("#po").html(result);
			}};
		$.ajax(options);
	});
});
</script>
</body>
</html>