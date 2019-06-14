<?php
	include('accountingheader.php');
	$sql_header = "SELECT * FROM code_bank WHERE id = '" . $_POST['id'] . "'";
	$result_header = $conn->query($sql_header);
	$header = $result_header->fetch_assoc();
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-12'>
			<form action='assign_bank_other_input.php' method='POST' id='input_form'>
				<input type='hidden' value='<?= $_POST['id'] ?>' name='id' readonly>
				<h2><?= $header['name'] ?></h2>
				<p><?= date('d M Y',strtotime($header['date'])) ?></p>
				<hr>
				<table class='table table-hover'>
					<tr>
						<td>Value</td>
						<td>Rp. <?= number_format($header['value']) ?></td>
					</tr>
					<tr>
						<td>Assigned as</td>
						<td><?php
							$sql = "SELECT name,major_id FROM petty_cash_classification WHERE id = '" . $_POST['type'] . "'";
							$result = $conn->query($sql);
							$row = $result->fetch_assoc();
							$new_major = 0;
							if($row['major_id'] == 0){
							} else {
								$sql_head = "SELECT name FROM petty_cash_classification WHERE id = '" . $row['major_id'] . "'";
								$result_head = $conn->query($sql_head);
								$new_major = $row['major_id'];
							}
							$sql_major = "SELECT name FROM petty_cash_classification WHERE id = '" . $new_major . "'";
							$result_major = $conn->query($sql_major);
							$major = $result_major->fetch_assoc();
							echo $row['name'] . ' - ' . $major['name'];
						?>
						<input type='hidden' value='<?= $_POST['type'] ?>' name='type'>
						</td>
					</tr>
					<tr>
						<td>Other information</td>
						<td>
							<?= mysqli_real_escape_string($conn,$_POST['keterangan']) ?>
							<input type='hidden' value='<?= mysqli_real_escape_string($conn,$_POST['keterangan']) ?>' name='keterangan' readonly>
						</td>
					</tr>
				</table>
				<br>
				<button type='button' class='btn btn-default' id='assign_other'>Assign</button>
			</form>
		</div>
	</div>
</div>
<script>
	$('#assign_other').click(function(){
		$('#input_form').submit();
	});
</script>
