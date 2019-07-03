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
	<p>Send sample</p>
	<hr>
	<div class='row'>
		<div class='col-sm-7'>
			<h3 style='font-family:bebasneue'>Samples</h3>
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
	function submit(n){
		$('#send_form' + n).submit();
	}
</script>