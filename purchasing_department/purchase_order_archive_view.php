<?php
	include('../codes/connect.php');
	$year		= $_GET['year'];
	if($_GET['month'] == 0){
?>
	<h3 style='font-family:bebasneue'>Archives of <?= $year ?></h3>
	<div class='row'>
<?php
		$sql		= "SELECT DISTINCT(MONTH(date)) as month FROM code_purchaseorder WHERE YEAR(date) = '$year' ORDER BY date ASC";
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
			<div class='box' onclick='update_purchase_order_view(<?= $month ?>,1)'>
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
	<h3 style='font-family:bebasneue;display:inline-block'>Archives of <?= date('F Y',mktime(0,0,0,$month, 1, $year)) ?></h3> <button type='button' class='button_default_dark' title='Back to <?= $year ?> Archives' onclick='update_purchase_order_view(0,1)'><i class='fa fa-undo' style='display:inline-block'></i></button>
	<div class='row'>
<?php
		$sql_count			= "SELECT id FROM code_purchaseorder WHERE MONTH(date) = '$month' AND YEAR(date) = '$year'";
		$result_count		= $conn->query($sql_count);
		$pages				= ceil(mysqli_num_rows($result_count) / 25);
		
		if(empty($_GET['page'])){
			$page				= 1;
		} else {
			$page				= $_GET['page'];
		}
		
		$offset				= ($page - 1) * 25;
		$sql				= "SELECT code_purchaseorder.id, code_purchaseorder.name, code_purchaseorder.date, supplier.name as supplier_name, closed_purchaseorder.closed_date
								FROM code_purchaseorder 
								LEFT JOIN closed_purchaseorder ON closed_purchaseorder.purchaseorder_id = code_purchaseorder.id
								JOIN supplier ON supplier.id = code_purchaseorder.supplier_id
								WHERE MONTH(code_purchaseorder.date) = '$month' AND YEAR(code_purchaseorder.date) = '$year' 
								ORDER BY code_purchaseorder.date ASC LIMIT 25 OFFSET $offset";
		$result				= $conn->query($sql);
?>
	<table style='width:100%;padding:10px'>
<?php
		while($row			= $result->fetch_assoc()){
			$id 			= $row['id'];
			$name			= $row['name'];
			$date			= $row['date'];
			$closed_date	= $row['closed_date'];
			$supplier_name	= $row['supplier_name'];
			
			$sql_done		= "SELECT
								  COALESCE(SUM(CASE WHEN status = '0' THEN quantity ELSE 0 END ), 0) as  Not_sent,
								  COALESCE(SUM(CASE WHEN status = '1' THEN quantity ELSE 0 END ), 0) as  Sent
							FROM purchaseorder 
							WHERE purchaseorder_id = '$id' 
							LIMIT 1";
			$result_done	= $conn->query($sql_done);
			$done			= $result_done->fetch_assoc();
			
			$sent			= $done['Sent'];
			$not_sent		= $done['Not_sent'];
			$quantity		= $sent + $not_sent;
			
			if($quantity	== 0){
				$bar_width	= 0;
			} else {
				$bar_width		= ($sent / $quantity) * 100;
			}
?>
		<tr style='border-top:1px solid #424242' onclick="window.location.href='/agungelektrindo/purchasing_department/purchase_order_archive_print.php?id=<?= $id ?>'">
			<td class='icon_wrapper'>
				<div class='image_wrapper'>
					<img src='/agungelektrindo/universal/Images/icons/icons_archives.PNG' style='width:30%;max-width:200px'></img>
				</div>
			</td>
			<td style='padding:10px'>
				<label><?= $name ?> <?php if($closed_date != ''){ echo '( Closed on ' . date('d M Y',strtotime($closed_date)) . ' )'; } ?></label>
				<p><i><?= date('d M Y',strtotime($date)) ?></i></p>
				<p style='font-family:museo'><?= $supplier_name ?></p>
				<p style='font-family:museo;text-align:right'><?= number_format($bar_width,2) ?>% completed</p>
				<div class='progress_bar_wrapper'>
					<div class='progress_bar' bar='<?= $bar_width ?>%' id='bar-<?= $id ?>'></div>
				</div>
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
	<form id='purchase_order_print_form' method='POST' target='_blank' action='purchase_order_archive_print'>
		<input type='hidden' id='input_id' name='id'>
	</form>
	<script>
		$('#page').change(function(){
			update_purchase_order_view($('#month').val(), $('#page').val());
		});
		
		function view_purchase_order(n){
			$('#input_id').val(n);
			$('#purchase_order_print_form').submit();
		};
		
		$('.progress_bar').each(function(){
			var width		= $(this).attr('bar');
			$(this).animate({
				width: width
			}, 450);
		});
	</script>
	</div>
<?php
	}
?>