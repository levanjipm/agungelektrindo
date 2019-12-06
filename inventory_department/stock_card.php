<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	$sql_item 			= "SELECT reference,description FROM itemlist WHERE id = '" . $_GET['id'] . "'";
	$result_item 		= $conn->query($sql_item);
	$item 				= $result_item->fetch_assoc();
	$reference 			= $item['reference'];
	$description 		= $item['description'];
		
	$sql_count_data		= "SELECT id FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
	$result_count		= $conn->query($sql_count_data);
		
	$count				= mysqli_num_rows($result_count);
?>
	<div class='main'>
		<h2 style='font-family:bebasneue'><?= $reference ?></h2>
		<p><?= $description ?></p>
		<a href='check_stock'>
			<button type='button' class='button_danger_dark'>Back</button>
		</a>
		<button type='button' class='button_success_dark' title='Calculate safety stock' id='safety_stock_button'><i class="fa fa-calculator" aria-hidden="true"></i></button>
		<br>
		<br>
		<table class='table'>
			<tr>
				<th>Date</th>
				<th>Customer/Supplier</th>
				<th>Document</th>
				<th>In</th>
				<th>Out</th>
				<th>Stock</th>
			</tr>
			<tbody id='stock_table_body'>
<?php
	$sql_stock 		= "SELECT * FROM stock WHERE reference = '" . $reference . "' ORDER BY id ASC";
	$result_stock 	= $conn->query($sql_stock);
	while($stock 	= $result_stock->fetch_assoc()){
		if($stock['transaction'] == 'IN'){
			if($stock['supplier_id'] == 0 && $stock['customer_id'] != 0){
				$sql_name = "SELECT name FROM customer WHERE id = '" . $stock['customer_id'] . "'";
			} else if($stock['supplier_id'] != 0 && $stock['customer_id'] == 0){
				$sql_name = "SELECT name FROM supplier WHERE id = '" . $stock['supplier_id'] . "'";
			} else {
				$sql_name = "";
			}
?>
				<tr>
					<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
					<td><?php
						if($sql_name == ""){
							echo ('Internal transaction');
						} else {
							$result_name = $conn->query($sql_name);
							$name = $result_name->fetch_assoc();
							echo $name['name'];
						}
					?></td>
					<td><?= $stock['document']; ?></td>
					<td><?= $stock['quantity'] ?></td>
					<td></td>
					<td><?= $stock['stock'] ?></td>
				</tr>
<?php
		} else if($stock['transaction'] == 'OUT'){
?>
				<tr>
					<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
					<td><?php
						$sql_customer = "SELECT name FROM customer WHERE id = '" . $stock['customer_id'] . "'";
						$result_customer = $conn->query($sql_customer);
						$customer = $result_customer->fetch_assoc();
						echo $customer['name']; 
					?></td>
					<td><?= $stock['document']; ?></td>
					<td></td>
					<td><?= $stock['quantity'] ?></td>
					<td><?= $stock['stock'] ?></td>
				</tr>
<?php
		} else if($stock['transaction'] == 'FOU'){
?>
				<tr>
					<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
					<td></td>
					<td>Found Goods</td>
					<td><?= $stock['quantity'] ?></td>
					<td></td>
					<td><?= $stock['stock'] ?></td>
				</tr>
<?php
		} else if($stock['transaction'] == 'LOS'){
?>
				<tr>
					<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
					<td></td>
					<td>Lost Goods</td>
					<td></td>
					<td><?= $stock['quantity'] ?></td>
					<td><?= $stock['stock'] ?></td>
				</tr>
<?php
		}		
	}
?>
			</tbody>
		</table>
		<div class='row'>
			<div class='col-xs-12' style='text-align:center'>
				<button type='button' class='button_default_dark' id='load_older_stock_button'>Load older data</button>
				<input type='hidden' value='10' id='count_data'>
			</div>
		</div>
	</div>
</div>
<div class='full_screen_wrapper'>
	<button type='button' class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	$(document).ready(function(){
		var count		= parseInt($('#count_data').val());
		var offset		= parseInt(count + 10);
		if(offset >= <?= $count ?>){
			$('#load_older_stock_button').hide();
		}
	});

	$('#load_older_stock_button').click(function(){
		var count		= parseInt($('#count_data').val());
		var offset		= parseInt(count + 10);
		$.ajax({
			url:'stock_card_old',
			data:{
				item_id: <?= $_GET['id'] ?>,
				offset: offset,
			},
			beforeSend:function(){
				$('#stock_table_body').html('');
				if(offset >= <?= $count ?>){
					$('#load_older_stock_button').hide();
				}
			},
			success:function(response){
				$('#count_data').val(offset);
				$('#stock_table_body').html(response);
				setTimeout(function(){
					$("html, body").animate({ scrollTop: $(document).height() }, 500);
				},200);
			},
			type:'POST',
		})
	})
	
	$('#safety_stock_button').click(function(){
		$('.full_screen_box').html("<h1 style='font-size:6em;color:#333;text-align:center'><i class='fa fa-spinner fa-spin' aria-hidden='true'></i></h1>");
		$('.full_screen_wrapper').fadeIn(300);
	});
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
	});
</script>