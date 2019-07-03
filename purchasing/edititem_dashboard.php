<?php
	include("purchasingheader.php");
	$sql = "SELECT COUNT(id) as jumlah FROM itemlist";
	$results = $conn->query($sql);
	while($row = $results->fetch_assoc()){
		$jumlah = $row['jumlah'];
	}
	$page = $_GET['page'] ?? "1";
	$total = ceil($jumlah / 100);
	$bawah = $total - 2;
	$mentok = $total;
?>
<style>
.inactive{
	display:none;
}
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
				<li><a href="edititem_dashboard.php?page=1"><<</a></li>
				<li><a href="edititem_dashboard.php?page=<?= $page - 1?>"><</a></li>
		<?php
				}
				if($mentok - $page > 5){
					for($total = $page; $total <= $page + 2; $total++){
		?>
				<li><a href="edititem_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
		<?php
				}
		?>
				<li><a href='#'>...</a></li>
		<?php
					for($total = $bawah; $total <= $mentok; $total++){
		?>
				<li><a href="edititem_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
		<?php	
					}
				} else {
					for($total = $page; $total <= $page || $total <= $mentok; $total++){
		?>
					<li><a href="edititem_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
		<?php
					}
				}
			if($page < $mentok){
		?>
				<li><a href="edititem_dashboard.php?page=1">></a></li>
				<li><a href="edititem_dashboard.php?page=<?= $page - 1?>">>></a></li>
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
		<div class="row">
			<div class="col-sm-12">
				<label>Search</label>
				<input type="text" id="myInput" placeholder="Search for reference or description" class="form-control">
			</div>
		</div>
		<br><br>
		<br>
		<?php
			if($role == 'superadmin'){
		?>
		<div class="row" style="text-align:center">
			<div class="col-sm-3">
				<p><b>Reference</b></p>
			</div>
			<div class="col-sm-4">
				<p><b>Description</b></p>
			</div>
		</div>
		<?php
			} else {
		?>
		<div class="row" style="text-align:center">
			<div class="col-sm-3">
				<p><b>Reference</b></p>
			</div>
			<div class="col-sm-5">
				<p><b>Description</b></p>
			</div>
		</div>
		<?php
			}
		?>
		<hr>
		<div id="edititemtable">
			<?php
				if($page == ''){
					$offset = 0;
				} else {
					$offset = ($page-1) * 100;
				}
				$sql = "SELECT * FROM itemlist ORDER by reference ASC LIMIT 100 OFFSET " . $offset;
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()){
				if($role == 'superadmin'){
			?>
				<div class='row' style='text-align:center;margin-top:10px'>
					<div class="col-sm-3">
						<p><?= $row['reference']; ?></p>
					</div>
					<div class="col-sm-4">
						<p><?= $row['description']; ?></p>
					</div>
					<div class="col-sm-3">
						<p><?php
							if($row['type'] == 0){
								echo ('Unassigned');
							} else {
								$sql_type = "SELECT name FROM itemlist_category WHERE id = '" . $row['type'] . "'";
								$result_type = $conn->query($sql_type);
								$type = $result_type->fetch_assoc();
								echo $type['name'];
							}
						?></p>
					</div>
			<?php
				} else {
			?>
				<div class='row' style='text-align:center;margin-top:10px'>
					<div class="col-sm-3">
						<p><?= $row['reference']; ?></p>
					</div>
					<div class="col-sm-6">
						<p><?= $row['description']; ?></p>
					</div>
					<div class="col-sm-3">
						<p><?= $row['name']; ?></p>
					</div>
				</div>
			<?php
				}
				if($role == 'superadmin'){
			?>
					<div class="col-sm-2">
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal-<?=$row['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></button>
<?php
	$sql_disable = "SELECT 
			(SELECT COUNT(id) FROM quotation WHERE reference = '" . $row['reference'] . "') AS quotation_count,
			(SELECT COUNT(id) FROM sales_order WHERE reference = '" . $row['reference'] . "') AS so_count,
			(SELECT COUNT(id) FROM stock WHERE reference = '" . $row['reference'] . "') AS stock_count,
			(SELECT COUNT(id) FROM stock_value_in WHERE reference = '" . $row['reference'] . "') AS value_in_count";
	$result_disable = $conn->query($sql_disable);
	$disable = $result_disable->fetch_assoc();
	$disable_condition = $disable['quotation_count']  + $disable['so_count'] + $disable['stock_count'] + $disable['value_in_count'];
	if($disable_condition == 0){
?>					
						<button type='button' class='btn btn-default' onclick='disable(<?= $row['id'] ?>)'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
<?php
	} else {
?>
						<button type='button' class='btn btn-default' disabled><i class="fa fa-trash-o" aria-hidden="true"></i></button>
<?php
	}
?>
					</div>
				</div>
			<?php
				}
			?>
			<div class="modal" id="myModal-<?=$row['id']?>" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Edit Item List</h4>
						</div>
						<form id="editsupplier-<?=$row['id']?>">
						<div class="modal-body">
							<input name="id" type="hidden" value="<?php echo $row['id']?>">
							<label for="name">reference</label>
							<input class="form-control" for="name" name="reference" value="<?=$row['reference']?>" id ='reference<?= $row['id'] ?>' required>
							<label for="name" >Description </label>
							<input class="form-control" for="name" name="description" id="description<?= $row['id'] ?>" value="<?=$row['description']?>" required>
							<label>Type</label>
							<select class='form-control' name='type' id='type<?= $row['id'] ?>'>
								<option value='0'>Please select a type</option>
<?php
	$sql_brand = "SELECT id,name FROM itemlist_category ORDER BY name ASC";
	$result_brand = $conn->query($sql_brand);
	while($brand = $result_brand->fetch_assoc()){
?>
								<option value='<?= $brand['id'] ?>' <?php if($row['type'] == $brand['id']){ echo ('selected');} ?>><?= $brand['name'] ?></option>
<?php
	}
?>
							</select>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-success" onclick='send_edit(<?= $row['id'] ?>)' id="edit">Edit</button>
						</div>
						</form>
					</div>
				</div>
			</div>	
			<?php
				}
			?>
		</div>
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
				<li><a href="edititem_dashboard.php?page=1"><<</a></li>
				<li><a href="edititem_dashboard.php?page=<?= $page - 1?>"><</a></li>
		<?php
				}
				if($mentok - $page > 5){
					for($total = $page; $total <= $page + 2; $total++){
		?>
				<li><a href="edititem_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
		<?php
				}
		?>
				<li><a href='#'>...</a></li>
		<?php
					for($total = $bawah; $total <= $mentok; $total++){
		?>
				<li><a href="edititem_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
		<?php	
					}
				} else {
					for($total = $page; $total <= $page || $total <= $mentok; $total++){
		?>
					<li><a href="edititem_dashboard.php?page=<?= $total ?>"><?= $total ?></a></li>
		<?php
					}
				}
			if($page < $mentok){
		?>
				<li><a href="edititem_dashboard.php?page=1">></a></li>
				<li><a href="edititem_dashboard.php?page=<?= $page - 1?>">>></a></li>
		<?php 
			}
		?>
			</ul>
		<?php
			}
		?>
			</div>
		</div>
		<div id="showresults"></div>
		<div id="daniel"></div>
	</div>
	<div class='notification_large' style='display:none' id='delete_large'>
		<div class='notification_box'>
			<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
			<h2 style='font-family:bebasneue'>Are you sure to delete this item?</h2>
			<br>
			<button type='button' class='btn btn-back'>Back</button>
			<button type='button' class='btn btn-delete'>Delete</button>
		</div>
	</div>
	<input type='hidden' id='delete_id'>
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
		url:'delete_item.php',
		data:{
			id :$('#delete_id').val(),
		},
		type:'POST',
		success: function(){
			location.reload();
		}
	})
});
function send_edit(n){
	var id = n;
	$.ajax({
		url: 'edititem.php',
		data: {
			reference : $('#reference' + id).val(),
			description : $('#description' + id).val(),
			type : $('#type' + id).val(),
			id : n,
		},
		type: "POST",
		success:function(){
			location.reload();
		}
	});
};
$('#myInput').change(function () {
	$.ajax({
        url: "ajax/num_rows_ajax.php",
        data: {
            term: $('#myInput').val()
        },
        type: "GET",
        dataType: "html",
        success: function (data) {
            $('#results').replaceWith($('#daniel').html(data));
        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        }
	});
    $.ajax({
        url: "ajax/search_edit_item.php",
        data: {
            term: $('#myInput').val()
        },
        type: "GET",
        dataType: "html",
        success: function (data) {
            $('#edititemtable').html(data);
        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        },
        complete: function (xhr, status) {
            //$('#showresults').slideDown('slow')
        }
    });
})
</script>