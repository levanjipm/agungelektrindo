<?php
	include('../codes/connect.php');
	$maximum 	= 0;
	$total 		= 0;
	
	if(empty($_GET['term']) || $_GET['term'] == 1){
		$sql_invoice	 		= "SELECT COALESCE(SUM(invoices.value + invoices.ongkir),0) AS maximum, COALESCE(SUM(receivable.value),0) as paid
									FROM invoices
									LEFT JOIN receivable ON receivable.invoice_id = invoices.id
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE invoices.isdone = '0'
									GROUP by code_delivery_order.customer_id, receivable.invoice_id ORDER BY maximum DESC";
	} else if($_GET['term'] == 2){
		$parameter_date			= date('Y-m-d',strtotime('-30 days'));
		$sql_invoice	 		= "SELECT COALESCE(SUM(invoices.value + invoices.ongkir),0) AS maximum, COALESCE(SUM(receivable.value),0) as paid
									FROM invoices
									LEFT JOIN receivable ON receivable.invoice_id = invoices.id
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE invoices.isdone = '0' AND invoices.date >= '$parameter_date'
									GROUP by code_delivery_order.customer_id, receivable.invoice_id ORDER BY maximum DESC";
	
	} else if($_GET['term'] == 3){
		$parameter_date_1		= date('Y-m-d',strtotime('-30 days'));
		$parameter_date_2		= date('Y-m-d',strtotime('-45 days'));
		$sql_invoice	 		= "SELECT COALESCE(SUM(invoices.value + invoices.ongkir),0) AS maximum, COALESCE(SUM(receivable.value),0) as paid
									FROM invoices
									LEFT JOIN receivable ON receivable.invoice_id = invoices.id
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE invoices.isdone = '0' AND (invoices.date < '$parameter_date_1' AND invoices.date >= '$parameter_date_2')
									GROUP by code_delivery_order.customer_id, receivable.invoice_id ORDER BY maximum DESC";
	} else if($_GET['term'] == 4){
		$parameter_date_1		= date('Y-m-d',strtotime('-45 days'));
		$parameter_date_2		= date('Y-m-d',strtotime('-60 days'));
		$sql_invoice	 		= "SELECT COALESCE(SUM(invoices.value + invoices.ongkir),0) AS maximum, COALESCE(SUM(receivable.value),0) as paid
									FROM invoices
									LEFT JOIN receivable ON receivable.invoice_id = invoices.id
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE invoices.isdone = '0' AND (invoices.date < '$parameter_date_1' AND invoices.date >= '$parameter_date_2')
									GROUP by code_delivery_order.customer_id, receivable.invoice_id ORDER BY maximum DESC";
	} else if($_GET['term'] == 5){
		$parameter_date			= date('Y-m-d',strtotime('-60 days'));
		$sql_invoice	 		= "SELECT COALESCE(SUM(invoices.value + invoices.ongkir),0) AS maximum, COALESCE(SUM(receivable.value),0) as paid
									FROM invoices
									LEFT JOIN receivable ON receivable.invoice_id = invoices.id
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE invoices.isdone = '0' AND invoices.date < '$parameter_date'
									GROUP by code_delivery_order.customer_id, receivable.invoice_id ORDER BY maximum DESC";
	};

	$result_invoice 		= $conn->query($sql_invoice);
	$invoice				= $result_invoice->fetch_assoc();
	$maximum				= $invoice['maximum'] - $invoice['paid'];
	$number					= mysqli_num_rows($result_invoice);
	
	$timeout 	= 0;
	$i 			= 1;
	if(empty($_GET['term']) || $_GET['term'] == 1){
		$sql		 			= "SELECT COALESCE(SUM(invoices.value + invoices.ongkir),0) AS jumlah, COALESCE(code_delivery_order.customer_id,0) as customer_id, COALESCE(SUM(receivable.value),0) AS paid 
									FROM invoices
									LEFT JOIN receivable ON receivable.invoice_id = invoices.id
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE invoices.isdone = '0'
									GROUP by code_delivery_order.customer_id";
	} else if($_GET['term'] == 2){
		$parameter_date			= date('Y-m-d',strtotime('-30 days'));
		$sql		 			= "SELECT COALESCE(SUM(invoices.value + invoices.ongkir),0) AS jumlah, COALESCE(code_delivery_order.customer_id,0) as customer_id, COALESCE(SUM(receivable.value),0) AS paid
									FROM invoices
									LEFT JOIN receivable ON receivable.invoice_id = invoices.id
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE invoices.isdone = '0' AND invoices.date >= '$parameter_date'
									GROUP by code_delivery_order.customer_id";
	
	} else if($_GET['term'] == 3){
		$parameter_date_1		= date('Y-m-d',strtotime('-30 days'));
		$parameter_date_2		= date('Y-m-d',strtotime('-45 days'));
		$sql		 			= "SELECT COALESCE(SUM(invoices.value + invoices.ongkir),0) AS jumlah, COALESCE(code_delivery_order.customer_id,0) as customer_id, COALESCE(SUM(receivable.value),0) AS paid
									FROM invoices
									LEFT JOIN receivable ON receivable.invoice_id = invoices.id
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE invoices.isdone = '0' AND invoices.date < '$parameter_date_1' AND invoices.date >= '$parameter_date_2'
									GROUP by code_delivery_order.customer_id";
	} else if($_GET['term'] == 4){
		$parameter_date_1		= date('Y-m-d',strtotime('-45 days'));
		$parameter_date_2		= date('Y-m-d',strtotime('-60 days'));
		$sql		 			= "SELECT COALESCE(SUM(invoices.value + invoices.ongkir),0) AS jumlah, COALESCE(code_delivery_order.customer_id,0) as customer_id, COALESCE(SUM(receivable.value),0) AS paid
									FROM invoices
									LEFT JOIN receivable ON receivable.invoice_id = invoices.id
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE invoices.isdone = '0' AND invoices.date < '$parameter_date_1' AND invoices.date >= '$parameter_date_2'
									GROUP by code_delivery_order.customer_id";
	} else if($_GET['term'] == 5){
		$parameter_date			= date('Y-m-d',strtotime('-60 days'));
		$sql		 			= "SELECT COALESCE(SUM(invoices.value + invoices.ongkir),0) AS jumlah, COALESCE(code_delivery_order.customer_id,0) as customer_id, COALESCE(SUM(receivable.value),0) AS paid
									FROM invoices
									LEFT JOIN receivable ON receivable.invoice_id = invoices.id
									JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
									WHERE invoices.isdone = '0' AND invoices.date < '$parameter_date'
									GROUP by code_delivery_order.customer_id";
	};
	$result 			= $conn->query($sql);
	while($row			= $result->fetch_assoc()){
		$customer_id			= $row['customer_id'];
		$receivable				= $row['jumlah'] - $row['paid'];
		$receivable_array[$customer_id]	= $receivable;
	};
	
	arsort($receivable_array);
