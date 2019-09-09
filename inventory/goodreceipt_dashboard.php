<?php
	include("inventoryheader.php");
?>
<div class="main" style='padding-top:0px'>
	<div class='row' style='height:100%'>
		<div class='col-sm-12'>
			<h2 style=';font-family:bebasneue'>Good receipt</h2>
			<p>Create new good receipt</p>
			<hr>
			<form id="goodreceipt" method="POST" action="goodreceipt.php">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<label>Supplier</label>
						<select class="form-control" name="supplier" id="supplier" onclick="disable()">
							<option id="kosong">Please Select a supplier--</option>
<?php
	$sql = "SELECT id,name FROM supplier ORDER BY name ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = mysqli_fetch_array($result)) {
		echo '<option value="' . $row["id"] . '">'. $row["name"].'</option> ';
		}
	}
?>
						</select>
						<label for="name">Purchase Order number</label>
						<select class="form-control" name="po" id="po">
							<option id="kosong">--Pelase select a purchase order to receive--</option>
						</select>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-0 col-xs-offset-0">
						<label for="date">Tanggal Surat Jalan</label>
						<input type="date" class="form-control" required name="date"></input>
					</div>
				</div>
				<br>
				<button type="submit" href="goodreceipt.php" class="button_default_dark">View Uncompleted Items</button>
			</form>
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
			url: "Ajax/search_incomplete_po.php",
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