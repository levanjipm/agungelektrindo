<?php
	include('../codes/connect.php');
?>
<style>
	#page{
		width:100px;
	}
</style>
<?php
	if(empty($_GET['term']) && empty($_GET['page'])){
	$sql_count	= "SELECT id FROM stock
					INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) recent_stock 
					ON stock.reference = recent_stock.reference 
					AND stock.id = recent_stock.latest";
	$result_count	= $conn->query($sql_count);
	$count			= mysqli_num_rows($result_count);
	
	$page			= ceil($count / 25);
?>
	<table class='table table-bordered'>
		<tr>
			<th style='width:20%'>Reference</th>
			<th style='width:40%'>Description</th>
			<th style='width:20%'>Stock</th>
			<th style='width:20%'></th>
		</tr>
<?php				
	$sql 		= "SELECT * FROM stock
					INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) recent_stock 
					ON stock.reference = recent_stock.reference 
					AND stock.id = recent_stock.latest 
					ORDER BY stock.reference
					LIMIT 25";
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
	</table>
	<p style='font-family:museo'><?= number_format($count) ?> items found</p>
	<select class='form-control' id='page'>
<?php
	for($i = 1; $i <= $page; $i++){
?>
		<option value='<?= $i - 1 ?>'><?= $i ?></option>
<?php	
	}
?>
	</select>
<?php
	} else if(!empty($_GET['term']) && empty($_GET['page'])){
		$term		= mysqli_real_escape_string($conn,$_GET['term']);
		$sql_count	= "SELECT itemlist.id FROM stock
						INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) recent_stock 
						ON stock.reference = recent_stock.reference 
						AND stock.id = recent_stock.latest
						JOIN itemlist ON itemlist.reference = stock.reference
						WHERE stock.reference LIKE '%$term%' OR itemlist.description LIKE '%$term%'";
		$result_count	= $conn->query($sql_count);
		$count			= mysqli_num_rows($result_count);
		if($count > 0){
?>
	<table class='table table-bordered'>
		<tr>
			<th style='width:20%'>Reference</th>
			<th style='width:40%'>Description</th>
			<th style='width:20%'>Stock</th>
			<th style='width:20%'></th>
		</tr>
<?php
		$page			= ceil($count / 25);
		
		$sql 	= "SELECT itemlist.id, stock.reference, recent_stock.latest, itemlist.description, stock.stock FROM stock
				INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) recent_stock 
				ON stock.reference = recent_stock.reference 
				AND stock.id = recent_stock.latest
				JOIN itemlist ON itemlist.reference = stock.reference
				WHERE stock.reference LIKE '%$term%' OR itemlist.description LIKE '%$term%'
				ORDER BY stock.reference
				LIMIT 25";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
			$reference		= $row['reference'];
			$stock			= $row['stock'];
			$item_id 		= $row['id'];
			$description	= $row['description'];
			$sql_minus		= "SELECT delivery_order.quantity FROM delivery_order 
								JOIN code_delivery_order ON delivery_order.do_id = code_delivery_order.id
								WHERE delivery_order.reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND code_delivery_order.sent = '0'";
			$result_minus	= $conn->query($sql_minus);
			$row_minus		= $result_minus->fetch_assoc();
			
			$minus			= $row_minus['quantity'];
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
	</table>
	<p style='font-family:museo'><?= number_format($count) ?> items found</p>
	<select class='form-control' id='page'>
<?php
	for($i = 1; $i <= $page; $i++){
?>
		<option value='<?= $i - 1 ?>'><?= $i ?></option>
<?php	
	}
?>
	</select>
