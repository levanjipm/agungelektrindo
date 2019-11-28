<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
	
	$sql 		= "SELECT COUNT(id) as jumlah FROM itemlist";
	$results 	= $conn->query($sql);
	$row 		= $results->fetch_assoc();
	$jumlah 	= $row['jumlah'];
	
	$page 		= $_GET['page'] ?? "1";
	$total 		= ceil($jumlah / 100);
	$bawah 		= $total - 2;
	$mentok 	= $total;
?>
<head>
	<title>Manage item</title>
</head>
<div class="main">
	<h2 style='font-family:bebasneue'>Item</h2>
	<p style='font-family:museo'>Manage items</p>
	<hr>
	<div class='row' style='text-align:center'>
			<div class='col-md-6 col-md-offset-3'>
<?php
	if($total <=10){
?>
			<ul class="pagination">
<?php
				for ($total = 1; $total <= 5; $total ++){
?>
				<li><a href="#"><?= $total ?></a></li>
<?php
				}
?>
			</ul>
<?php
			} else if($total > 10){
?>
			<ul class="pagination">
<?php
				if($page > 1){
?>
				<li><a href="item_manage_dashboard.php?page=1"><<</a></li>
				<li><a href="item_manage_dashboard.php?page=<?= $page - 1?>"><</a></li>
<?php
				}
				if($mentok - $page > 5){
					for($total = $page; $total <= $page + 2; $total++){
?>
				<li><a href="item_manage_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php
				}
?>
				<li><a href='#'>...</a></li>
<?php
					for($total = $bawah; $total <= $mentok; $total++){
?>
				<li><a href="item_manage_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php	
					}
				} else {
					for($total = $page; $total <= $page || $total <= $mentok; $total++){
?>
					<li><a href="item_manage_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php
					}
				}
			if($page < $mentok){
?>
				<li><a href="item_manage_dashboard.php?page=1">></a></li>
				<li><a href="item_manage_dashboard.php?page=<?= $page - 1?>">>></a></li>
<?php } ?>
			</ul>
<?php } ?>
			</div>
		</div>
	<br>
	<input type="text" id="search_item_bar" placeholder="Search for reference or description" class="form-control">
	<br>
	<table class='table table-bordered'>
		<tr>
			<th style='width:20%'>Reference</th>
			<th style='width:40%'>Description</th>
			<th style='width:20%'>Type</th>
<?php if($role == 'superadmin'){ ?>
			<th></th>
<?php } ?>
		</tr>
		<tbody id='edit_item_table_body'>
<?php
	if($page == ''){ $offset = 0;} else { $offset = ($page-1) * 100; }
	
	$sql 					= "SELECT * FROM itemlist ORDER by reference ASC LIMIT 100 OFFSET " . $offset;
	$result 				= $conn->query($sql);
	while($row 				= $result->fetch_assoc()){
		if($row['type'] 	== 0 || $row['type'] == NULL){
			$type_text		= 'unassigned';
		} else {
			$sql_type 		= "SELECT name FROM itemlist_category WHERE id = '" . $row['type'] . "'";
			$result_type 	= $conn->query($sql_type);
			$type 			= $result_type->fetch_assoc();
			$type_text		= $type['name'];
		}
		
		$sql_disable 		= "SELECT 
							(SELECT COUNT(id) FROM quotation WHERE reference = '" . $row['reference'] . "') AS quotation_count,
							(SELECT COUNT(id) FROM sales_order WHERE reference = '" . $row['reference'] . "') AS so_count,
							(SELECT COUNT(id) FROM stock WHERE reference = '" . $row['reference'] . "') AS stock_count,
							(SELECT COUNT(id) FROM stock_value_in WHERE reference = '" . $row['reference'] . "') AS value_in_count";
		$result_disable 	= $conn->query($sql_disable);
		$disable 			= $result_disable->fetch_assoc();
		$disable_condition 	= $disable['quotation_count']  + $disable['so_count'] + $disable['stock_count'] + $disable['value_in_count'];
?>
			<tr>
				<td><?= $row['reference'] ?></td>
				<td><?= $row['description'] ?></td>
				<td><?= $type_text ?></td>
<?php if($role == 'superadmin'){ ?>
				<td>
					<button type="button" class="button_default_dark" onclick='open_edit_pane(<?= $row['id'] ?>)'>
						<i class="fa fa-pencil" aria-hidden="true"></i>
					</button>
<?php if($disable_condition == 0){ ?>
					<button type='button' class='button_warning_dark' onclick='disable(<?= $row['id'] ?>)'>
						<i class="fa fa-trash-o" aria-hidden="true"></i>
					</button>
<?php } else if($disable_condition > 0){ ?>
					<button type='button' class='button_danger_dark' disabled>
						<i class="fa fa-trash-o" aria-hidden="true"></i>
					</button>
<?php } ?>
				</td>
<?php } ?>
			</tr>
<?php } ?>
			
		</tbody>
	</table>
	<div class='row' style='text-align:center'>
		<div class='col-md-6 col-md-offset-3'>
