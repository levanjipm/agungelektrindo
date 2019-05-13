<?php
	include("inventoryheader.php");
?>
<div class="main">
<?php
$so_id = $_POST["id"];
$do_date = $_POST['today'];
$customer_id = $_POST['customer_id'];
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
	$taxing = $_POST['tax'];
	$sql_number = "SELECT * FROM code_delivery_order WHERE MONTH(date) = MONTH('" . $do_date . "') AND YEAR(date) = YEAR('" . $do_date . "') AND isdelete = '0' ORDER BY number ASC";
	$results = $conn->query($sql_number);
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
	$do_number_preview = "SJ-AE-" . str_pad($nomor,2,"0",STR_PAD_LEFT) . $tax_preview . "." . date("d",strtotime($do_date)). "-" . $month. "-" . date("y",strtotime($do_date));
	$sql = "SELECT * FROM code_salesorder WHERE id = '" . $so_id . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$po_number = $row['po_number'];
		$customer_id = $row['customer_id'];
		$delivery_id = $row['delivery_id'];
	};
	$sql_customer = "SELECT * FROM customer WHERE id = '" . $customer_id . "'";
	$res = $conn->query($sql_customer);
	while($ro = $res->fetch_assoc()){
		$customer_name = $ro['name'];
		$customer_address = $ro['address'];
		$customer_city = $ro['city'];
	}
	$s = $_POST['jumlah'];

?>
<style type="text/css">
    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
</style>
<div class="container">
	<form method="POST" action="do_input.php" id='do_fix'>
		<input type="hidden" value="<?= $so_id ?>" name="so_id">
		<input type="hidden" value="<?=$customer_id?>" name="customer">
		<input type="hidden" value=<?=$taxing?>" name="tax">
		<input type="date" value="<?=$do_date?>" style="display:none" name="do_date">
		<input type="hidden" value="<?=$nomor?>" name="do_number">
		<div class="row">
			<div class="col-lg-2">
				<img src="../universal/images/logogudang.jpg" style="width:100%;height:auto">
			</div>
			<div class="col-lg-5" style="line-height:0.6">
				<h3><b>Agung Elektrindo</b></h3>
				<p>Jalan Jamuju no. 18,</p>
				<p>Bandung, 40114</p>
				<p><b>Ph.</b>(022) - 7202747 <b>Fax</b>(022) - 7212156</p>
				<p><b>Email :</b>AgungElektrindo@gmail.com</p>
			</div>
			<div class="col-lg-4 offset-lg-1" style="padding:20px">
				<div class="col-lg-3">
					<p><b>Tanggal:</b></p>
				</div>
				<div class="col-lg-6"><?php echo date('d M Y',strtotime($do_date));?></div>
				<div class="col-lg-12">
					<p>Kepada Yth. <b><?= $customer_name ?></b></p>
					<p><?= $customer_address ?></p>
					<p><?= $customer_city ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<div class="col-lg-4">
					<p><b>Nomor DO:</b></p>
				</div>
				<div class="col-lg-3">
					<p><?= $do_number_preview ?></p>
					<input type="hidden" name="do_name" value="<?= $do_number_preview ?>">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8">
				<div class="col-lg-4">
					<p><b>Nomor Purchase Order:</b></p>
				</div>
				<div class="col-lg-3">
					<p><?= $po_number ?></p>
				</div>
			</div>
		</div>
		<br>
		<table class="table" id="myTable">
			<thead>
				<th style="width:40%">Item name </th>
				<th style="width:30%">Reference</th>
				<th style="width:30%">Quantity</th>
			</thead>
			<tbody>
<?php
		for ($i = 1; $i < $s; $i++){
			$item = $_POST['ref' . $i];
			$qty = $_POST['qty_send' . $i];
			//Check if user changes the validation in front-end security//
			$sql_check = "SELECT quantity FROM sales_order_sent WHERE so_id = '" . $so_id . "' AND reference = '" . $item . "'";
			$result_check = $conn->query($sql_check);
			$check = $result_check->fetch_assoc();
			$quantity_sent = $check['quantity'];
			
			$sql_check_again = "SELECT quantity FROM sales_order WHERE so_id = '" . $so_id . "' AND reference = '" . $item . "'";
			$result_check_again = $conn->query($sql_check_again);
			$check_again = $result_check_again->fetch_assoc();
			$quantity_ordered = $check_again['quantity'];
			
			if($qty + $quantity_sent > $quantity_ordered){
				break;
				header('do_exist_dashboard.php');
			}
			$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $item . "'";
			$result = $conn->query($sql_item);
			if ($result->num_rows > 0){
				$row_item = $result->fetch_assoc();
				$item_description = $row_item['description'];
			} else {
				$item_description = '';
			};
?>
<?php
?>
			<tr>
				<td>
					<?=$item_description?>
				</td>
				<td>
					<?=$item?>
					<input type="hidden" name="item<?= $i ?>" value="<?=$item?>">
				</td>
				<td>
					<?=$qty?>
					<input type="hidden" name="qty<?= $i ?>" value="<?=$qty?>">
				</td>
			</tr>
<?php
		}
?>
			</tbody>
		</table>
		<input type="hidden" id="number_of_rows" name="jumlah">
		<br><br><br>
		<div class="row">
			<div class="col-lg-6 offset-lg-3" style="text-align:center">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="hitung_row()">Next</button>
			</div>
		</div>
		<div id="myModal" class="modal" role="dialog">
			<div class="modal-dialog">	
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Proceeding Delivery Order</h3>
					</div>
					 <div class="modal-body">
						<h4>Disclaimer</h4>
						<p>By clicking on submit button, you are responsible for any risk of this delivery order</p>
						<p><b>Please check a couple of times if you must</b></p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success">Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
function hitung_row(){
	var rowCount = $('#myTable tr').length;
	var rowCountReal = rowCount - 1;
	$('input[id=number_of_rows]').val(rowCountReal);
	$('#do_fix').submit();
};
</script>