<?php
	include('../codes/connect.php');
	$year		= $_GET['year'];
	if($_GET['month'] == 0){
?>
	<h3 style='font-family:bebasneue'>Archives of <?= $year ?></h3>
	<div class='row'>
<?php
		$sql		= "SELECT DISTINCT(MONTH(date)) as month FROM code_salesorder WHERE YEAR(date) = '$year' ORDER BY date ASC";
		$result		= $conn->query($sql);
		if(mysqli_num_rows($result) == 0){
?>
		<p style='font-family:museo'>There is no file to view</p>
<?php
		} else {
			while($row	= $result->fetch_assoc()){
				$month	= $row['month'];
?>
		<div class='col-sm-2 col-xs-3' style='padding:25px'>
			<div class='box' onclick='update_sales_order_view(<?= $month ?>,1)'>
				<img src='/agungelektrindo/universal/Images/icons/icons_archives.PNG'></img>
				<p style='font-family:museo;color:white'><?= date('F Y', mktime(0,0,0,$month, 1, $year)) ?></p>
			</div>
		</div>
<?php
			}
		}
	} else {
		$month				= $_GET['month'];
?>
	<input type='hidden' value='<?= $month ?>' id='month'>
	<h3 style='font-family:bebasneue;display:inline-block'>Archives of <?= date('F Y',mktime(0,0,0,$month, 1, $year)) ?></h3> <button type='button' class='button_default_dark' title='Back to <?= $year ?> Archives' onclick='update_sales_order_view(0,1)'><i class='fa fa-undo' style='display:inline-block'></i></button>
	<div class='row'>
<?php
		$sql_count			= "SELECT id FROM code_salesorder WHERE MONTH(date) = '$month' AND YEAR(date) = '$year'";
		$result_count		= $conn->query($sql_count);
		$pages				= ceil(mysqli_num_rows($result_count) / 25);
		
		if(empty($_GET['page'])){
			$page				= 1;
		} else {
			$page				= $_GET['page'];
		}
		
		$offset				= ($page - 1) * 25;
		$sql				= "SELECT code_salesorder.*, customer.name as customer_name
								FROM code_salesorder 
								LEFT JOIN customer ON customer.id = code_salesorder.customer_id
								WHERE MONTH(date) = '$month' AND YEAR(date) = '$year' ORDER BY date ASC LIMIT 25 OFFSET $offset";
		
		$result				= $conn->query($sql);
?>
	<table style='width:100%;padding:10px'>
<?php
		while($row			= $result->fetch_assoc()){
			$id 			= $row['id'];
			$name			= $row['name'];
			$date			= $row['date'];
			$po_number		= $row['po_number'];
			if($po_number	== ''){
				$po_number	= 'Not given';
			}
			$customer_id	= $row['customer_id'];
			if($customer_id == null){
				$customer_name	= $row['retail_name'];
			} else {
				$customer_name	= $row['customer_name'];
			}
?>
		<tr style='border-top:1px solid #424242' onclick='view_sales_order(<?= $id ?>)'>
			<td class='icon_wrapper'>
				<div class='image_wrapper'>
					<img src='/agungelektrindo/universal/Images/icons/icons_archives.PNG' style='width:30%;max-width:200px'></img>
				</div>
			</td>
			<td style='padding:10px'>
				<label><?= $name ?></label>
				<p><i><?= date('d M Y',strtotime($date)) ?></i></p>
				<p style='font-family:museo'><?= $po_number ?></p>
			</td>
		</tr>
<?php
		}
?>
	</table>
	
	<select class='form-control' id='page' style='width:100px'>
<?php
	for($i = 1; $i <= $pages; $i++){
?>
		<option value='<?= $i ?>' <?php if($i == $page){ echo 'selected'; } ?>><?= $i ?></option>
<?php
	}
?>
	</select>
	<form id='sales_order_print_form' method='POST' target='blank' action='sales_order_archive_print'>
		<input type='hidden' id='input_id' name='id'>
	</form>
	<script>
		$('#page').change(function(){
			update_sales_order_view($('#month').val(), $('#page').val());
		});
		
		function view_sales_order(n){
			$('#input_id').val(n);
			$('#sales_order_print_form').submit();
		};
	</script>
	</div>
<?php
	}
?>