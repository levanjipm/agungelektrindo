<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
	
	if(empty($_POST['id'])){
?>
		<script>
			window.location.href='invoice_create_dashboard';
		</script>
<?php
	}
	
	$invoice_id			= $_POST['id'];
	$sql_get			= "SELECT do_id FROM invoices WHERE id = '$invoice_id'";
	$result_get			= $conn->query($sql_get);
	$get				= $result_get->fetch_assoc();
	
	$delivery_order_id	= $get['do_id'];
?>
	<div class='main'>
		<h2 style='font-family:bebasneue'>Invoice</h2>
		<p style='font-family:museo'>Confirm sales invoice</p>
		<hr>
		<form method="POST" action='delete_invoice_input' id='delete_invoice_form'>
			<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
		</form>
<?php
	$sql						= "SELECT code_delivery_order.project_id, code_salesorder.type FROM code_delivery_order
									JOIN code_salesorder ON code_delivery_order.so_id = code_salesorder.id
									WHERE code_delivery_order.id = '$delivery_order_id'";
	$result						= $conn->query($sql);
	$row						= $result->fetch_assoc();
	
	$project_id					= $row['project_id'];
	$type						= $row['type'];
	
	if($project_id == NULL && $type == 'GOOD'){
		$case					= 'good';
	} else if($project_id == NULL && $type == 'SRVC'){
		$case					= 'service';
	} else {
		$case					= 'project';
	}
	
	switch ($case) {
		case 'good':
		$sql						= "SELECT date, name, customer_id, so_id FROM code_delivery_order WHERE id = '$delivery_order_id'";
		$result						= $conn->query($sql);
		$row						= $result->fetch_assoc();
			
		$customer_id				= $row['customer_id'];
		$delivery_order_name		= $row['name'];
		$delivery_order_date		= $row['date'];
		$sales_order_id				= $row['so_id'];
		
		$sql_customer				= "SELECT * FROM customer WHERE id = '$customer_id'";
		$result_customer			= $conn->query($sql_customer);
		$customer_count				= mysqli_num_rows($result_customer);
		
		if($customer_count			> 0){
			$sql_customer			= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
			$result_customer		= $conn->query($sql_customer);
			
			$customer				= $result_customer->fetch_assoc();
			
			$customer_name			= $customer['name'];
			$customer_address		= $customer['address'];
			$customer_city			= $customer['city'];
			
			$sql_taxing				= "SELECT taxing FROM code_salesorder WHERE id = '$sales_order_id'";
			$result_taxing			= $conn->query($sql_taxing);
			$row_taxing				= $result_taxing->fetch_assoc();
			
			$taxing					= $row_taxing['taxing'];
		} else {
			$sql_customer			= "SELECT taxing, retail_name, retail_address, retail_city FROM code_salesorder WHERE id = '$sales_order_id'";
			$result_customer		= $conn->query($sql_customer);
			$customer				= $result_customer->fetch_assoc();
			
			$customer_name			= $customer['retail_name'];
			$customer_address		= $customer['retail_address'];
			$customer_city			= $customer['retail_city'];
			
			$taxing					= $customer['taxing'];
		}
?>
		<label>Delivery order</label>
		<p style='font-family:museo'><?= date('d M Y',strtotime($delivery_order_date)) ?></p>
		<p style='font-family:museo'><?= $delivery_order_name ?></p>
		
		<label>Customer</label>
		<p style='font-family:museo'><?= $customer_name ?></p>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>
		
		<form method="POST" action='confirm_invoice_input' id='confirm_invoice_form'>
			<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
<?php
			if($taxing == 1){
?>
			<label>Input nomor faktur pajak</label>
			<input type='text' class='form-control' id='piash' name='faktur' required />
			<script>
				$('#piash').inputmask("999.999-99.99999999");
			</script>
<?php
			}
?>
		</form>
		<hr>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Unit price</th>
				<th>Total price</th>
			</tr>
<?php
		$invoice_total			= 0;
		
		
		$sql_invoice				= "SELECT down_payment, ongkir FROM invoices WHERE id = '$invoice_id'";
		$result_invoice				= $conn->query($sql_invoice);
		$invoice					= $result_invoice->fetch_assoc();
				
		$down_payment				= $invoice['down_payment'];
		$delivery_fee				= $invoice['ongkir'];
		
		$sql_detail					= "SELECT * FROM delivery_order WHERE do_id = '$delivery_order_id'";
		$result_detail				= $conn->query($sql_detail);
		while($detail				= $result_detail->fetch_assoc()){
			$reference				= $detail['reference'];
			$quantity				= $detail['quantity'];
			$billed_price			= $detail['billed_price'];
				
			$sql_item				= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item			= $conn->query($sql_item);
			$item					= $result_item->fetch_assoc();
				
			$total_price			= $billed_price * $quantity;
				
			$description			= $item['description'];
			$invoice_total			+= $total_price;
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= number_format($quantity,0) ?></td>
				<td><?php
					if($taxing == 1){
						echo ('Rp. ' . number_format($billed_price * 10 / 11,2));
					} else {
						echo ('Rp. ' . number_format($billed_price,2));
					}
				?></td>
				<td><?php
					if($taxing == 1){
						echo ('Rp. ' . number_format($total_price * 10 / 11,2));
					} else {
						echo ('Rp. ' . number_format($total_price,2));
					}
				?></td>
			</tr>
<?php
		}
		if($taxing == 1){
?>
			<tr>
				<td colspan='3'></td>
				<td>Sub total</td>
				<td>Rp. <?= number_format($invoice_total * 10 / 11,2) ?></td>
			</tr>
			<tr>
				<td colspan='3'></td>
				<td>PPn 10%</td>
				<td>Rp. <?= number_format($invoice_total * 1 / 11,2) ?></td>
			</tr>
			<tr>
				<td colspan='3'></td>
				<td>Total</td>
				<td>Rp. <?= number_format($invoice_total,2) ?></td>
			</tr>
<?php
		} else {
?>
			<tr>
				<td colspan='3'></td>
				<td>Total</td>
				<td>Rp. <?= number_format($invoice_total,2) ?></td>
			</tr>
<?php
		}
?>
			<tr>
				<td colspan='3'></td>
				<td>Ongkos kirim</td>
				<td>Rp. <?= number_format($delivery_fee,2) ?></td>
			</tr>
			<tr>
				<td colspan='3'></td>
				<td>Down payment</td>
				<td>Rp. <?= number_format($down_payment,2) ?></td>
			</tr>
			<tr>
				<td colspan='3'></td>
				<td>Grand total</td>
				<td>Rp. <?= number_format($invoice_total + $delivery_fee - $down_payment,2) ?></td>
			</tr>
		</table>
		<button type='button' class='button_danger_dark' id='delete_invoice'>Cancel</button>
		<button type='button' class='button_success_dark' id='confirm_invoice'>Submit</button>
		<script>
			$('#delete_invoice').click(function(){
				$('#delete_invoice_form').submit();
			});
			
			$('#confirm_invoice').click(function(){
				$('#confirm_invoice_form').submit();
			});
		</script>
<?php
		break;
		case 'project':
		$sql						= "SELECT date, name, customer_id, project_id FROM code_delivery_order WHERE id = '$delivery_order_id'";
		$result						= $conn->query($sql);
		$row						= $result->fetch_assoc();
			
		$customer_id				= $row['customer_id'];
		$delivery_order_name		= $row['name'];
		$delivery_order_date		= $row['date'];
		$project_id					= $row['project_id'];
		
		$sql_project				= "SELECT * FROM code_project WHERE id = '$project_id'";
		$result_project				= $conn->query($sql_project);
		$project					= $result_project->fetch_assoc();
		
		$project_name				= $project['project_name'];
		$project_description		= $project['description'];
		$po_number					= $project['po_number'];
		
		$sql_customer				= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
		$result_customer			= $conn->query($sql_customer);
			
		$customer					= $result_customer->fetch_assoc();
			
		$customer_name				= $customer['name'];
		$customer_address			= $customer['address'];
		$customer_city				= $customer['city'];
		
		$sql_invoice				= "SELECT value, down_payment, ongkir FROM invoices WHERE id = '$invoice_id'";
		$result_invoice				= $conn->query($sql_invoice);
		$invoice					= $result_invoice->fetch_assoc();
				
		$down_payment				= $invoice['down_payment'];
		$delivery_fee				= $invoice['ongkir'];
		$value						= $invoice['value'];
?>
		<label>Delivery order</label>
		<p style='font-family:museo'><?= date('d M Y',strtotime($delivery_order_date)) ?></p>
		<p style='font-family:museo'><?= $delivery_order_name ?></p>
		
		<label>Purchase order</label>
		<p style='font-family:museo'><?= $po_number ?></p>
		
		<label>Customer</label>
		<p style='font-family:museo'><?= $customer_name ?></p>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>
		<hr>
		
		<form method="POST" action='confirm_invoice_input' id='confirm_invoice_form'>
			<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
<?php
			if($taxing == 1){
?>
			<label>Input nomor faktur pajak</label>
			<input type='text' class='form-control' id='piash' name='faktur' required />
			<script>
				$('#piash').inputmask("999.999-99.99999999");
			</script>
			<br>
<?php
			}
?>
		</form>
		<table class='table table-bordered'>
			<tr>
				<th style='text-align:center'>Nama barang</th>
				<th style='text-align:center'>Qty.</th>
				<th>Price</th>
			</tr>
			<tr>
				<td>
					<p><?= $project_name ?></p>
					<p>(<?= $project_description ?>)</p>
				</td>
				<td>1</td>
				<td>Rp. <?= number_format($value,2) ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Total</td>
				<td>Rp. <?= number_format($value,2) ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Ongkos kirim</td>
				<td>Rp. <?= number_format($delivery_fee,2) ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Down payment</td>
				<td>Rp. <?= number_format($down_payment,2) ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Grand total</td>
				<td>Rp. <?= number_format($value + $delivery_fee - $down_payment,2) ?></td>
			</tr>
		</table>
		<button type='button' class='button_danger_dark' id='delete_invoice'>Cancel</button>
		<button type='button' class='button_success_dark' id='confirm_invoice'>Submit</button>
		<script>
			$('#delete_invoice').click(function(){
				$('#delete_invoice_form').submit();
			});
			
			$('#confirm_invoice').click(function(){
				$('#confirm_invoice_form').submit();
			});
		</script>
<?php
		break;
		case 'service':
		$sql					= "SELECT date, name, customer_id, so_id FROM code_delivery_order WHERE id = '$delivery_order_id'";
		$result					= $conn->query($sql);
		$row					= $result->fetch_assoc();
		
		$customer_id			= $row['customer_id'];
		$delivery_order_name	= $row['name'];
		$delivery_order_date	= $row['date'];
		
		$sales_order_id			= $row['so_id'];
		
		$sql_customer			= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
		$result_customer		= $conn->query($sql_customer);
		
		$customer				= $result_customer->fetch_assoc();
		
		$customer_name			= $customer['name'];
		$customer_address		= $customer['address'];
		$customer_city			= $customer['city'];
		
		$sql_taxing				= "SELECT taxing FROM code_salesorder WHERE id = '$sales_order_id'";
		$result_taxing			= $conn->query($sql_taxing);
		$row_taxing				= $result_taxing->fetch_assoc();
		
		$taxing					= $row_taxing['taxing'];
?>
		<label>Delivery order</label>
		<p style='font-family:museo'><?= date('d M Y',strtotime($delivery_order_date)) ?></p>
		<p style='font-family:museo'><?= $delivery_order_name ?></p>
		
		<label>Customer</label>
		<p style='font-family:museo'><?= $customer_name ?></p>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>
		<hr>
		<form method="POST" action='confirm_invoice_input' id='confirm_invoice_form'>
			<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
<?php
			if($taxing == 1){
?>
			<label>Input nomor faktur pajak</label>
			<input type='text' class='form-control' id='piash' name='faktur' required />
			<script>
				$('#piash').inputmask("999.999-99.99999999");
			</script>
			<br>
<?php
			}
?>
		</form>
		<table class='table table-bordered'>
			<tr>
				<th>Service name</th>
				<th>Quantity</th>
				<th>Unit price</th>
				<th>Total price</th>
			</tr>
<?php	
		$invoice_total			= 0;
		$sql_service			= "SELECT service_delivery_order.quantity, service_sales_order.description, service_sales_order.unit, service_sales_order.unitprice FROM service_delivery_order
									JOIN service_sales_order ON service_sales_order.id = service_delivery_order.service_sales_order_id
									WHERE service_delivery_order.do_id = '$delivery_order_id'";
		$result_service			= $conn->query($sql_service);
		while($service			= $result_service->fetch_assoc()){
			$description		= $service['description'];
			$quantity			= $service['quantity'];
			$unit				= $service['unit'];
			$price				= $service['unitprice'];
			$total_price		= $price * $quantity;
			
			$invoice_total		+= $total_price;
			
			$sql_invoice		= "SELECT down_payment, ongkir FROM invoices WHERE id = '$invoice_id'";
			$result_invoice		= $conn->query($sql_invoice);
			$invoice			= $result_invoice->fetch_assoc();
			
			$down_payment		= $invoice['down_payment'];
			$delivery_fee		= $invoice['ongkir'];
?>
			<tr>
				<td><?= $description ?></td>
				<td><?= number_format($quantity,2) . ' ' . $unit ?></td>
<?php
			if($taxing			== 1){
?>
				<td>Rp. <?= number_format($price * 10 / 11,2) ?></td>
<?php
			} else {
?>
				<td>Rp. <?= number_format($price,2) ?></td>
<?php
			}

			if($taxing			== 1){
?>
				<td>Rp. <?= number_format($total_price * 10 / 11,2) ?></td>
<?php
			} else {
?>
				<td>Rp. <?= number_format($total_price,2) ?></td>
<?php
			}
?>
			</tr>
<?php
		}	
		if($taxing == 1){
?>
			<tr>
				<td colspan='2'></td>
				<td>Sub total</td>
				<td>Rp. <?= number_format($invoice_total * 10 / 11,2) ?></td>
			</tr>
			<tr>
				<td colspan='2'></td>
				<td>PPn 10%</td>
				<td>Rp. <?= number_format($invoice_total * 1 / 11,2) ?></td>
			</tr>
			<tr>
				<td colspan='2'></td>
				<td>Total</td>
				<td>Rp. <?= number_format($invoice_total,2) ?></td>
			</tr>
<?php
		} else {
?>
			<tr>
				<td colspan='2'></td>
				<td>Total</td>
				<td>Rp. <?= number_format($invoice_total,2) ?></td>
			</tr>
<?php
		}
?>
			<tr>
				<td colspan='2'></td>
				<td>Ongkos kirim</td>
				<td>Rp. <?= number_format($delivery_fee,2) ?></td>
			</tr>
			<tr>
				<td colspan='2'></td>
				<td>Down payment</td>
				<td>Rp. <?= number_format($down_payment,2) ?></td>
			</tr>
			<tr>
				<td colspan='2'></td>
				<td>Grand total</td>
				<td>Rp. <?= number_format($invoice_total + $delivery_fee - $down_payment,2) ?></td>
			</tr>
		</table>
		<button type='button' class='button_danger_dark' id='delete_invoice'>Cancel</button>
		<button type='button' class='button_success_dark' id='confirm_invoice'>Submit</button>
		<script>
			$('#delete_invoice').click(function(){
				$('#delete_invoice_form').submit();
			});
			
			$('#confirm_invoice').click(function(){
				$('#confirm_invoice_form').submit();
			});
		</script>
<?php
		break;
	}
?>