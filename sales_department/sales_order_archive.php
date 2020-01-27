<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Sales order archives</title>
</head>
<script>
	$('#sales_order_side').click();
	$('#sales_order_archive').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Order</h2>
	<p style='font-family:museo'>Archive</p>
	<hr>
	<button type='button' class='button_default_dark' id='back_button'><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></button>
	<input type='hidden' value='0' id='depth'>
	<input type='hidden' value='0' id='depth_year'>
	<div class='row' id='folders'>
<?php
	$sql 		= "SELECT DISTINCT(YEAR(date)) AS year FROM code_salesorder";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
?>
	<div class='col-sm-2 folder_year' style='cursor:pointer' ondblclick='view_month(<?= $row['year'] ?>)' touchstart='view_month(<?= $row['year']; ?>)'>
		<h1 style='font-size:5em'>
			<i class="fa fa-folder-o" aria-hidden="true"></i>
		</h1>
		<p style='font-family:bebasneue'><?= $row['year'] ?></p>
	</div>
<?php
	}
?>
</div>
<script>
	function view_month(n){
		$('#depth').val(1);
		$('#depth_year').val(n);
		$.ajax({
			url:'sales_order_archive_month.php',
			data:{
				year:n,
			},
			success:function(response){
				$('#folders').html(response);
			},
			type:"POST",
		})
	}
	function view_po(month,year){
		$('#depth').val(2);
		$.ajax({
			url:'sales_order_archive_file.php',
			data:{
				year:year,
				month:month,
			},
			success:function(response){
				$('#folders').html(response);
			},
			type:"POST",
		});
	}
	$('#back_button').dblclick(function(){
		if($('#depth').val() == 1){
			$.ajax({
			url:'sales_order_archive_year.php',
			success:function(response){
				$('#folders').html(response);
			},
			type:"POST",
			})
		} else if($('#depth').val() == 2){
			view_month($('#depth_year').val());
		}
	});
	function view_sales_order_archive(n){
		$('#sales_order_id').val(n);
		$('#sales_order_archive_form').submit();
	}
</script>