<?php
		}
	} else if(!empty($_GET['term']) && !empty($_GET['page'])){
		$page_view		= $_GET['page'];
		$term			= mysqli_real_escape_string($conn,$_GET['term']);
		
		$sql_count	= "SELECT itemlist.id FROM stock
						INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) recent_stock 
						ON stock.reference = recent_stock.reference 
						AND stock.id = recent_stock.latest
						JOIN itemlist ON itemlist.reference = stock.reference
						WHERE stock.reference LIKE '%$term%' OR itemlist.description LIKE '%$term%'";
		$result_count	= $conn->query($sql_count);
		$count			= mysqli_num_rows($result_count);
		if($count > 0){
?>
	<table class='table table-bordered'>
		<tr>
			<th style='width:20%'>Reference</th>
			<th style='width:40%'>Description</th>
			<th style='width:20%'>Stock</th>
			<th style='width:20%'></th>
		</tr>
<?php
		$page			= ceil($count / 25);
		$offset			= $page_view * 25;
		
		$sql 	= "SELECT itemlist.id, stock.reference, recent_stock.latest, itemlist.description, stock.stock FROM stock
				INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) recent_stock 
				ON stock.reference = recent_stock.reference 
				AND stock.id = recent_stock.latest
				JOIN itemlist ON itemlist.reference = stock.reference
				WHERE stock.reference LIKE '%$term%' OR itemlist.description LIKE '%$term%'
				ORDER BY stock.reference
				LIMIT 25 OFFSET $offset";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
			$reference		= $row['reference'];
			$stock			= $row['stock'];
			$item_id 		= $row['id'];
			$description	= $row['description'];
			$sql_minus		= "SELECT delivery_order.quantity FROM delivery_order 
								JOIN code_delivery_order ON delivery_order.do_id = code_delivery_order.id
								WHERE delivery_order.reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND code_delivery_order.sent = '0'";
			$result_minus	= $conn->query($sql_minus);
			$row_minus		= $result_minus->fetch_assoc();
			
			$minus			= $row_minus['quantity'];
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
	</table>
	<p style='font-family:museo'><?= number_format($count) ?> items found</p>
	<select class='form-control' id='page'>
<?php
	for($i = 1; $i <= $page; $i++){
?>
		<option value='<?= $i - 1 ?>' <?php if($_GET['page'] == $i - 1){ echo 'selected'; }; ?>><?= $i ?></option>
<?php	
	}
?>
	</select>
<?php
		}
	} else if(empty($_GET['term']) && !empty($_GET['page'])){
		$page_view		= $_GET['page'];
		
		$sql_count	= "SELECT itemlist.id FROM stock
						INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) recent_stock 
						ON stock.reference = recent_stock.reference 
						AND stock.id = recent_stock.latest
						JOIN itemlist ON itemlist.reference = stock.reference";
		$result_count	= $conn->query($sql_count);
		$count			= mysqli_num_rows($result_count);
		if($count > 0){
?>
	<table class='table table-bordered'>
		<tr>
			<th style='width:20%'>Reference</th>
			<th style='width:40%'>Description</th>
			<th style='width:20%'>Stock</th>
			<th style='width:20%'></th>
		</tr>
<?php
		$page			= ceil($count / 25);
		$offset			= $page_view * 25;
		
		$sql 	= "SELECT itemlist.id, stock.reference, recent_stock.latest, itemlist.description, stock.stock FROM stock
				INNER JOIN (SELECT reference,MAX(id) AS latest FROM stock GROUP BY reference ORDER BY id DESC) recent_stock 
				ON stock.reference = recent_stock.reference 
				AND stock.id = recent_stock.latest
				JOIN itemlist ON itemlist.reference = stock.reference
				ORDER BY stock.reference
				LIMIT 25 OFFSET $offset";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
			$reference		= $row['reference'];
			$stock			= $row['stock'];
			$item_id 		= $row['id'];
			$description	= $row['description'];
			$sql_minus		= "SELECT delivery_order.quantity FROM delivery_order 
								JOIN code_delivery_order ON delivery_order.do_id = code_delivery_order.id
								WHERE delivery_order.reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND code_delivery_order.sent = '0'";
			$result_minus	= $conn->query($sql_minus);
			$row_minus		= $result_minus->fetch_assoc();
			
			$minus			= $row_minus['quantity'];
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
	</table>
	<p style='font-family:museo'><?= number_format($count) ?> items found</p>
	<select class='form-control' id='page'>
<?php
	for($i = 1; $i <= $page; $i++){
?>
		<option value='<?= $i - 1 ?>' <?php if($_GET['page'] == $i - 1){ echo 'selected'; }; ?>><?= $i ?></option>
<?php	
	}
?>
	</select>
<?php
		}
	}
?>
<script>
	$('#page').change(function()
	{
		if($('#search_item_bar').val() == ''){
			$.ajax({
				url:'check_stock_view.php',
				data:{
					page:$('#page').val()
				},
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
		} else {
			$.ajax({
				url:'check_stock_view.php',
				data:{
					term:$('#search_item_bar').val(),
					page:$('#page').val()
				},
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
		}
	});
</script>