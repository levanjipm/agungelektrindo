<?php
	include("accountingheader.php")
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script>
$( function() {
	$('#sj').autocomplete({
		source: "ajax/search_do.php"
	 })
});
</script>
<style type='text/css'>
html,body { height: 95%; margin: 0px; padding: 0px;overflow-x:hidden;overflow-y:hidden;background-color:#111 }
#full { height: 100% }
#container_invoice {top:40%;position:absolute;background: rgba(64, 64, 64, 0.5);padding:20px;border-radius:20px}
</style>
<div class="main" style="background-image: url('../universal/accounting.jpg');height:100%;padding0px;width:90%">
	<div id="full">
		<div class="row" style="padding:0px;height:100%;margin:0px">
			<div class="col-lg-5 offset-lg-5" >
				<form style="padding:0px;margin:0px;width:100%" method="POST" action="build_invoice.php">
					<div class="container" id="container_invoice">
						<h2 style="color:white">Invoicing</h2>
						<label style="color:white">Insert Delivery Order Number:</label>
						<input placeholder="SJ-AE-XX.XX-XX-XX" class="form-control" style="width:50%" id="sj" name='sj' required>
						<br>
						<button type="submit" class="btn btn-success">Proceed</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
function validateForm() {
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  for (i = 0; i < y.length; i++) {
    if (y[i].value == "") {
      y[i].className += " invalid";
      valid = false;
    }
  }
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid;
}

function fixStepIndicator(n) {
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  x[n].className += " active";
}

</script>