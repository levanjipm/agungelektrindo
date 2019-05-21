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
</style>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class="main">
	<div class="container" style="right:50px">
	<h2>Item</h2>
	<h4 style="color:#444">Edit items</h4>
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
				<input type="text" id="myInput" placeholder="Search for reference or description" class="form-control">
			</div>
		</div>
		<div id="results">
			<p>Showing 20 results only including inactive items, There are <b><?= $jumlah ?></b> Item registered</p>
		</div>
		
		<button type="button" class="btn btn-info" onclick="check_active()" id="item_active">Include inactive data</button>
		<button type="button" class="btn btn-default" onclick="check_inactive()" id="item_inactive" style="display:none">Exclude inactive data</button>
		<br><br>
		<script>
		function check_active(){
			$('.inactive').show();
			$('#item_inactive').show();
			$('#item_active').hide();
		}
		function check_inactive(){
			$('.inactive').hide();
			$('#item_inactive').hide();
			$('#item_active').show();
		}
		</script>
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
				$sql = "SELECT * FROM itemlist WHERE isdelete = '0' ORDER by reference ASC LIMIT 100 OFFSET " . $offset;
				$result = $conn->query($sql);
				while($row = mysqli_fetch_array($result)) {
					if ($row['isactive'] == 1){
						echo '<div class="row" style="padding:10px;text-align:center">';
					} else {
						echo '<div class="row inactive" style="padding:10px;text-align:center;background-color:#ddd">';
					}
				if($role == 'superadmin'){
			?>			
				<div class="col-sm-3">
					<p><?= $row['reference']; ?></p>
				</div>
				<div class="col-sm-4">
					<p><?= $row['description']; ?></p>
				</div>
				<div class="col-sm-3">
					<p><?= $row['type']; ?></p>
				</div>
			<?php
				} else {
			?>
				<div class="col-sm-3">
					<p><?= $row['reference']; ?></p>
				</div>
				<div class="col-sm-6">
					<p><?= $row['description']; ?></p>
				</div>
				<div class="col-sm-3">
					<p><?= $row['type']; ?></p>
				</div>
			<?php
				}
				if($role == 'superadmin'){
			?>
				<div class="col-sm-2">
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal-<?=$row['id']?>">Edit</button>
				</div>
			<?php
				}
			?>
			</div>
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
	$sql_brand = "SELECT DISTINCT type FROM itemlist WHERE type <> '' ORDER BY type ASC";
	$result_brand = $conn->query($sql_brand);
	while($brand = $result_brand->fetch_assoc()){
?>
								<option value='<?= $brand['type'] ?>'><?= $brand['type'] ?></option>
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
</div>
<script>
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
            $('#edititemtable').replaceWith($('#showresults').html(data));
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