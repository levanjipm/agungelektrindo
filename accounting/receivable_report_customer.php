<?php
	include('accountingheader.php');
?>
<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("sortableTable");
  switching = true;
  dir = "asc"; 
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("td")[n];
      y = rows[i + 1].getElementsByTagName("td")[n];
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++; 
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Receivable</h2>
	<p>Create report</p>
	<hr>
	<table class='table table-hover' id='sortableTable'>
		<tr>
			<th onclick='sortTable(0)' style='cursor:pointer'>Customer</th>
			<th onclick='sortTable(1)' style='cursor:pointer'>Total receivable</th>
			<th onclick='sortTable(2)' style='cursor:pointer'>< 30 days</th>
			<th onclick='sortTable(3)' style='cursor:pointer'>30 - 45 days</th>
			<th onclick='sortTable(4)' style='cursor:pointer'>45 - 60 days</th>
			<th onclick='sortTable(5)' style='cursor:pointer'>More than 60 days</th>
			<th></th>
		</tr>
	
<?php
	$sql = "SELECT SUM(invoices.value) as total_piutang, code_delivery_order.customer_id , customer.name
	FROM invoices
		JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
		JOIN customer ON code_delivery_order.customer_id = customer.id
	WHERE invoices.isdone = '0' GROUP BY code_delivery_order.customer_id";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_30 = "SELECT SUM(invoices.value) AS less_than_30 FROM invoices
		JOIN code_delivery_order
		ON code_delivery_order.id = invoices.do_id
		WHERE invoices.isdone = '0' AND invoices.date >= '" . date('Y-m-d',strtotime('-30 days')) . "'
		AND code_delivery_order.customer_id = '" . $row['customer_id'] . "'";
		$result_30 = $conn->query($sql_30);
		$row_30 = $result_30->fetch_assoc();
		
		$sql_45 = "SELECT SUM(invoices.value) AS less_than_45 FROM invoices
		JOIN code_delivery_order
		ON code_delivery_order.id = invoices.do_id
		WHERE invoices.isdone = '0' AND invoices.date < '" . date('Y-m-d',strtotime('-30 days')) . "' 
		AND invoices.date > '" . date('Y-m-d',strtotime('-45 days')) . "'
		AND code_delivery_order.customer_id = '" . $row['customer_id'] . "'";;
		$result_45 = $conn->query($sql_45);
		$row_45 = $result_45->fetch_assoc();
		
		$sql_60 = "SELECT SUM(invoices.value) AS less_than_60 FROM invoices
		JOIN code_delivery_order
		ON code_delivery_order.id = invoices.do_id
		WHERE invoices.isdone = '0' AND invoices.date < '" . date('Y-m-d',strtotime('-45 days')) . "' 
		AND invoices.date > '" . date('Y-m-d',strtotime('-60 days')) . "'
		AND code_delivery_order.customer_id = '" . $row['customer_id'] . "'";;
		$result_60 = $conn->query($sql_60);
		$row_60 = $result_60->fetch_assoc();
		
		$sql_nunggak = "SELECT SUM(invoices.value) AS nunggak FROM invoices
		JOIN code_delivery_order
		ON code_delivery_order.id = invoices.do_id
		WHERE invoices.isdone = '0' AND invoices.date <= '" . date('Y-m-d',strtotime('-60 days')) . "'
		AND code_delivery_order.customer_id = '" . $row['customer_id'] . "'";;
		$result_nunggak = $conn->query($sql_nunggak);
		$nunggak = $result_nunggak->fetch_assoc();
?>
		<tr>
			<td><?= $row['name'] ?></td>
			<td>Rp. <?= number_format($row['total_piutang'],2) ?></td>
			<td>Rp. <?= number_format($row_30['less_than_30'],2) ?></td>
			<td>Rp. <?= number_format($row_45['less_than_45'],2) ?></td>
			<td>Rp. <?= number_format($row_60['less_than_60'],2) ?></td>
			<td>Rp. <?= number_format($nunggak['nunggak'],2) ?></td>
			<td>
				<a href='receivable_report_customer_report.php?customer_id=<?= $row['customer_id'] ?>' style='text-decoration:none'>
					<button type='button' class='btn btn-default' title='Report <?= $row['name'] ?>' id='receivable_report(<?= $row['customer_id'] ?>)'>
						<i class="fa fa-flag-o" aria-hidden="true"></i>
					</button>
				</a>
			</td>
		</tr>
<?php
	}
?>
</div>