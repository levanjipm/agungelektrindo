<?php
	include ("salesheader.php");
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script type="text/javascript" src="scripts/createquotation.js"></script>
<script>
$( function() {
	$('#customer').autocomplete({
		source: "search_customer.php"
	 })
});
function disable_year(){
	document.getElementById("kosong").disabled = true;
	buka();
}
</script>
<body>
<div class="main">
	<div class="row">
		<div class="col-lg-12" style="background-color:#ddd;padding:20px">
			<form action="search_quotation.php" method="POST" id="search_quotation">
				<h3>Search quotation</h3>
				<h4>This search support for reference and reference search</h4>
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
					<input type="text" id="customer" name="search" class="form-control" placeholder="Search here" required>
				</div>
				<br>
				<div class="row">
					<div class="col-lg-6">
						<button type="submit" class="btn btn-success">Search</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
<script>
function lihat(){
	if($('#year').val() == 0){
		alert("Please insert a valid year");
	} else if($('#month').val() == 0){
		alert("Please insert a valid month");
	} else if($('#customer').val() == 0){
		alert('Please insert a customer');
	} else {
		$('#search_quotation').submit();
}};
</script>