<?php
	if($total <=10){
?>
		<ul class="pagination">
<?php
		for ($total = 1; $total <= 5; $total ++){
?>
			<li><a href="#"><?= $total ?></a></li>
<?php
		}
?>
		</ul>
<?php
	} else if($total > 10){
?>
		<ul class="pagination">
<?php
		if($page > 1){
?>
			<li><a href="item_manage_dashboard.php?page=1"><<</a></li>
			<li><a href="item_manage_dashboard.php?page=<?= $page - 1?>"><</a></li>
<?php
		}
		if($mentok - $page > 5){
			for($total = $page; $total <= $page + 2; $total++){
?>
			<li><a href="item_manage_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php
		}
?>
			<li><a href='#'>...</a></li>
<?php
			for($total = $bawah; $total <= $mentok; $total++){
?>
			<li><a href="item_manage_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php	
			}
		} else {
			for($total = $page; $total <= $page || $total <= $mentok; $total++){
?>
			<li><a href="item_manage_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php
			}
		}
	if($page < $mentok){
?>
			<li><a href="item_manage_dashboard.php?page=1">></a></li>
			<li><a href="item_manage_dashboard.php?page=<?= $page - 1?>">>></a></li>
<?php 
	}
?>
		</ul>
<?php
	}
?>
		</div>
	</div>
</div>
<div class='full_screen_wrapper' id='delete_large'>
	<div class='full_screen_notif_bar'>
		<h2 style='font-size:2em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h2>
		<p style='font-family:museo'>Are you sure to delete this item?</p>
		<button type='button' class='button_danger_dark' id='check_again_button'>Check again</button>
		<button type='button' class='button_success_dark' id='delete_button'>Confirm</button>
	</div>
	<input type='hidden' id='delete_id'>
</div>

<div class='full_screen_wrapper' id='edit_item_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
function disable(n){
	var window_height			= $(window).height();
	var notif_height			= $('.full_screen_notif_bar').height();
	var difference				= window_height - notif_height;
	$('#delete_large .full_screen_notif_bar').css('top',0.7 * difference / 2);
	$('#delete_large').fadeIn();
	$('#delete_id').val(n);
}

$('#check_again_button').click(function(){
	$('#delete_large').fadeOut();
});

$('#delete_button').click(function(){
	$.ajax({
		url:'item_delete.php',
		data:{
			id :$('#delete_id').val(),
		},
		type:'POST',
		success: function(){
			location.reload();
		}
	})
});

function open_edit_pane(n){
	$.ajax({
		url:'item_edit_form.php',
		type:'POST',
		data:{
			item_id:n
		},
		success: function(response){
			$('#edit_item_wrapper').fadeIn();
			$('.full_screen_box').html(response);
		},
	})
}

$('.full_screen_close_button').click(function(){
	$('#edit_item_wrapper').fadeOut();
});

$('#search_item_bar').change(function () {	
    $.ajax({
        url: "item_edit_search.php",
        data: {
            term: $('#search_item_bar').val()
        },
        type: "GET",
        dataType: "html",
		beforeSend:function(){
			$('#search_item_bar').attr('disabled',true);
			$('#edit_item_table_body').html('');
		},
        success: function (data) {
			$('#search_item_bar').attr('disabled',false);
            $('#edit_item_table_body').append(data);
        },
    });
})
</script>