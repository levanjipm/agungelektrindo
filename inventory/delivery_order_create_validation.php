<?php
	include("inventoryheader.php");
?>
<div class="main">
<?php
$so_id = $_POST["id"];
$do_date = $_POST['today'];
$customer_id = $_POST['customer_id'];

function GUID()
{
	if (function_exists('com_create_guid') === true)
	{
		return trim(com_create_guid(), '{}');
	}

	return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

$guid = GUID();

switch (date('m',strtotime($do_date))) {
	case "01" :
		$month = 'I';
		break;
	case "02" :
		$month = 'II';
		break;
	case "03" :
		$month = 'III';
		break;
	case "04" :
		$month = 'IV';
		break;
	case "05" :
		$month = 'V';
		break;
	case "06" :
		$month = 'VI';
		break;
	case "07" :
		$month = 'VII';
		break;
	case "08" :
		$month = 'VIII';
		break;
	case "09" :
		$month = 'IX';
		break;
	case "10" :
		$month = 'X';
		break;
	case "11" :
		$month = 'XI';
		break;
	case "12" :
		$month = 'XII';
		break;		
}	
	$taxing 		= $_POST['tax'];
	$sql_number 	= "SELECT * FROM code_delivery_order 
					WHERE MONTH(date) = MONTH('" . $do_date . "') AND YEAR(date) = YEAR('" . $do_date . "') AND number > '0'
					AND isdelete = '0' ORDER BY number ASC";
	$results 		= $conn->query($sql_number);
	if ($results->num_rows > 0){
		$i = 1;
		while($row_do = $results->fetch_assoc()){
			if ($i == $row_do['number']){
				$i++;
				$nomor = $i;
			} else {
				break;
			}
		}
	} else {
		$nomor = 1;
	};
	
	if ($taxing){
		$tax_preview = 'P';
	} else {
		$tax_preview = 'N';
	};
	
	$do_number_preview 		= "SJ-AE-" . str_pad($nomor,2,"0",STR_PAD_LEFT) . $tax_preview . "." . date("d",strtotime($do_date)). "-" . $month. "-" . date("y",strtotime($do_date));
	$sql 					= "SELECT * FROM code_salesorder WHERE id = '" . $so_id . "'";
	$result 				= $conn->query($sql);
	$row 					= $result->fetch_assoc();
	$po_number 				= $row['po_number'];
	$customer_id 			= $row['customer_id'];
	
	if($customer_id != 0){
		$sql_customer		= "SELECT name,address,city FROM customer WHERE id = '" . $customer_id . "'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		$name 				= $customer['name'];
		$address 			= $customer['address'];
		$city 				= $customer['city'];
	} else {
		$name 				= $row['retail_name'];
		$address 			= $row['retail_address'];
		$city 				= $row['retail_city'];
	}
?>
	<form method="POST" action="delivery_order_create_input" id='delivery_order_form'>
		<input type="hidden" 	value="<?= $so_id ?>" 		name="so_id">
		<input type="hidden" 	value="<?= $customer_id ?>" name="customer">
		<input type="hidden" 	value="<?= $taxing ?>" 		name="tax">
		<input type="hidden" 	value="<?= $do_date ?>" 	name="do_date">
		<input type="hidden" 	value="<?= $nomor ?>" 		name="do_number">
		<div class="row">
			<div class="col-sm-2">
				<img src="../universal/images/logogudang.jpg" style="width:100%;height:auto">
			</div>
			<div class="col-sm-5" style="line-height:0.6">
				<h3><b>Agung Elektrindo</b></h3>
				<p>Jalan Jamuju no. 18,</p>
				<p>Bandung, 40114</p>
				<p><b>Ph.</b>(022) - 7202747 <b>Fax</b>(022) - 7212156</p>
				<p><b>Email :</b>AgungElektrindo@gmail.com</p>
			</div>
			<div class="col-sm-4 offset-sm-1" style="padding:20px">
				<div class="col-sm-3">
					<p><b>Tanggal:</b></p>
				</div>
				<div class="col-sm-6"><?php echo date('d M Y',strtotime($do_date));?></div>
				<div class="col-sm-12">
					<p>Kepada Yth. <b><?= $name ?></b></p>
					<p><?= $address ?></p>
					<p><?= $city ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class='col-sm-12'>
				<label>DO Number</label>
				<p><?= $do_number_preview ?></p>
				<input type="hidden" name="do_name" value="<?= $do_number_preview ?>">
				<label>PO Number</label>
				<p><?= $po_number ?></p>
				<input type="hidden" name="po_number" value="<?= $po_number ?>">
				<label>Unique GUID</label>
				<p><?= $guid ?></p>
				<input type='hidden' value='<?= $guid ?>' name='guid'>
			</div>
		</div>
		<table class="table table-bordered">
			<thead>
				<th style="width:40%">Item name </th>
				<th style="width:30%">Reference</th>
				<th style="width:30%">Quantity</th>
			</thead>
			<tbody>
<?php
		$reference_array 		= $_POST['reference'];
		$quantity_array			= $_POST['quantity'];
		$i						= 1;
		
		foreach($reference_array as $reference){
			$key 				= key($reference_array);
			$quantity			= $quantity_array[$key];
			
			//Check if user changes the validation in front-end security//			
			$sql_check 			= "SELECT quantity, sent_quantity FROM sales_order WHERE so_id = '" . $so_id . "' AND reference = '" . $reference . "'";
			$result_check 		= $conn->query($sql_check);
			$check 				= $result_check->fetch_assoc();
			$quantity_ordered	= $check['quantity'];
			$quantity_sent		= $check['sent_quantity'];
			
			if($quantity + $quantity_sent > $quantity_ordered){
?>
<script>
	window.location.href='delivery_order_create';
</script>
<?php
			}
			$sql_item 			= "SELECT description FROM itemlist WHERE reference = '" . $reference . "'";
			$result 			= $conn->query($sql_item);
			if ($result->num_rows > 0){
				$row_item 		= $result->fetch_assoc();
				$item_description = $row_item['description'];
			} else {
				$item_description = '';
			};
?>
			<tr>
				<td><?= $item_description ?></td>
				<td>
					<?= $reference ?>
					<input type="hidden" name="reference[<?= $key ?>]" value="<?= $reference ?>">
				</td>
				<td>
					<?=$quantity?>
					<input type="hidden" name="quantity[<?= $key ?>]" value="<?= $quantity ?>">
				</td>
			</tr>
<?php
			next($reference_array);
		}
?>
			</tbody>
		</table>
		<br><br>
		<button type="button" class="button_default_dark" id='submit_delivery_order_button'>Next</button>
	</form>
</div>
<script>
$('#submit_delivery_order_button').click(function(){
	$('#delivery_order_form').submit();
});
</script>