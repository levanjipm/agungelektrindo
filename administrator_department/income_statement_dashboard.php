<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/administrator_header.php');
?>
<head>
	<title>Income statement</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Income statement</h2>
	<hr>
	<label>Month</label>
	<select class='form-control' id='month'>
		<option value='1'>January</option>
		<option value='2'>February</option>
		<option value='3'>March</option>
		<option value='4'>April</option>
		<option value='5'>May</option>
		<option value='6'>June</option>
		<option value='7'>July</option>
		<option value='8'>August</option>
		<option value='9'>September</option>
		<option value='10'>October</option>
		<option value='11'>November</option>
		<option value='12'>December</option>
	</select>
	<label>Year</label>
	<select class='form-control' id='year'>
<?php
	$sql		= "SELECT DISTINCT(YEAR(date)) AS year FROM invoices WHERE YEAR(date) <> '2018'";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
?>
		<option value='<?= $row['year'] ?>'><?= $row['year'] ?></option>
<?php
	}
?>
	</select>
	<br>
	<button type='button' class='button_default_dark' id='submit_button'>Submit</button>
	<button type='button' class='button_success_dark' id='yearly_button'>View yearly</button>
	<br><br>
	<div id='balance_view'></div>
</div>
<script>
	$('#submit_button').click(function(){
		$.ajax({
			url:'income_statement.php',
			data:{
				month:$('#month').val(),
				year:$('#year').val(),
			},
			beforeSend:function(){
				$('#submit_button').attr('disabled',true);
				$('#balance_view').html('');
				$('.loading_wrapper_initial').fadeIn();
			},
			type:'POST',
			success:function(response){
				$('.loading_wrapper_initial').fadeOut();
				$('#submit_button').attr('disabled',false);
				$('#balance_view').html(response);
			},
		});
	});
	
	$('#yearly_button').click(function(){
		$.ajax({
			url:'income_statement_yearly.php',
			data:{
				year:$('#year').val(),
			},
			beforeSend:function(){
				$('#submit_button').attr('disabled',true);
				$('#balance_view').html('');
				$('.loading_wrapper_initial').fadeIn();
			},
			type:'POST',
			success:function(response){
				$('.loading_wrapper_initial').fadeOut();
				$('#submit_button').attr('disabled',false);
				$('#balance_view').html(response);
			},
		});
	});
</script>