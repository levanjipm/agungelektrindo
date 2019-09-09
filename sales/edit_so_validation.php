<?php
	include("../codes/connect.php");
	session_start();
	$sql_user 			= "SELECT name,role,hpp FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user 		= $conn->query($sql_user);
	$row_user 			= $result_user->fetch_assoc();
	$name 				= $row_user['name'];
	
	$po_number			= $_POST['po_number'];
	$po_number_on_input	= mysqli_real_escape_string($conn,$_POST['po_number']);
	$id_so				= $_POST['id_so'];
	$seller				= $_POST['seller'];
	$label				= $_POST['label'];
	
	$sql_code_so		= "SELECT customer_id FROM code_salesorder WHERE id = '" . $id_so . "'";
	$result_code_so		= $conn->query($sql_code_so);
	$code_so			= $result_code_so->fetch_assoc();
	$customer_id		= $code_so['customer_id'];
	
	
	if($customer_id == 0){
		$sql_customer		= "SELECT retail_name, retail_address, retail_city FROM code_salesorder WHERE id = '$id'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['retail_name'];
		$customer_address	= $customer['retail_address'];
		$customer_city		= $customer['retail_city'];
	} else {
		$sql_customer		= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
		echo $sql_customer;
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
	}
	
	$reference_array		= $_POST['reference'];
	$quantity_array			= $_POST['quantity'];
	$price_array			= $_POST['price'];
	$price_list_array		= $_POST['price_list'];
?>
<head>
	<title>Validate Sales Order</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="salesstyle.css">
	<link rel="stylesheet" href="css/create_quotation.css">
</head>
<div class='top_navigation_bar'>
	<div class='col-lg-4 col-md-5 col-sm-6 col-xs-8'>
		<a href='../human_resource/user_dashboard.php' style='text-decoration:none'>
			<img src='../universal/images/agungelektrindo_header.png' style='height:50px;'>
		</a>
	</div>
	<div class='col-lg-2 col-md-3 col-sm-4 col-xs-4 col-lg-offset-6 col-md-offset-4 col-sm-offset-2 col-xs-offset-0' style='text-align:right'>
		<h3 style='font-family:Bebasneue'><?= $name ?> 
			<span style='display:inline-block'>
				<a href='../codes/logout.php' style='padding-left:10px;text-decoration:none;color:white;' title='log out'>
					 <i class="fa fa-sign-out" aria-hidden="true"></i>
				</a>
			</span>
		</h3>
	</div>
</div>
<body style="overflow-x:hidden;">
	<form id='edit_sales_order_form' action='edit_so_input' method='POST'>
		<div class="row" style='height:100%'>
			<div class='col-sm-1' style='background-color:#333'>
			</div>
			<div class='col-sm-10' style='margin-top:70px'>
				<h2 style='font-family:bebasneue'>Sales Order</h2>
				<p>Edit Sales Order</p>
				<hr>
				<h3 style='font-family:bebasneue'><?= $customer_name ?></h3>
				<p><?= $customer_address ?></p>
				<p><?= $customer_city ?></p>
				<label>PO Number</label>
				<p><?= $po_number ?></p>
				<input type='hidden' value='<?= $po_number_on_input ?>' name='po_number'>
<?php
				if($label != '0'){
?>
				<label>Label</label>
				<p><?= $label ?></p>
<?php
				}
?>
				<input type='hidden' value='<?= $label ?>' name='label'>
				<input type='hidden' value='<?= $seller ?>' name='seller'>
				<input type='hidden' value='<?= $id_so ?>' name='id_so'>
				<table class='table table-bordered'>
					<thead>
						<tr>
							<th>Item Desc.</th>
							<th>Reference</th>
							<th>Quantity</th>
							<th>Price list</th>
							<th>Discount</th>
							<th>Net price</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
