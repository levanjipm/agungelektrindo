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
				AND stock.id = recent_stock.latest LIMIT 25";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
			$reference		= $row['reference'];
			$stock			= $row['stock'];
			
			$sql_item 		= "SELECT id,description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item 	= $conn->query($sql_item);
			$item	 		= $result_item->fetch_assoc();
			
			$sql_minus		= "SELECT delivery_order.quantity FROM delivery_order 
								JOIN code_delivery_order ON delivery_order.do_id = code_delivery_order.id
								WHERE delivery_order.reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND code_delivery_order.sent = '0'";
			$result_minus	= $conn->query($sql_minus);
			$row_minus		= $result_minus->fetch_assoc();
			
			$minus			= $row_minus['quantity'];
			
			$item_id 		= $item['id'];
			$description	= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= number_format($stock - $minus) ?></td>
				<td>
					<a href='stock_card?id=<?= $item_id ?>'>
						<button type='button' class='button_success_dark'><i class="fa fa-eye" aria-hidden="true"></i></button>
					</a>
				</td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
</div>
<script>
$(document).ready(function(){
	$('#search_item_bar').focus();
});

$('#search_item_bar').change(function () {
    $.ajax({
        url: "check_stock_search.php",
        data: {
            term: $('#search_item_bar').val()
        },
        type: "GET",
		beforeSend:function(){
			$('.loading_wrapper_initial').fadeIn();
			$('#search_item_bar').attr('disabled',true);
			$('#check_stock_table').html('');
		},
        success: function (response) {
			$('.loading_wrapper_initial').fadeOut();
			$('#search_item_bar').attr('disabled',false);
            $('#check_stock_table').append(response);
        },
    });
});
</script>