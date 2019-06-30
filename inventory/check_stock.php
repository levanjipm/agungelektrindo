<?php
	include('inventoryheader.php');
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class="main">
	<h2 style='font-family:bebasneue'>Check Stock</h2>
	<hr>
	<input type="text" id="myInput" placeholder="Search..">
	<style>
		input[type=text] {
		width: 130px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
		}
		input[type=text]:focus {
		width: 100%;
		}
	</style>
	<br><br><br>
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
			<div class="col-sm-3">
				<?= $row['reference'];?>
			</div>
<?php
		$sql_item = "SELECT id,description FROM itemlist WHERE reference = '" . $row['reference'] . "'";
		$result_item = $conn->query($sql_item);
		while($row_item = $result_item->fetch_assoc()){
			$item_id = $row_item['id'];
?>
			<div class='col-sm-5'>
				<?= $row_item['description'] ?>
			</div>
<?php 
		}
?>
			<div class="col-sm-2">
				<?= $row['stock']; ?>
			</div>
			<div class='col-sm-1'>
			<button type='button' class='btn btn-default' onclick='view(<?= $item_id ?>)'>View Stock Card</button>
			<form id='form<?= $item_id ?>' action='stock_card.php' method='POST'>
				<input type='hidden' value='<?= $item_id ?>' name='item_id'>
			</form>
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
        url: "ajax/search_check_stock.php",
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
function view(reference){
	var string = reference;
	$('#form' + string).submit();
}
</script>