<?php
	include("accountingheader.php")
?>
<body>
	<div class="main">
		<div class="row" style="padding:30px">
			<div class="col-lg-6" style="text-align:center">
				<a  href="invoiceexist_dashboard.php" class="btn btn-success">Pick from existing Sales Order</a>
				<br><br>
				<p>Choose a sales order to create the invoice,</p>
				<p>and the default settings has already been installed automatically</p>
			</div>
			<div class="col-lg-6" style="text-align:center">
				<a href="#" class="btn btn-danger">Create random Invoice</a>
				<br><br>
				<p>Cases which there is <b>no sales order available</b></p>
				<p>Input every data manually, there are no settings installed</p>
			</div>
		</div>
	</div>
</body>