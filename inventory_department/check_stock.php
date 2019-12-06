<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Check stock</title>
</head>
<style>
	input[type=text] {
		width: 130px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
		padding:10px;
	}
	
	input[type=text]:focus {
		width: 100%;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Check Stock</h2>
	<hr>
	<input type="text" id="search_item_bar" placeholder="Search..">
	<br><br>
	<table class='table table-bordered'>
		<tr>
			<th style='width:20%'>Reference</th>
			<th style='width:40%'>Description</th>
			<th style='width:20%'>Stock</th>
			<th style='width:20%'></th>
		</tr>
		<tbody id='check_stock_table'>
<?php
		$sql 	= "SELECT * FROM stock
				INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) recent_stock 
				ON stock.reference = recent_stock.reference 
				AND stock.id = recent_stock.latest LIMIT 50";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
			$reference		= $row['reference'];
			$stock			= $row['stock'];
			
			$sql_item 		= "SELECT id,description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item 	= $conn->query($sql_item);
			$item	 		= $result_item->fetch_assoc();
			
			$item_id 		= $item['id'];
			$description	= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= $stock ?></td>
				<td>
					<a href='stock_card?id=<?= $item_id ?>'>
						<button type='button' class='button_success_dark'><i class="fa fa-eye" aria-hidden="true"></i></button>
					</a>
				</td>
				
				<form id='form<?= $item_id ?>' action='stock_card' method='POST'>
					<input type='hidden' value='<?= $item_id ?>' name='item_id'>
				</form>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
</div>
<script>
$('#search_item_bar').change(function () {
    $.ajax({
        url: "ajax/search_check_stock.php",
        data: {
            term: $('#search_item_bar').val()
        },
        type: "GET",
		beforeSend:function(){
			$('#search_item_bar').attr('disabled',true);
			$('#check_stock_table').html('');
		},
        success: function (response) {
			$('#search_item_bar').attr('disabled',false);
            $('#check_stock_table').append(response);
        },
    });
});
</script>