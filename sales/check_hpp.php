<?php
	include('salesheader.php');
	$i = 1;
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Cost of Goods Sold</h2>
	<hr>
	<div class='row' style='text-align:center'>
		<div class='col-sm-3'>
			Reference
		</div>
		<div class='col-sm-4'>
			Quantity
		</div>
	</div>
	<hr>
	<form action='check_hpp_view.php' method='POST'>
<?php
	$reference_array = $_POST['reference'];
	function array_has_dupes($array) {
		$duplicate = false;
		if(count($array) !== count(array_unique($array))){
			$duplicate = true;
		}
		return $duplicate;
	};
	$duplicate_array = array_has_dupes($reference_array);
	if($duplicate_array == false){
		foreach ($reference_array as $reference) {
			$sql_stock  = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC";
			$result_stock = $conn->query($sql_stock);
			$stock = $result_stock->fetch_assoc();
			$stock_ = $stock['stock'];
			if($stock_ == NULL || $stock == 0){
			} else {
?>
	<div class='row' style='text-align:center'>
		<div class='col-sm-3'>
			<?= $reference ?>
			<input type='hidden' value='<?= $reference ?>' name='reference_array[<?= $i ?>]'>
		</div>
		<div class='col-sm-4'>
			<div class='input-group'>
				<input type='number' class='form-control' max='<?= $stock_ ?>' name='quantity_array[<?= $i ?>]' style='width:80%'>
				<div class="input-group-append">
					<span class="input-group-text" style='min-width:40px'><strong><?= $stock_ ?></strong></span>
				</div>
			</div>
		</div>
	</div>
	<br>
<?php
			}
			$i++;
		}
	}
?>
	<hr>
	<button type='submit' class='btn btn-secondary' id='calculate_button'>
		Calculate
	</button>
	</form>
<script>
	$(document).ready(function(){
		var height = $('.form-control').outerHeight();
		$('.input-group-append').height(height);
	})
</script>