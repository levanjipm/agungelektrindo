<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
	$nilai 				= 1;
	$supplier_id 		= $_POST['supplier'];
	$date				= $_POST['date'];
	$sql_supplier 		= "SELECT name,address,city FROM supplier WHERE id = '". $supplier_id . "'";
	$result_supplier 	= $conn->query($sql_supplier);
	$supplier 			= $result_supplier->fetch_assoc();
	
	$supplier_name		= $supplier['name'];
	$supplier_address	= $supplier['address'];
	$supplier_city		= $supplier['city'];
	
	$reference_array	= $_POST['reference'];
	$quantity_array		= $_POST['quantity'];
	
	foreach($reference_array as $reference){
		$key					= key($reference_array);
		$quantity				= $quantity_array[$key];
		$sql_check_reference 	= "SELECT id FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_check_reference	= $conn->query($sql_check_reference);
		$check_reference		= mysqli_num_rows($result_check_reference);
		
		if($check_reference 	== 0){
			$nilai				= 2;
			break;
		}
		
		$sql_check_stock 		= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY id DESC LIMIT 1";
		$result_check_stock 	= $conn->query($sql_check_stock);
		$stock 					= $result_check_stock->fetch_assoc();
		if($stock['stock'] < $quantity){
			$nilai 				= 2;
			break;
		}
		
		next($reference_array);
	}
	
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	$guid	= GUID();
?>
<head>
	<title>Purchasing return validation</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Purchasing return</p>
	<hr>
<?php
	if($nilai == 1){
		$reference_array	= $_POST['reference'];
		$quantity_array		= $_POST['quantity'];
		$i					= 1;
?>
	<label>Supplier data</label>
	<p style='font-family:museo'><?= $supplier_name ?></h3>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	<form action='return_create_input' method='POST' id='return_form'>
		<input type='hidden' value='<?= $supplier_id ?>' name='supplier'>
		<input type='hidden' value='<?= $date ?>' name='date'>
		<input type='hidden' value='<?= $guid ?>' name='guid'>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th colspan='2'>Description</th>
				<th colspan='2'>Quantity</th>
<?php
		foreach($reference_array as $reference){
			$key				= key($reference_array);
			$quantity			= $quantity_array[$key];
			$sql_item 			= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item 		= $conn->query($sql_item);
			$item 				= $result_item->fetch_assoc();
			
			$item_description	= $item['description'];
?>
		<tr>
			<td>
				<?= $reference ?></td>
				<input type='hidden' value='<?= mysqli_real_escape_string($conn,$reference) ?>' name='reference[<?= $i ?>]'>
			</td>
			<td colspan='2'><?= $item_description ?></td>
			<td colspan='2'>
				<?= $quantity ?>
				<input type='hidden' value='<?= $quantity ?>' name='quantity[<?= $i ?>]'>
			</td>
		</tr>
		<tr>
			<td><strong>Date</strong></td>
			<td><strong>Supplier</strong></td>
			<td><strong>Quantity</strong></td>
			<td><strong>Price</strong></td>
			<td><input type="radio" id='check<?= $i ?>' name='radio-<?= $i ?>' onchange='insert_manual_price(<?= $i ?>)' checked>Insert manually</td>
		</tr>
		<tr id='manual_tr<?= $i ?>'>
			<td colspan='3'></td>
			<td colspan='2'><input type='number' class='form-control' id='manual_price<?= $i ?>' name='manual_price[<?= $i ?>]' onkeyup='change_to_manual_price(<?= $i ?>)'></td>
		</tr>
		<tbody id='automatic<?= $i ?>'>
<?php
			$sql_value 				= "SELECT * FROM stock_value_in WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND date >= '" . date('Y-m-d',strtotime('-2 year')) . "' AND sisa > 0 ORDER BY date DESC";
			$result_value 			= $conn->query($sql_value);
			while($value 			= $result_value->fetch_assoc()){
				$sql_supplier_in 	= "SELECT name,id FROM supplier WHERE id = '" . $value['supplier_id'] . "'";
				$result_supplier_in = $conn->query($sql_supplier_in);
				$supplier_in 		= $result_supplier_in->fetch_assoc();
				$supplier_in_name	= $supplier_in['name'];
?>
			<tr>
				<td><?= (date('d M Y',strtotime($value['date']))); ?></td>
				<td><?php
					if($value['supplier_id'] == 0){
						echo ("Stock awal");
					} else {
						echo $supplier_in_name;
					}
				?></td>
				<td><?= $value['quantity'] ?></td>
				<td style='width:20%'>Rp. <?= number_format($value['price'],2) ?></td>
				<td><input type='radio' value='<?= $value['price'] ?>' id='radio-<?= $i ?>' name='radio-<?= $i ?>'>Pick</td>
			</tr>
<?php
			}
?>
		</tbody>
<?php
			next($reference_array);
			$i++;
		}
?>
	</table>
	<hr>
	<button type='button' class='button_default_dark' onclick='submiting()'>Submit</button>
<?php
	}
?>
<script>
	function insert_manual_price(n){
		$('#manual_price' + n).val('');
		
	}
	
	function change_to_manual_price(n){
		$('#check' + n).prop('checked',true);
	}
	
	$('input[id^="radio-"]').change(function(){
		var uid					= parseInt($(this).attr('id').substring(6,8));
		$('#manual_price' + uid).val($(this).val());
	});
	
	function submiting(){
		var	validate_form		= true;
		$('input[id^="manual_price"]').each(function(){
			if($(this).val() == ''){
				validate_form	= false;
				return false;
			}
		});
		
		if(validate_form){
			$('#return_form').submit();
		} else {
			alert('Please check your inputs!');
			return false;
		}
	};
</script>