<?php
	include("purchasingheader.php");
	$sql 		= "SELECT COUNT(id) as jumlah FROM itemlist";
	$results 	= $conn->query($sql);
	$row 		= $results->fetch_assoc();
	$jumlah 	= $row['jumlah'];
	
	$page 		= $_GET['page'] ?? "1";
	$total 		= ceil($jumlah / 100);
	$bawah 		= $total - 2;
	$mentok 	= $total;
?>
<style>
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
	}
	
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
		box-shadow: 3px 4px 3px 4px #ddd;
	}
	
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	
	.view_edit_item_form{
		background-color:rgba(30,30,30,0.7);
		position:fixed;
		z-index:100;
		top:0;
		width:100%;
		height:100%;
		display:none;
	}
	
	#view_edit_item_box{
		position:absolute;
		width:90%;
		left:5%;
		top:10%;
		height:80%;
		background-color:white;
		overflow-y:scroll;
		padding:20px;
	}
	
	#button_edit_form_close{
		position:absolute;
		background-color:transparent;
		top:10%;
		left:5%;
		outline:none;
		border:none;
		color:#333;
		z-index:120;
	}
</style>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class="main">
	<h2 style='font-family:bebasneue'>Item</h2>
	<p>Edit items</p>
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
				<li><a href="item_edit_dashboard.php?page=1"><<</a></li>
				<li><a href="item_edit_dashboard.php?page=<?= $page - 1?>"><</a></li>
<?php
				}
				if($mentok - $page > 5){
					for($total = $page; $total <= $page + 2; $total++){
?>
				<li><a href="item_edit_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php
				}
?>
				<li><a href='#'>...</a></li>
<?php
					for($total = $bawah; $total <= $mentok; $total++){
?>
				<li><a href="item_edit_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php	
					}
				} else {
					for($total = $page; $total <= $page || $total <= $mentok; $total++){
?>
					<li><a href="item_edit_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php
					}
				}
			if($page < $mentok){
?>
				<li><a href="item_edit_dashboard.php?page=1">></a></li>
				<li><a href="item_edit_dashboard.php?page=<?= $page - 1?>">>></a></li>
<?php 
			}
?>
			</ul>
<?php
			}
?>
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
<?php
	if($role == 'superadmin'){
?>
			<th></th>
<?php
	}
?>
		</tr>
		<tbody id="edit_item_table_body">
<?php
	if($page == ''){
		$offset = 0;
	} else {
		$offset = ($page-1) * 100;
	}
	
	$sql 		= "SELECT * FROM itemlist ORDER by reference ASC LIMIT 100 OFFSET " . $offset;
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
		if($row['type'] == 0 || $row['type'] == NULL){
			$type_text	= 'unassigned';
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
<?php
	if($role == 'superadmin'){
?>
				<td>
					<button type="button" class="button_default_dark" onclick='open_edit_pane(<?= $row['id'] ?>)'>
						<i class="fa fa-pencil" aria-hidden="true"></i>
					</button>
<?php
		if($disable_condition == 0){
?>
					<button type='button' class='button_warning_dark' onclick='disable(<?= $row['id'] ?>)'>
						<i class="fa fa-trash-o" aria-hidden="true"></i>
					</button>
<?php
		} else if($disable_condition > 0){
?>
					<button type='button' class='button_danger_dark' disabled>
						<i class="fa fa-trash-o" aria-hidden="true"></i>
					</button>
<?php
		}
?>
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
			<li><a href="item_edit_dashboard.php?page=1"><<</a></li>
			<li><a href="item_edit_dashboard.php?page=<?= $page - 1?>"><</a></li>
<?php
		}
		if($mentok - $page > 5){
			for($total = $page; $total <= $page + 2; $total++){
?>
			<li><a href="item_edit_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php
		}
?>
			<li><a href='#'>...</a></li>
<?php
			for($total = $bawah; $total <= $mentok; $total++){
?>
			<li><a href="item_edit_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php	
			}
		} else {
			for($total = $page; $total <= $page || $total <= $mentok; $total++){
?>
			<li><a href="item_edit_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
<?php
			}
		}
	if($page < $mentok){
?>
			<li><a href="item_edit_dashboard.php?page=1">></a></li>
			<li><a href="item_edit_dashboard.php?page=<?= $page - 1?>">>></a></li>
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
<div class='notification_large' style='display:none' id='delete_large'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to delete this item?</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete'>Delete</button>
	</div>
	<input type='hidden' id='delete_id'>
</div>
<div class='view_edit_item_form'>
	<button id='button_edit_form_close'>X</button>
	<div id='view_edit_item_box'>
	</div>
</div>
<script>
function disable(n){
	$('#delete_large').fadeIn();
	$('#delete_id').val(n);
}

$('.btn-back').click(function(){
	$('#delete_large').fadeOut();
});

$('.btn-delete').click(function(){
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
			$('.view_edit_item_form').fadeIn();
			$('#view_edit_item_box').html(response);
		},
	})
}

$('#button_edit_form_close').click(function(){
	$('.view_edit_item_form').fadeOut();
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