<?php
					$error				= 0;
					$total_sales_order	= 0;
					foreach($quantity_array as $quantity){
						$key	= key($quantity_array);
						
						$sql_check_quantity = "SELECT sent_quantity FROM sales_order WHERE id = '$key'";
						$result_check_quantity = $conn->query($sql_check_quantity);
						$check_quantity		= $result_check_quantity->fetch_assoc();
						
						$sent_quantity		= $check_quantity['sent_quantity'];
						
						if($quantity > $sent_quantity){
							$error++;
						}

						if(empty($price_array[$key])){
							$sql		= "SELECT price, price_list FROM sales_order WHERE id = '$key'";
							$result		= $conn->query($sql);
							$row		= $result->fetch_assoc();
							
							$price		= $row['price'];
							$price_list	= $row['price_list'];
						} else {
							$price		= $price_array[$key];
							$price_list	= $price_list_array[$key];
						}
						
						$reference		= $reference_array[$key];
						$reference_on_input	= mysqli_real_escape_string($conn,$reference);
						$sql_item		= "SELECT description FROM itemlist WHERE reference = '$reference_on_input'";
						$result_item	= $conn->query($sql_item);
						$item			= $result_item->fetch_assoc();
						$description	= $item['description'];
						
						$discount = 100 * (1 - ($price/ $price_list));
						
						$total			= $quantity * $price;
						$total_sales_order += $total;
?>	
						<tr>
							<td><?= $description ?></td>
							<td>
								<?= $reference ?>
								<input type='hidden' value='<?= $reference ?>' name='reference[<?= $key ?>]'>
							</td>
							<td>
								<?= $quantity ?>
								<input type='hidden' value='<?= $quantity ?>' name='quantity[<?= $key ?>]'>
							</td>
							<td>
								Rp. <?= number_format($price_list,2) ?>
								<input type='hidden' value='<?= $price_list ?>' name='price_list[<?= $key ?>]'>
							</td>
							<td><?= number_format($discount,2) ?>%</td>
							<td>
								Rp. <?= number_format($price,2) ?>
								<input type='hidden' value='<?= $price ?>' name='price[<?= $key ?>]'>
							</td>
							<td>Rp. <?= number_format($total,2) ?></td>
						</tr>
<?php
						next($quantity_array);
					}
					
					if(!empty($_POST['reference_new'])){
						$reference_new_array	= $_POST['reference_new'];
						$quantity_new_array		= $_POST['quantity_new'];
						$price_new_array		= $_POST['price_new'];
						$price_list_new_array	= $_POST['price_list_new'];
						
						$i = 1;
						foreach($reference_new_array as $reference){
							$key = key($reference_new_array);
							$quantity		= $quantity_new_array[$key];
							$price			= $price_new_array[$key];
							$price_list		= $price_list_new_array[$key];
							
							$reference_on_input	= mysqli_real_escape_string($conn,$reference);
							$sql_item		= "SELECT description FROM itemlist WHERE reference = '$reference_on_input'";
							$result_item	= $conn->query($sql_item);
							$item			= $result_item->fetch_assoc();
							$description	= $item['description'];
							
							$discount = 100 * (1 - ($price/ $price_list));
							
							$total			= $quantity * $price;
							$total_sales_order += $total;
?>
						<tr>
							<td><?= $description ?></td>
							<td>
								<?= $reference ?>
								<input type='hidden' value='<?= $reference_on_input ?>' name='reference-[<?= $i ?>]'>
							</td>
							<td>
								<?= $quantity ?>
								<input type='hidden' value='<?= $quantity ?>' name='quantity-[<?= $i ?>]'>
							</td>
							<td>
								Rp. <?= number_format($price_list,2) ?>
								<input type='hidden' value='<?= $price_list ?>' name='price_list-[<?= $i ?>]'>
							</td>
							<td><?= number_format($discount,2) ?>%</td>
							<td>
								Rp. <?= number_format($price,2) ?>
								<input type='hidden' value='<?= $price ?>' name='price-[<?= $i ?>]'>
							</td>
							<td>Rp. <?= number_format($total,2) ?></td>
						</tr>
<?php
							$i++;
						}
					}
?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan='5'></td>
							<td>Total</td>
							<td>Rp. <?= number_format($total_sales_order,2) ?></td>
						</tr>
					</tfoot>
				</table>
				
				<button class='button_default_dark'>Submit</button>
			</div>
			<div class='col-sm-1' style='background-color:#333'></div>
		</div>
	</form>
</body>