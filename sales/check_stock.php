<DOCTYPE html>
<?php
	include('salesheader.php');
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class="main">
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