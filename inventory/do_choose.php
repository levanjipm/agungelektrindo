<?php
	include("inventoryheader.php")
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script> 
$( function() {
	$('#so_id').autocomplete({
		source: "Ajax/search_so.php"
	 })
});
</script>
<style>
.box_do{
	padding:100px 30px;
	box-shadow: 3px 3px 3px 3px #888888;
}
.icon_wrapper{
	position:relative;
}
</style>
	<div class="main">
		<form id="exist_form" action="do_exist_dasboard.php" method="POST">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4 box_do" style='text-align:center'>
					<div class='icon_wrapper'>
						<h1><i class="fa fa-file-text" aria-hidden="true"></i></h1>
					</div>
					<label>Insert Sales Order number</label>
					<input type="text" class="form-control" name="so_id" id="so_id">
					<br><br>
					<button class="btn btn-success" type="submit">Next</button>
					<button class="btn btn-primary" type="button" onclick="go_back()">Back</button>
				</div>
			</div>
		</form>
	</div>
</body>