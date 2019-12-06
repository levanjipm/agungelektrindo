<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
?>
<style>
	.button_edit{
		background-color:transparent;
		border:none;
		outline:none;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Item</h2>
	<p>Add class</p>
	<hr>
	<button type='button' class='button_success_dark' id='add_class_button'>Add class</button>
	<br><br>
	<table class='table table-bordered'>
		<tr>
			<th>Date added</th>
			<th>Class name</th>
			<th>Items</th>
			<th></th>
		</tr>
		<tbody>
<?php
	$sql 				= "SELECT date,id,name FROM itemlist_category ORDER BY date ASC";
	$result 			= $conn->query($sql);
	while($row 			= $result->fetch_assoc()){
		$sql_item 		= "SELECT COUNT(*) AS group_member_quantity FROM itemlist WHERE type = '" . $row['id'] . "'";
		$result_item 	=  $conn->query($sql_item);
		$item 			= $result_item->fetch_assoc();
		$member			= $item['group_member_quantity'];
?>
		<tr id='tr-<?= $row['id'] ?>'>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td>
				<button class='button_edit' onclick='view_edit_input(<?= $row['id'] ?>)' id='button-<?= $row['id'] ?>'>
					<?= $row['name'] ?>
				</button>
				<input type='text' class='form-control' id='input-<?= $row['id'] ?>' value='<?= $row['name'] ?>' style='display:none' onfocusout='edit_class_name(<?= $row['id'] ?>)'>
			</td>
			<td><?= $member	?></td>
<?php
				if($member == 0){
?>
			<td>	
				<button type='button' class='button_danger_dark' onclick='delete_class(<?= $row['id'] ?>)'>
					<i class="fa fa-trash" aria-hidden="true"></i>
				</button>
			</td>
<?php
				} else {
?>
			<td>	
				<button type='button' class='button_danger_dark' disabled>
					<i class="fa fa-trash" aria-hidden="true"></i>
				</button>
			</td>
<?php
				}
?>
		</tr>
<?php
	}
?>
		</tbody>
	</table>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
		<h2 style='font-family:bebasneue'>Add item class</h2>
		<hr>
		<label>Class name</label>
		<input type='text' class='form-control' name='class_name' id='class_name'>
		<br>
		<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
	</div>
</div>
<script>
	$('#add_class_button').click(function(){
		$('.full_screen_wrapper').fadeIn();
	});
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#submit_button').click(function(){
		if($('#class_name').val() == ''){
			alert('Please insert valid class name');
			$('#class_name').focus();
			return false;
		} else {
			$.ajax({
				url:'item_add_class',
				data:{
					class_name: $('#class_name').val()
				},
				type:'POST',
				beforeSend:function(){
					$('#add_class_button').attr('disabled',true);
				},
				success:function(response){
					location.reload();
				},
			})
		}
	});
	
	function delete_class(n){
		$.ajax({
			url:'item_delete_class',
			data:{
				class_id: n
			},
			type:'POST',
			success:function(response){
				location.reload();
			},
		})
	}
	
	function view_edit_input(n){
		$('#button-' + n).hide();
		$('#input-' + n).show();
		$('#input-' + n).focus();
	}
	
	function edit_class_name(n){
		$.ajax({
			url:'item_edit_class.php',
			data:{
				id: n,
				class_name: $('#input-' + n).val(),
			},
			type:'POST',
			success:function(){
				$('#button-' + n).html($('#input-' + n).val());
				$('#button-' + n).show();
				$('#input-' + n).hide();
			}
		});
	};
</script>