<?php
	include('inventoryheader.php');
?>
<style>
.box_do{
	padding:100px 30px;
	box-shadow: 3px 3px 3px 3px #888888;
}
.icon_wrapper{
	position:relative;
}
.view_wrapper{
	position:fixed;
	top:30px;
	right:0px;
	margin-left:0;
	width:30%;
	background-color:#eee;
	padding:20px;
}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sample</h2>
	<hr>
	<div class='row'>
		<div class='col-sm-7'>
			<h3 style='font-family:bebasneue'>Send sample</h3>
			<div class='row'>
<?php
	$sql_sample = "SELECT * FROM code_sample WHERE isconfirm = '1' AND issent = '0'";
	$result_sample = $conn->query($sql_sample);
	while($sample = $result_sample->fetch_assoc()){
?>
			<div class='col-sm-4' style='margin-top:30px;text-align:center'>
				<div class='box' style='background-color:#eee;width:90%;text-align:center;padding:10px'>
					<h3 style='font-family:bebasneue'><?php
						$sql_customer = "SELECT name FROM customer WHERE id = '" . $sample['customer_id'] . "'";
						$result_customer = $conn->query($sql_customer);
						$customer = $result_customer->fetch_assoc();
						echo $customer['name'];
					?></h3>
					<button type='button' class='btn btn-default' onclick='view(<?= $sample['id'] ?>)'>View</button>
					<button type='button' class='btn btn-success' onclick='send(<?= $sample['id'] ?>)'>Send</button>
				</div>
				<form method='POST' action='sample_validate.php' id='send_form<?= $sample['id'] ?>'>
					<input type='hidden' value='<?= $sample['id'] ?>' name='id'>
				</form>
			</div>
<?php
		}
?>
			</div>
			<hr>
			<h3 style='font-family:bebasneue'>Receive back sample</h3>
			<div class='row'>
<?php
	$sql_sample_back = "SELECT * FROM code_sample WHERE isconfirm = '1' AND issent = '1' AND isback = '0'";
	$result_sample_back = $conn->query($sql_sample_back);
	while($sample_back = $result_sample_back->fetch_assoc()){
?>
			<div class='col-sm-4' style='margin-top:30px;text-align:center'>
				<div class='box' style='background-color:#eee;width:90%;text-align:center;padding:10px'>
					<h3 style='font-family:bebasneue'><?php
						$sql_customer = "SELECT name FROM customer WHERE id = '" . $sample_back['customer_id'] . "'";
						$result_customer = $conn->query($sql_customer);
						$customer = $result_customer->fetch_assoc();
						echo $customer['name'];
					?></h3>
					<button type='button' class='btn btn-default' onclick='view(<?= $sample_back['id'] ?>)'>View</button>
					<button type='button' class='btn btn-secondary' onclick='receive(<?= $sample_back['id'] ?>)'>Receive</button>
					<form method='POST' action='sample_receive_validate.php' id='receive_form<?= $sample_back['id'] ?>'>
						<input type='hidden' value='<?= $sample_back['id'] ?>' name='id'>
					</form>
				</div>
			</div>
<?php
	}
?>
		</div>
		<div class='view_wrapper'>
			<div id='view_sample'>
			</div>
		</div>
<script>
	function view(n){
		$.ajax({
			url:'view_sample.php',
			data:{
				id: n,
			},
			success:function(response){
				$('#view_sample').html(response);
			},
			type:'POST',
		})
	}
	function send(n){
		$('#send_form' + n).submit();
	}
	function receive(n){
		$('#receive_form' + n).submit();
	}
</script>