<?php
	include('../codes/connect.php');
	session_start();
?>
<script src='/agungelektrindo/universal/jquery/jquery-3.3.0.min.js'></script>
<?php
	$code_sample_id		= $_POST['code_sample_id'];
	$sample_date		= $_POST['send_sample_date'];
	$quantity_array		= $_POST['quantity'];
	$guid				= $_POST['guid'];
	$validation			= true;
	
	$sql_duplicate		= "SELECT id FROM code_sample_delivery_order WHERE guid = '$guid'";
	$result_duplicate	= $conn->query($sql_duplicate);
	if(mysqli_num_rows($result_duplicate) == 0){
		foreach($quantity_array as $quantity){
			$sample_id		= key($quantity_array);
			$sql_check		= "SELECT code_id, reference FROM sample WHERE id = '$sample_id'";
			$result_check	= $conn->query($sql_check);
			$check			= $result_check->fetch_assoc();
			
			$code_sample_id_check	= $check['code_id'];
			$reference				= $check['reference'];
			
			if($code_sample_id_check != $code_sample_id){
				$validation			= false;
			}
			
			$sql_stock		= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn, $reference) . "' ORDER BY id DESC LIMIT 1";
			$result_stock	= $conn->query($sql_stock);
			$row_stock		= $result_stock->fetch_assoc();
			
			$stock			= $row_stock['stock'];
			if($stock		< $quantity){
				$validation			= false;
			}
			
			next($quantity_array);
		}
		
		if($validation){
			$sql_count		= "SELECT id FROM code_sample_delivery_order WHERE YEAR(date) = '$sample_date'";
			$result_count	= $conn->query($sql_count);
			$count			= mysqli_num_rows($result_count);
			
			$nomor			= $count + 1;
			
			$delivery_order_name	= "SJ-AE-SMPL-" . str_pad($nomor,3,"0",STR_PAD_LEFT) . "-" . date('Y',strtotime($sample_date));
			
			$sql			= "INSERT INTO code_sample_delivery_order (date, name, code_sample, guid)
								VALUES ('$sample_date', '$delivery_order_name', '$code_sample_id', '$guid')";
			$result			= $conn->query($sql);
			if($result){
				$sql_get	= "SELECT id FROM code_sample_delivery_order WHERE guid = '$guid'";
				$result_get	= $conn->query($sql_get);
				$get		= $result_get->fetch_assoc();
				
				$id			= $get['id'];
				
				$quantity_array		= $_POST['quantity'];
				foreach($quantity_array as $quantity){
					$sample_id		= key($quantity_array);
					$sql_sample		= "SELECT quantity, sent FROM sample WHERE id = '$sample_id'";
					$result_sample	= $conn->query($sql_sample);
					$sample			= $result_sample->fetch_assoc();
					
					$ordered_sample	= $sample['quantity'];
					$sent_sample	= $sample['sent'];
					$final_quantity	= $sent_sample + $quantity;
					
					if($ordered_sample == $final_quantity){
						$sql_update		= "UPDATE sample SET status = '1', sent = '$final_quantity' WHERE id = '$sample_id'";
					} else {
						$sql_update		= "UPDATE sample SET sent = '$final_quantity' WHERE id = '$sample_id'";
					}
					
					$conn->query($sql_update);
					
					$sql_insert		= "INSERT INTO sample_delivery_order (sample_id, quantity, delivery_order_id)
										VALUES ('$sample_id', '$quantity', '$id')";
					$conn->query($sql_insert);
					
					next($quantity_array);
				}
?>
	<form action='delivery_order_sample_print' method='POST' id='sample_form' target='_blank'>
		<input type='hidden' value='<?= $id ?>' name='id'>
	</form>
	<script>
		$(document).ready(function(){
			$('#sample_form').submit();
		});
	</script>
<?php
			}
		}
	}
?>
<script>
	setTimeout(function(){
		window.location.href='/agungelektrindo/inventory';
	},300);
</script>