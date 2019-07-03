<?php
	include('purchasingheader.php');
?>
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<style>
	.alert_wrapper{
		position:absolute;
		z-index:55;
		left:50%;
	}
</style>
<div class='main'>
	<div class='alert_wrapper'>
		<div class="alert alert-success" id='success_alert' style='display:none'>
			<strong>Success!</strong> Successfully add item.
		</div>
		<div class="alert alert-warning" id='exist_alert' style='display:none'>
			<strong>Info</strong> We found an exact same reference. Aborting operation.
		</div>
		<div class="alert alert-danger" id='failed_alert' style='display:none'>
			<strong>Danger</strong> Failed to add item.
		</div>
	</div>
	<h2 style='font-family:bebasneue'>Item</h2>
	<p>Add class</p>
	<hr>
	<label>Class name</label>
	<input type='text' class='form-control' id='class_name'>
	<br>
	<button type='button' class='btn btn-default' id='submit_class'>Add class</button>
	<hr>
	<table class='table table-hover'>
		<tr>
			<th>Date added</th>
			<th>Class name</th>
			<th>Items</th>
			<th></th>
		</tr>
		<tbody>
<?php
	$sql = "SELECT date,id,name FROM itemlist_category ORDER BY date ASC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $row['name'] ?></td>
			<td><?php
				$sql_item = "SELECT COUNT(*) AS jumlah_kelompok FROM itemlist WHERE type = '" . $row['id'] . "'";
				$result_item =  $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['jumlah_kelompok'];
			?></td>
			<td><button type='button' class='btn btn-default'>View</button></td>
		</tr>
<?php
	}
?>
		</tbody>
	</table>
</div>
<script>
	$('tbody').sortable();
	$('#submit_class').click(function(){
		if($('#class_name').val() == ''){
			alert('Please insert a class name!');
			$('#class_name').focus();
			return false;
		} else {
			$.ajax({
				url: 'additem_class.php',
				data :{
					user: <?= $_SESSION['user_id'] ?>,
					class_name : $('#class_name').val(),
				},
				type: 'POST',
				success:function(response){
					if(response == 0){
						$('#exist_alert').fadeIn();
						setTimeout(function(){
							$('#exist_alert').fadeOut();
						},1000);
						$('#itemreff').focus();
					} else if(response == 1){
						$('#success_alert').fadeIn();
						setTimeout(function(){
							$('#success_alert').fadeOut();
						},1000);
						$('#itemreff').val('');
						$('#type').val(0);
						$('#itemdescs').val('');
					} else if(response == 2){
						$('#failed_alert').fadeIn();
						setTimeout(function(){
							$('#failed_alert').fadeOut();
						},1000);
					}
				},
			})
		}
	});
</script>