<?php
	include('inventoryheader.php');
	if($role == 'superadmin'){
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script>
	$( function() {
		$('#lost_reference').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#found_reference').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#initial_item_de_reference').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#de_1').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#de_2').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#de_3').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#m1').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#m2').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#m3').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#mfinal').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#swal_plus_two').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#swap_plus_one').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#swap_minus_one').autocomplete({
			source: "search_item.php"
		 })
	});
	$( function() {
		$('#swap_minus_two').autocomplete({
			source: "search_item.php"
		 })
	});
</script>
<style>
	.options{
		background-color:#333;
		display:none;
		color:white;
		width:80%;
		margin-left:10%;
		box-shadow: 4px 4px 4px 4px #888888;
	}
</style>
<div class="main">
	<h2 style='font-family:bebasneue'>Event</h2>
	<p>Add event</p>
	<hr>
	<form action="add_event_do.php" method="POST" id="event_form">
		<label>Event type</label>
		<select class="form-control" onchange="select_event()" id="event_selector" name="event_selector">
			<option id="initialize">Select an event to make</option>
<?php
				//Give the event option//
				$sql = "SELECT id,name FROM event";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()){
?>
			<option value="<?= $row['id'] ?>"><?= $row['name']; ?></option>
<?php
				}
?>
		</select>
		<script>
			function select_event(){
				var y = $('#event_selector').val();
				$('#initialize').attr('disabled',true);
				$('.options').hide();
				$('#' + y).show();
			}
		</script>						
		<br><br>
		<div class="row options" id="1">
			<div class="col-sm-4" style='padding:20px'>
				<h3 style='font-family:bebasneue'>Lost goods</h3>
				<p style='font-family:bebasneue'>Use this function is you lost goods</p>
				<br>
			</div>
			<div class="col-sm-8" style='background-color:#eee;padding:20px'>
				<label style='color:#333'>Reference</label>
				<input type="text" class="form-control" Placeholder="Lost Item Reference" id="lost_reference" name="lost_reference">
				<label style='color:#333'>Quanity</label>
				<input type="number" class="form-control" Placeholder="Lost Item Quantity" name="lost_quantity">
				<br>
				<button type="button" class="btn btn-primary" onclick='validate(1)'>Submit Item</button>
			</div>
		</div>
		<div class="row options" id="2">
			<div class="col-sm-4" style='padding:20px'>
				<h3 style='font-family:bebasneue'>Found goods</h3>
				<p style='font-family:bebasneue'>Use this function is you found goods</p>
			</div>
			<div class="col-sm-8" style='background-color:#eee;padding:20px'>
				<label style='color:#333'>Reference</label>
				<input type="text" class="form-control" Placeholder="Found Item Reference" id="found_reference" name="found_reference">
				<label style='color:#333'>Quantity</label>
				<input type="number" class="form-control" Placeholder="Found Item Quantity" name="found_quantity">
				<br>
				<button type="button" class="btn btn-primary" onclick='validate(2)'>Submit Item</button>
			</div>
		</div>
		<div class="row options" id="3">
			<div class="col-sm-12" style='text-align:center'>
				<h3 style='font-family:bebasneue'>De-Materialized</h3>
			</div>
			<div class="col-sm-4 col-sm-offset-4">
				<label>Initial item</label>
				<input type="text" class="form-control" id="initial_item_de_reference" name="initial_item_de_reference">
			</div>
			<div class="col-sm-4">
			</div>
			<div class="col-sm-4 col-sm-offset-4">
				<label>Initial item quantity</label>
				<input type="number" class="form-control" name="initial_item_de_quantity" id='initial_item_de_quantity'>
			</div>
			<div class="col-sm-4">
			</div>
			<div class="col-sm-4">
			<label>Item 1</label>
				<div class="input-group">						
					<input type='text' class='form-control' id="de_1" name="de_1">
					<span class="input-group-addon">+</span>
				</div>
				<label>Input price list</label>
				<input type='number' class='form-control' id='de_pl1' name='de_pl1'>
				<label>First item quantity for <u>each</u> initial item</label>
				<input type='number' class='form-control' name="de_q1" value='1'>
			</div>
			<div class="col-sm-4">
			<label>Item 2</label>
				<div class="input-group">
					<input type='text' class='form-control' id="de_2" name="de_2">
					<span class="input-group-addon">+</span>
				</div>
				<label>Input price list</label>
				<input type='number' class='form-control' id='de_pl2' name='de_pl2'>
				<label>Second item quantity for <u>each</u> initial item</label>
				<input type='text' class='form-control' name="de_q2" value='1'>
			</div>
			<div class="col-sm-4">
				<label>Item 3</label>
				<div class="input-group">
					<input type='text' class='form-control' id="de_3" name="de_3">
					<span class="input-group-addon">+</span>
				</div>
				<label>Input price list</label>
				<input type='number' class='form-control' id='de_pl3' name='de_pl3'>
				<label>Third item quantity for <u>each</u> initial item</label>
				<input type='text' class='form-control' name="de_q3" value='1'>
			</div>
			<div class="col-sm-4" style="padding-top:20px">
				<button type="button" class="btn btn-primary" onclick='validate(3)'>Submit Item</button>
			</div>
		</div>
		<div class="row options" id="4">
			<div class="col-sm-12" style='text-align:center'>
				<h3 style='font-family:bebasneue'>Materialized</h3>
			</div>
			<br>
			<div class="col-sm-4">
			<label>Item 1</label>
				<div class="input-group">						
					<input type='text' class='form-control' name="m1" id="m1">
					<span class="input-group-addon">+</span>
				</div>
				<label>First item quantity</label>
				<input type='text' class='form-control' name="mq1" value='1'>
			</div>
			<div class="col-sm-4">
			<label>Item 2</label>
				<div class="input-group">
					<input type='text' class='form-control' name="m2" id="m2">
					<span class="input-group-addon">+</span>
				</div>
				<label>Second item quantity</label>
				<input type='text' class='form-control' name="mq2" value='1'>
			</div>
			<div class="col-sm-4">
				<label>Item 3</label>
				<div class="input-group">
					<input type='text' class='form-control' name="m3" id="m3">
					<span class="input-group-addon">=</span>
				</div>
				<label>Third item quantity</label>
				<input type='text' class='form-control' name="mq3" value='1'>
			</div>
			<div class="col-sm-4 col-sm-offset-4">
				<label>Final item</label>
				<input type="text" class="form-control" name="mfinal" id="mfinal">
				<label>Final item quantity</label>
				<input type='text' class='form-control' name="mqfinal" value='1'>
			</div>
			<div class="col-sm-4">
			</div>
			<div class="col-sm-4" style="padding-top:20px">
				<button type="button" class="btn btn-primary" onclick='validate(4)'>Submit Item</button>
			</div>
		</div>
		<div class="row options" id='5'>
			<div class='col-sm-12'>
				<div class='row'>
					<div class="col-sm-3">
						<h3 style='font-family:bebasneue'>Swap Items</h3>
					</div>
					<hr>
				</div>
				<div class='row'>
					<div class="col-sm-6">
						<label>Quantity swap</label>
						<input type="number" value="1" placeholder="Swap quantity" class="form-control" name='swapq'>
					</div>
				</div>
				<div class='row'>
					<div class="col-sm-6">
						<label>Decreasing Item</label>
						<div class="input-group">
							<input type='text' class='form-control' id="swap_minus_one" name="swap_minus_one">
							<span class="input-group-addon">-</span>
						</div>
					</div>
					<div class='col-sm-6'>
						<label>Increasing Item</label>
						<div class="input-group">						
							<input type='text' class='form-control' id="swap_plus_one" name="swap_plus_one">
							<span class="input-group-addon">+</span>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-6 col-sm-offset-6'>
						<label>Price list</label>
						<input type='number' value='0' class='form-control' id='price_one' name='price_one'>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-6'>
						<label>Decreasing Item</label>
						<div class="input-group">
							<input type="text" class="form-control" id="swap_minus_two"  name="swap_minus_two">
							<span class="input-group-addon">-</span>
						</div>
					</div>
					<div class="col-sm-6">
						<label>Increasing Item</label>
						<div class="input-group">
							<input type='text' class='form-control' id="swal_plus_two" name="swap_plus_two">
							<span class="input-group-addon">+</span>
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='col-sm-6 col-sm-offset-6'>
						<label>Price list</label>
						<input type='number' value='0' class='form-control' id='price_two' name='price_two'>
					</div>
				</div>
				<div class="col-sm-4" style="padding-top:20px">
					<button type="button" class="btn btn-primary" onclick='validate(5)'>Submit Item</button>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	function validate(n){
		var event_id = n;
		var validation = true;
		if (event_id == '1' || event_id == '2'){
			$('#' + event_id + ' input').each(function(){
				if($(this).val() == ''){
					alert('Insert the item reference!');
					validation = false;
					return false;
				} else{	
				}
			});
		} else if(event_id == '3'){
			if($('#initial_item_de_reference').val() == ''){
				alert('Please input dematerialized item');
				validation = false;
				return false;
			} else if($('#initial_item_de_quantity').val() == '' || $('#initial_item_de_quantity').val() == 0){
				alert('Please input dematerialized quantity');
				validation = false;
				return false;				
			} else if($('#de_1').val() == '' || $('#de_2').val() == ''){
				alert('Insert two input in minimum');
				validation = false;
				return false;
			} else if($('#de_pl1').val() == '' || $('#de_pl1').val() == 0 || $('#de_pl2').val() == '' || $('#de_pl2').val() == 0){
				alert('Please insert price list!');
				validation = false;
				return false;
			} else if($('#de_3').val() != '' && ($('#de_pl3').val() == 0 || $('#de_pl3').val() == '')){
				alert('Please insert price list!');
				validation = false;
				return false;
			};
		} else if(event_id == '4'){
			if($('#mfinal').val() == ''){
				alert('Please input materialized item');
				validation = false;
				return false;
			} else if($('#m1').val() == '' || $('#m2').val() == ''){
				alert('Insert two input in minimum');
				validation = false;
				return false;
			} else {
				
			}
		} else if(event_id == '5'){
			if($('#price_two').val() == '' || $('#price_two').val() == '0' || $('#price_one').val() == '' || $('#price_one').val() == '0'){
				alert('Insert price!');
				validation = false;
				return false;
			} else if($('swap_minus_one').val() == '' ||$('swap_minus_two').val() == '' || $('swap_plus_one').val() == '' || $('swap_plus_two').val() == ''){
				alert('Insert the item reference!');
				validation = false;
				return false;
			}
		};
		if (validation)
			$('#event_form').submit();
	};
</script>
<?php
	} else {
		header('location:inventory.php');
	}
?>