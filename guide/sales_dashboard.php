<?php
	include('tutorial_header.php');
?>
<style>
.box{
	border:1px solid rgba(255, 79, 66,1);;
	text-align:center;
	padding:10px 30px;
	width:100%;
	display:inline-block;
	background-color:rgba(255, 91, 79,0.8);
	cursor:pointer;
}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Tutorial</h2>
	<hr>
	<h3 style='font-family:bebasneue'>Departemen penjualan</h3>
	<p>Departemen penjualan merupakan departemen dalam CV Agung Elektrindo yang berfungsi untuk melayani transaksi penjualan dari CV Agung Elektrindo ke pelanggan.</p>
	<br>
	<div class='row' style='text-align:center'>
		<div class='col-sm-3'>
			<a href='sales_create_quotation.php' style='text-decoration:none;color:#333'>
				<div class='box'>
					<h3 style='font-family:bebasneue'>Create quotation</h3>
				</div>
			</a>
		</div>
		<div class='col-sm-3'>
			<a href='sales_create_sales_order.php' style='text-decoration:none;color:#333'>
				<div class='box'>
					<h3 style='font-family:bebasneue'>Create sales order</h3>
				</div>
			</a>
		</div>
	</div>
</div>