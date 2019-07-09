<DOCTYPE html>
<?php
	include('salesheader.php');
?>
<style>
	.inputfile{
		width: 0.1px;
		height: 0.1px;
		opacity: 0;
		overflow: hidden;
		position: absolute;
		z-index: -1;
	}
	.inputfile + label {
		font-size: 1.25em;
		color: white;
		background-color: #999;
		display: inline-block;
		padding:10px 30px;
		transition:0.3s all ease;
	}
	.inputfile:focus + label,
	.inputfile + label:hover {
		background-color: #666;
	}
	.inputfile + label {
		cursor: pointer;
	}
	.btn-side-file{
		background-color:transparent;
		border:none;
		border-left:2px solid #333;
		padding:10px;
	}
</style>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class="main">
	<h2 style='font-family:bebasneue'>Check stock</h2>
	<form action="check_stock_file.php" method="post" enctype="multipart/form-data" accept='.csv'>
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
	<input type="text" id="myInput" placeholder="Search for reference or description" class="form-control">
	<hr>
	<div class="row" style="text-align:center">
		<div class="col-lg-3">
			<p><b>Reference</b></p>
		</div>
		<div class="col-lg-5">
			<p><b>Description</b></p>
		</div>
		<div class="col-lg-2">
			<p><b>Stock</b></p>
		</div>
	</div>
	<br>
	<div id="edititemtable">
<?php
		$sql = "SELECT * FROM stock
		INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) topscore 
		ON stock.reference = topscore.reference 
		AND stock.id = topscore.latest
		LIMIT 10";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
?>
		<div class="row" style="text-align:center">
			<div class="col-lg-3">
				<?= $row['reference'];?>
			</div>
<?php
		$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $row['reference'] . "'";
		$result_item = $conn->query($sql_item);
		while($row_item = $result_item->fetch_assoc()){
?>
			<div class='col-lg-5'>
				<?= $row_item['description'] ?>
			</div>
<?php
		}
?>
			<div class="col-lg-2">
				<?= $row['stock']; ?>
			</div>
		</div>
		<br>
<?php
	}
?>
	</div>
	<div id="showresults"></div>
<script>
$('#myInput').change(function () {
    $.ajax({
        url: "search_check_stock.php",
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
        }
    });
});
</script>