<DOCTYPE html>
<?php
	include('salesheader.php');
?>
<style>
	.custom-file-input::-webkit-file-upload-button {
	  visibility: hidden;
	}
	.custom-file-input::before {
		content: 'Select some files';
		display: inline-block;
		background: linear-gradient(top, #f9f9f9, #e3e3e3);
		border: 1px solid #999;
		border-radius: 3px;
		padding: 5px 8px;
		outline: none;
		white-space: nowrap;
		-webkit-user-select: none;
		cursor: pointer;
		text-shadow: 1px 1px #fff;
		font-weight: 700;
		font-size: 10pt;
	}
	.custom-file-input:hover::before {
		border-color: black;
	}
	.custom-file-input:active::before {
		background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
	}
</style>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class="main">
	<h2 style='font-family:bebasneue'>Check stock</h2>
	<form action="check_stock_file.php" method="post" enctype="multipart/form-data">
		<input type="file" class="custom-file-input">
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