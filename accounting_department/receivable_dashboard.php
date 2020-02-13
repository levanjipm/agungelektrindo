<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Receivable</title>
</head>
<style>
	.garis_wrapper{
		transition:0.3s all ease;
		margin-top:10px;
	}
	
	.garis_wrapper:hover{
		background-color:#afdfe6;
		transition:0.3s all ease;
	}

	.garis{
		height:20px;
		box-shadow: 2px 2px 4px 2px rgba(20,20,20,0.4);
	}
</style>
<div class='main'>
	<div class='row'>
		<div class='col-sm-4'>
			<h2 style='font-family:bebasneue'>Account of receivable</h2>
		</div>
		<div class='col-sm-4 col-sm-offset-4'>
			<label>Customer</label><br>
			<select class='form-control' id='customer_id' style='width:80%;display:inline-block'>
<?php
	$sql			= "SELECT id,name FROM customer ORDER BY name ASC";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$id			= $row['id'];
		$name		= $row['name'];
?>
				<option value='<?= $id ?>'><?= $name ?></option>
<?php
	}
?>
			</select>
			<button type='button' class='button_default_dark' id='view_receivable'><i class='fa fa-search'></i></button>
		</div>
	</div>			
	<hr>
	<div id='view_pane'></div>
</div>
<script>
	$.ajax({
		url:'receivable_dashboard_chart',
		data:{
			term:1
		},
		type:'GET',
		success:function(response){
			$('#view_pane').html(response);
		}
	});
	
	$('#view_receivable').click(function(){
		var customer_id		= $('#customer_id').val();
		var link			= "customer_view.php?id=" + customer_id;
		window.location.href=link;
	});
	
	function change_customer(){
		$('#customer_to_view').val($('#seleksi').val());
	}
	function submiting(){
		if($('#customer_to_view').val() == 0){
			alert('Please insert a customer!');
			return false;
		} else {
			$('#customer_form').submit();
		}
	}
</script>