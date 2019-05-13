<?php
	include('salesheader.php');
?>
	<div class="main">	
		<form method="POST" action="return_validation.php">
			<label>Insert the delivery order to be return</label>
			<input type="text" class="form-control" name="do" required>
			<br>
			<button class="btn btn-warning">Proceed</button>
		</form>
	</div>
<?php
	if(empty($_GET['alert'])){
	} else if($_GET['alert'] == 1) {
?>
		<script>
			alert('Delivery order not found');
		</script>
<?php
	} else if($_GET['alert'] == 2){
?>
		<script>
			alert('Other reason must be filled');
		</script>
<?php	
	}
?>