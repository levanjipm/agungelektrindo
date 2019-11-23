<DOCTYPE html>
<?php
	include('salesheader.php');
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class="main">
	<h2 style='font-family:bebasneue'>Check stock</h2>
	<input type="text" id="check_stock_search_box" placeholder="Search..">
	<style>
		input[type=text] {
			padding:10px;
			width: 130px;
			-webkit-transition: width 0.4s ease-in-out;
			transition: width 0.4s ease-in-out;
		}
		input[type=text]:focus {
			width: 100%;
		}
	</style>
	<hr>
	<table class='table table-bordered' style='text-align:center'>
		<tr>
			<th style='text-align:center'>Reference</th>
			<th style='text-align:center'>Description</th>
			<th style='text-align:center'>Stock</th>
		</tr>
		<tbody id='stock_table_body'>
<?php
		$sql 		= "SELECT * FROM stock
					INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) topscore 
					ON stock.reference = topscore.reference 
					AND stock.id = topscore.latest
					LIMIT 10";
		$result 	= $conn->query($sql);
		while($row 	= $result->fetch_assoc()) {
			$stock			= $row['stock'];
			$reference		= $row['reference'];
			
			$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item 	= $conn->query($sql_item);
			$item	 		= $result_item->fetch_assoc();
			
			$description	= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= $stock ?></td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
<script>
$('#check_stock_search_box').change(function () {
    $.ajax({
        url: "search_check_stock.php",
        data: {
            term: $('#check_stock_search_box').val(),
        },
        type: "GET",
        success: function (response) {
            $('#stock_table_body').html('');
			$('#stock_table_body').append(response);
        },
    });
});
</script>