?>
	<label>Term</label>
	<select class='form-control' id='terms' style='width:150px'>
		<option value='1' <?php if($_GET['term'] == 1 || empty($_GET['term'])){ echo 'selected'; }; ?>>Show all</option>
		<option value='2' <?php if($_GET['term'] == 2){ echo 'selected'; } ?>>Less than 30 days</option>
		<option value='3' <?php if($_GET['term'] == 3){ echo 'selected'; } ?>>30 - 45 days</option>
		<option value='4' <?php if($_GET['term'] == 4){ echo 'selected'; } ?>>45 - 60 days</option>
		<option value='5' <?php if($_GET['term'] == 5){ echo 'selected'; } ?>>More than 60 days</option>
	</select>
	<br>
<?php
	foreach($receivable_array as $bar){
		$r		= ($i * 161 / $number) + 14;
		$g		= ($i * 160 / $number) + 63;
		$b		= ($i * 128 / $number) + 102;
		$rgb	= $r . ',' . $g . ',' . $b;
		$customer_id				= key($receivable_array);
		$sql_customer			 	= "SELECT name FROM customer WHERE id = '$customer_id'";
		$result_customer 			= $conn->query($sql_customer);
		$customer 					= $result_customer->fetch_assoc();
		if($customer_id == 0){
			$customer_name			= 'Retail';
		} else {
			$customer_name			= $customer['name'];
		}
		
		if($customer_id != 0){
?>
	<div class='row garis_wrapper' onclick='view_receivable(<?= $customer_id ?>)' style='cursor:pointer'>
<?php
		} else {
?>
	<a href='customer_view.php' style='color:black;text-decoration:none'>
		<div class='row garis_wrapper'>
<?php
		}
?>
		<div class='col-sm-3'><?= $customer_name ?></div>
		<div class='col-sm-6'><div class='row garis' style='width:0%;background-color:rgb(<?= $rgb ?>)' id='garis<?= $customer_id ?>'></div>
		</div>
		<div class='col-sm-2'>Rp. <?= number_format($bar,2) ?></div>
	</div>
<?php
	if($customer_id == 0){
?>
	</a>
<?php
	} else {
?>
	</div>
<?php
	}
?>
	<script>
		$(document).ready(function(){
			setTimeout(function(){
				$("#garis<?= $customer_id ?>").animate({
					width: '<?= $bar * 100 / $maximum ?>%'
				})
			},<?= $timeout ?>)
		});
	</script>
<?php
		$timeout = $timeout + 10;
		next($receivable_array);
		$i++;
	}
?>

<div class='full_screen_wrapper' id='view_receivable_wrapper'>
	<button type='button' class='full_screen_close_button'>&times </button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function view_receivable(n){
		$.ajax({
			url:'receivable_dashboard_view',
			data:{
				id:n,
			},
			type:"GET",
			success:function(response){
				$('#view_receivable_wrapper .full_screen_box').html(response);
				$('#view_receivable_wrapper').fadeIn();
			}
		});
	}
	
	$('.full_screen_close_button').click(function(){
		$(this).parent().fadeOut();
	});
	
	$('#terms').change(function(){
		$.ajax({
			url:'receivable_dashboard_chart.php',
			data:{
				term:$('#terms').val()
			},
			success:function(response){
				$('#view_pane').html(response);
			}
		})
	});
</script>