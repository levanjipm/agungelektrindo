<?php
	include('purchasingheader.php');
?>
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<style>
	.context_box{
		position:absolute;
		z-index:20;
		padding:10px;
		display:none;
		background-color:white;
		box-shadow: 3px 4px 3px 4px #888888;
	}
	.btn-context{
		width:100%;
		background-color:transparent;
		color:#333;
		padding:3px 10px;
		transition:0.2s all ease;
	}
	.btn-context:hover{
		color:#eee;
	}
</style>

<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase Report</h2>
	<p>Create purchasing report</p>
	<hr>
	<label>Supplier</label>
	<select class='form-control' id='supplier'>
		<option value='0'>--Please select a supplier</option>
<?php
	$sql_supplier = "SELECT id,name FROM supplier ORDER BY name";
	$result_supplier = $conn->query($sql_supplier);
	while($supplier = $result_supplier->fetch_assoc()){
?>
		<option value='<?= $supplier['id'] ?>'><?= $supplier['name'] ?></option>
<?php
	}
?>
	</select>
	<label>Year</label>
	<div class='input-group'>
		<select class='form-control' id='year' style='width:80%'>
<?php
	$sql = "SELECT DISTINCT(YEAR(date)) AS year FROM purchases";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
			<option value='<?= $row['year'] ?>'><?= $row['year'] ?></option>
<?php
	}
?>
		</select>
		<div class="input-group-append">
			<button type='button' class='btn btn-primary' id='submit_purchasing_report_button'>Submit</button>
		</div>
	</div>
	
	<div id='report'></div>
	<input type='hidden' value='<?= $supplier_id ?>' id='supplier_hidden'>
	<input type='hidden' value='<?= $year ?>' id='year_hidden'>
	<div class='context_box'>
		<button type='button' class='btn btn-context' id='view_monthly_span'>
			<span style='width:30%;float:left'>
				<i class="fa fa-eye" aria-hidden="true"></i>
			</span>
			<span style='width:70'>
				View monthly
			</span>
		</button>
		<button type='button' class='btn btn-context' id='view_all_span'>
			<span style='width:30%;float:left'>
				<i class="fa fa-pencil" aria-hidden="true"></i>
			</span>
			<span style='width:70' id='view_all_span'>
				View all
			</span>
		</button>
	</div>
</div>
<script>
	$( "#datepicker1" ).datepicker({dateFormat: 'yy'});
	function set_minimum_date(){
		$('#datepicker2').attr('min',$('#datepicker1').val());
	}
	$('#submit_purchasing_report_button').click(function(){
		if($('#supplier').val() == 0){
			alert('Please select a supplier');
			$('#supplier').focus();
			return false;
		} else if($('#datepicker1').val() == '' || $('#datepicker2').val() == ''){
			alert('Please insert valid date');
			$('#datepicker1').focus();
			return false;
		} else {
			$.ajax({
				url:'purchasing_report.php',
				data:{
					supplier: $('#supplier').val(),
					year: $('#year').val(),
				},
				type:'POST',
				success:function(response){
					$('#report').html(response);
					$('#supplier_hidden').val($('#supplier').val());
					$('#year_hidden').val($('#year').val());
				},
			})
		}
	});
	$('div').not('.context_box').click(function(){
		$('.context_box').fadeOut();
	});
	$('#report').contextmenu(function() {
		var currentMousePos = { x: -1, y: -1 };
		currentMousePos.x = event.pageX;
		currentMousePos.y = event.pageY;
		$('.context_box').css('left',currentMousePos.x);
		$('.context_box').css('top',currentMousePos.y);
		$('.context_box').fadeIn();
		
		event.preventDefault();
	});
	$('#view_monthly_span').click(function(){
		$.ajax({
			url:'purchasing_monthly_report.php',
			data:{
				supplier: $('#supplier_hidden').val(),
				year: $('#year_hidden').val(),
			},
			type:'POST',
			success:function(response){
				$('#report').html(response);
			},
		})
	});		
	$('#view_all_span').click(function(){
		$.ajax({
			url:'purchasing_report.php',
			data:{
				supplier: $('#supplier_hidden').val(),
				year: $('#year_hidden').val(),
			},
			type:'POST',
			success:function(response){
				$('#report').html(response);
				$('#supplier_hidden').val($('#supplier').val());
				$('#year_hidden').val($('#year').val());
			},
		})
	});
</script>