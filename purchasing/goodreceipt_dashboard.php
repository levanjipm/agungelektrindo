<?php
	include("purchasingheader.php");
?>

<?php
	include("Connect.php")
?>
<div class="main">
	<form id="goodreceipt" method="POST" action="goodreceipt.php">
		<div class="row">
			<div class="col-lg-6">
				<label for="name">Nama Pengirim</label>
				<select class="form-control" name="supplier" id="supplier" onclick="disable()">
					<option id="kosong">Please Select a supplier--</option>
					<?php
						include("connect.php");
						$sql = "SELECT * FROM supplier";
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
				<select class="form-control" name="po" id="po">
					<option id="kosong">--Pelase select a purchase order to receive--</option>
				</select>
			</div>
			<div class="col-lg-2 offset-lg-4"">
				<label for="date">Tanggal Surat Jalan</label>
				<input type="date" class="form-control"></input>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3" style="padding:10px">
				<button type="submit" href="goodreceipt.php" class="btn btn-primary" value="Get Selected Values">View Uncompleted Items</button>
			</div>
		</div>
	</form>
	<div class="container">
</div>
<script>
function disable(){
	document.getElementById("kosong").disabled = true;
}
$(document).ready(function() {
	$("#supplier").change(function(){
		var options = {
			url: "requestfilter.php",
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