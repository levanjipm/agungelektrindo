<?php
	include('tutorial_header.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Tutorial</h2>
	<hr>
	<h3 style='font-family:bebasneue'>Departemen penjualan</h3>
	<p>Departemen penjualan merupakan departemen dalam CV Agung Elektrindo yang berfungsi untuk melayani transaksi penjualan dari CV Agung Elektrindo ke pelanggan.</p>
	<br>
	<table class='table table-bordered'>
		<tr>
			<th style='width:30%'>Nama tugas</th>
			<th style='width:50%'>Deskripsi tugas</th>
			<th style='width:20%'></th>
		</tr>
		<tr>
			<td><p>Order Pembelian (<i><strong>purchase order</strong></i>)</p></td>
			<td><p>Order pembelian merupakan sebuah kontrak antara CV Agung Elektrindo dengan supplier untuk memesan sejumlah barang dengan harga yang mengikat.</p></td>
			<td>
				<a href='sales_create_quotation'>
					<button type='button' class='button_default_dark'>Go to</button>
				</a>
			</td>
		</tr>
		<tr>
			<td><p>Data supplier</p></td>
			<td><p>Menambah supplier untuk dapat dibuatkan order pembelian.</p></td>
			<td>
				<a href='sales_create_sales_order'>
					<button type='button' class='button_default_dark'>Go to</button>
				</a>
			</td>
		</tr>
		<tr>
			<td><p>Data barang</p></td>
			<td><p>Menambah, menyunting, atau menghapus data barang dapat dilakukan pada fitur ini. Data barang akan digunakan oleh departemen - departemen lain seperti penjualan dan gudang.</p></td>
			<td>
				<a href='sales_create_sales_order'>
					<button type='button' class='button_default_dark'>Go to</button>
				</a>
			</td>
		</tr>
		<tr>
			<td><p>Retur pembelian</p></td>
			<td><p>Retur pembelian dibuat apabila CV Agung ELektrindo berencana mengembalikan barang yang telah dibeli sebelumnya dan telah dikonfirmasi pengirimannya oleh bagian gudang.
					Retur dapat dilakukan dengan beberapa ketentuan yang akan dijelaskan selanjutnya.</p></td>
			<td>
				<a href='sales_create_sales_order'>
					<button type='button' class='button_default_dark'>Go to</button>
				</a>
			</td>
		</tr>
	</table>
	<br>
	<a href='tutorial'>
		<button type='button' class='button_success_dark'>
			Back
		</button>
	</a>
</div>